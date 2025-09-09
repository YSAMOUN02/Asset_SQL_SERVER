<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Fix_assets;
use App\Models\Image;
use App\Models\RawFixAssets;
use App\Models\StoredAssets;
use App\Models\movement;
use App\Models\User_property;
use App\Models\Asset_variant;
use App\Models\New_assets;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate; // For proper column conversion
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


class AssetsController extends Controller
{
    // Turn to Asset Add View
    public function assetes_add()
    {
        if(Auth::user()->permission->assets_write != 1){

            return redirect('/')->with('error','You do not has permission Assets write.');
        }
        return view('backend.add-assets');
    }
    public function list_transaction($page)
    {
       $viewpoint = User_property::where('user_id',Auth::user()->id)->where('type','viewpoint')->first();
        $limit = $viewpoint->value ?? 50;



        $count_post = movement::count();
        $total_page = ceil($count_post / $limit);
        $offset = 0;
        if ($page != 0) {
            $offset = ($page - 1) * $limit;
        }

        $sql =  movement::orderBy('assets_id', 'desc');

        if(Auth::user()->role == 'admin'){
            $sql->where('deleted',0);

        }

            $sql->limit($limit);
            $sql->offset($offset);

            $asset = $sql->get();

        return view('backend.transaction', [
            'asset' => $asset,
            'total_page' => $total_page,
            'page' => $page,
            'total_assets' => $count_post,
            'total_page' => $total_page,
            'limit' =>  $limit
        ]);



    }



    public function list_assets($page)
    {
      $viewpoint = User_property::where('user_id',Auth::user()->id)->where('type','viewpoint')->first();
        $limit = $viewpoint->value ?? 50;

        // if(Auth::user()->permission->assets_read == 1 && Auth::user()->role == 'admin'){

        $count_post = StoredAssets::where("last_varaint", 1)->count();
        $total_page = ceil($count_post / $limit);
        $offset = 0;
        if ($page != 0) {
            $offset = ($page - 1) * $limit;
        }

        $asset =  StoredAssets::orderBy('assets_id', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->where("status", 1)

            ->get();

        return view('backend.assets_list', [
            'asset' => $asset,
            'total_page' => $total_page,
            'page' => $page,
            'total_assets' => $count_post,
            'total_page' => $total_page,
            'limit' =>  $limit
        ]);
    }



    // Select Raw
    public function list_select($page)
    {

        if (Auth::user()->permission->assets_write == 1) {
            $limit = 150;
            $data = RawFixAssets::select(
                'assets',
                'invoice_no',
                'description',
                'fa_subclass',
                'fa_class_code',
                'fa',
                'state',
                DB::raw("FORMAT(posting_date, 'yyyy-MM-dd') as assets_date")

            );
            $count_post = $data->count();

            $total_page = ceil($count_post / $limit);
            $offset = 0;
            if ($page != 0) {
                $offset = ($page - 1) * $limit;
            }

            $data->limit($limit);
            $data->offset($offset);
            $data->orderBy('assets_date', 'desc');

            $datas = $data->get();

            // Get all assets1 that are already registered using Eloquent
            $registeredAssets = movement::pluck('assets1')->toArray();

            // Add a new field `is_registered` to each ERP asset
            $datas->transform(function ($item) use ($registeredAssets) {
                $item->is_registered = in_array($item->assets, $registeredAssets);
                return $item;
            });

            return view('backend.list-select', [
                'data' => $datas,
                'total_page' => $total_page,
                'page' => $page,
                'total_record' => $count_post,


            ]);
        } else {
            return redirect('/')->with('fail', 'You do not have permission Assets Write.');
        }
    }

    // Add New Asset Via Selet on List Invoice
    public function assets_add($assets, $invoice)
    {

        if(Auth::user()->permission->assets_write != 1){

            return redirect('/')->with('error','You do not has permission Assets write.');
        }

        if (Auth::user()->permission->assets_write == 1) {
            if ($invoice != "NA") {
                $modifiedString = str_replace('-', '/', $invoice);
            }


            // return $modifiedString;
            $sql = Fix_assets::where('assets', $assets);
            if ($invoice != "NA") {
                $sql->where("fa", $modifiedString);
            }

            $existed_asset = StoredAssets::where('assets1', $assets)
                ->first();
            if ($existed_asset) {
                return redirect('/admin/assets/add/1')->with('fail', 'This Asset Code ' . $assets . ' is already existed. Pls Create Movement Process.');
            }

            $asset = $sql->first();
            $no_invoice = 1;
            if (!$asset) {
                $no_invoice = 0;
            }

            return view('backend.add-assets', [
                'asset' => $asset,
                'no_invoice' => $no_invoice
            ]);
        } else {
            return redirect('/')->with('fail', 'You do not have permission Assets Write.');
        }
    }
    public function assets_add_submit(Request $request)
    {

        // ✅ Validate required fields
        $request->validate([
            'assets1' => 'required|string|max:255',
            'item'    => 'required|string|max:255',
        ]);

        $asset = new Movement();
        $columns = $asset->getFillable();

        foreach ($columns as $field) {
            // Skip backend fields so we don’t overwrite them
            if (in_array($field, ['status', 'variant', 'last_varaint', 'deleted'])) {
                continue;
            }

            $value = $request->$field ?? '';

            // ✅ Convert date fields
            if (in_array($field, ['transaction_date', 'dr_date', 'invoice_date', 'deleted_at'])) {
                $asset->$field = $value ? Carbon::parse($value)->format('Y-m-d') : '';
            }
            // ✅ Convert decimals
            elseif (in_array($field, ['cost', 'vat'])) {
                $asset->$field = is_numeric($value) ? (float)$value : 0; // default 0
            }
            // ✅ Strings & other fields
            else {
                $asset->$field = $value;
            }
        }

        // ✅ Ensure special inputs are assigned
        $asset->assets1   = $request->assets1 ?? '';
        $asset->assets2   = $request->assets2 ?? '';
        $asset->reference = $request->reference ?? '';

        // ✅ Set backend fields (unchanged)
        $asset->status       = 1;
        $asset->variant      = 1;
        $asset->last_varaint = 1;
        $asset->deleted      = 0;

        $stored = $asset->save();
        if ($stored) {
            // Update all existing records to status 0
            movement::where('assets1', $asset->assets1)
                ->where('assets_id', '<>', $asset->assets_id)
                ->where('status', 1)
                ->update(['status' => 0]);
        }
        $newAssetId = $asset->assets_id;

        // ✅ Insert into change log
        foreach ($asset->getAttributes() as $column => $value) {
            if ($value !== '' && !in_array($column, ['status', 'variant', 'last_varaint', 'deleted', 'deleted_at'])) {
                $reason = !empty($asset->invoice_no)
                    ? "New asset added by Invoice: " . $asset->invoice_no
                    : "New asset added";

                $this->storeChangeLog(
                    $record_id  = $newAssetId,
                    $record_no  = $asset->assets1,
                    $oldValues  = null,
                    $newValues  = $column . ' : ' . $value,
                    $action     = 'Insert',
                    $table      = 'Asset Record',
                    $reason     = $reason
                );
            }
        }

        // ✅ Handle uploaded files
        if ($request->file_state > 0) {
            for ($i = 1; $i <= $request->file_state; $i++) {
                $fileKey = 'file_doc' . $i;
                if ($request->hasFile($fileKey)) {
                    $file     = $request->file($fileKey);
                    $fileName = $this->upload_file($file);
                    $fileModel = new File();
                    $fileModel->asset_id = $newAssetId;
                    $fileModel->variant  = 1;
                    $fileModel->file     = $fileName;
                    $fileModel->save();
                }
            }
        }

        // ✅ Handle uploaded images
        if ($request->image_state > 0) {
            for ($i = 1; $i <= $request->image_state; $i++) {
                $imageKey = 'image' . $i;
                if ($request->hasFile($imageKey)) {
                    $file      = $request->file($imageKey);
                    $thumbnail = $this->upload_image(
                        $file,
                        ($asset->assets1 . $asset->assets2) ?? "",
                        1,
                        $i
                    );

                    $imageModel = new Image();
                    $imageModel->asset_id = $newAssetId;
                    $imageModel->variant  = 1;
                    $imageModel->image    = $thumbnail;
                    $imageModel->save();
                }
            }
        }

        return redirect('/admin/assets/1')->with('success', 'Added 1 Asset Record.');
    }



    public function update_and_view_asset($state, $id, $variant)
    {


        $asset_main = movement::with([
            'images',
            'files',
            'assets_variant' => function ($query) {
                $query->orderBy('variant', 'desc');
            }
        ])
            ->where('assets_id', $id)
            ->first();

        // return $asset_main ;

        if (!$asset_main) {
            return  redirect()->back()->with('error', 'Not Found!');
        }
        return view('backend.update-assets-by-variant', [
            'asset_main' => $asset_main,
            'variant' => $variant,
            // 'qr_code' => $qr_code,
            'state' => $state
        ]);
    }
    public function update_submit(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Find the asset
            $asset = Movement::findOrFail($request->assets_id);

            // 2. Save old values
            $oldValues = $asset->toArray();

            // 3. Copy old record into assets_variant (keep the OLD variant number here)
            $variantData = $asset->toArray();
            unset($variantData['id']); // remove PK
            $variantData['assets_id'] = $asset->assets_id;
            $variantData['variant'] = $asset->variant; // ✅ store the old variant
            Asset_Variant::create($variantData);

            // 4. Update main asset (assign new values + increment variant)
            $newVariant = $asset->variant + 1;
            $asset->fill($request->all());
            if ($request->filled('transaction_date')) {
                $asset->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d');
            }
            $asset->variant = $newVariant; // ✅ now bump main asset to new variant
            $asset->deleted = 0; //prevent new deleted
            // return $asset;
            $asset->save();

            // 5. Detect changes per column
            $newValues = $asset->toArray();

            foreach ($newValues as $column => $newValue) {
                $oldValue = $oldValues[$column] ?? null;

                // Handle date columns (ignore time)
                if (in_array($column, ['transaction_date', 'dr_date', 'invoice_date', 'updated_at'])) {
                    $oldValue = !empty($oldValue) && $oldValue != '1900-01-01'
                        ? Carbon::parse($oldValue)->format('Y-m-d')
                        : null;
                    $newValue = !empty($newValue) && $newValue != '1900-01-01'
                        ? Carbon::parse($newValue)->format('Y-m-d')
                        : null;
                }

                // Only log if values differ
                if ($oldValue != $newValue) {
                    $this->storeChangeLog(
                        $asset->assets_id,
                        $asset->assets1,
                        $column . ': ' . $oldValue,
                        $column . ': ' . $newValue,
                        'update',
                        'Assets Variant',
                        $request->reason ?? 'Asset updated'
                    );
                }
            }


            DB::commit();

            // Handle Update Existed Image Variant
            if ($request->input('state_stored_image') > 0) {

                $image_qty = $request->input('state_stored_image');
                for ($i = 1; $i <= $image_qty; $i++) {
                    $imageName = $request->input('image_stored' . $i);

                    if (!empty($imageName)) {
                        $old_image = Image::where('image', $imageName)
                            ->where('asset_id', $request->assets_id)
                            ->first();


                        if ($old_image) {
                            $new_v_image = new Image();
                            $new_v_image->asset_id = $request->assets_id;
                            $new_v_image->image = $imageName;
                            $new_v_image->variant = $variantData['variant'] + 1;
                            $new_v_image->save();
                        }
                    }
                }
            }

            if ((int)$request->input('image_state') > 0) {

                $total_image = (int)$request->input('image_state');
                $no = Image::where('asset_id', $request->assets_id)
                    ->count();

                for ($i = 1; $i <= $total_image; $i++) {
                    $imageKey = 'image' . $i;
                    if ($request->hasFile($imageKey)) {
                        $file = $request->file($imageKey);
                        $no++;
                        $thumbnail = $this->upload_image($file, ($request->assets1 . $request->assets2) ?? "", $variantData['variant'] + 1, $no);
                        $imageModel = new Image();
                        $imageModel->asset_id = $request->assets_id;
                        $imageModel->variant  = $variantData['variant'] + 1;
                        $imageModel->image    = $thumbnail;
                        $imageModel->save();
                    }
                }
            }

            // ✅ Redirect to the new variant page
            return redirect('/admin/assets/data/' . $request->state . '/id=' . $asset->assets_id . '/variant=' . $newVariant)
                ->with('success', 'Asset updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }




    public function remove_existed_file($request)
    {
        $file = File::where("asset_id", $request->id)->select('id', 'file')->get();
        $arr_file = [];
        $arr_stored_file = [];
        if ($request->state_stored_file > 0) {
            for ($i = 1; $i <= $request->state_stored_file; $i++) {
                $input = "file_stored" . $i;
                if (!empty($request->input($input))) {
                    array_push($arr_file, $request->input($input));
                }
            }
        }
        foreach ($file as $item) {
            array_push($arr_stored_file, $item->file);
        }
        $delete_value = array_diff($arr_stored_file, $arr_file);
        foreach ($delete_value as $item) {
            $filePath = public_path("uploads/files/" . $item);
            // return $filePath;
            if (file_exists($filePath)) {
                unlink($filePath);

                foreach ($file  as $id) {
                    if ($id->file == $item) {

                        File::where('id', $id->id)->delete();
                    }
                }
            } else {
            }
        }
    }



    public function update_existing_to_new_varaint($request, $id, $varaint)
    {
        if ($request->state_stored_file > 0) {
            for ($i = 1; $i <= $request->state_stored_file; $i++) {
                $input = "file_stored" . $i;
                if (!empty($request->input($input))) {
                    $file = new File();
                    $file->asset_id = $id;
                    $file->varaint = $varaint;
                    $file->file = $request->input($input);
                    $file->save();
                }
            }
        }
        if ($request->state_stored_image > 0) {
            for ($i = 1; $i <= $request->state_stored_image; $i++) {
                $input = "image_stored" . $i;
                if (!empty($request->input($input))) {
                    $file = new Image();
                    $file->asset_id = $id;
                    $file->varaint = $varaint;
                    $file->image = $request->input($input);
                    $file->save();
                }
            }
        }
    }


    public function delete_admin_asset(Request $request)
    {

        $asset_delete = movement::where('assets_id', $request->id)->first();

        if (!$asset_delete) {
            return redirect()->back()->with('fail', "Opps. Something went wrong.");
        }

        // Capture old values before change
        $oldValues = 'deleted = ' . $asset_delete->deleted . ', status = ' . $asset_delete->status . ', deleted_at = ' . $asset_delete->deleted_at;
        // return $request->reason;
        // Soft delete
        $asset_delete->deleted = 1;
        $asset_delete->deleted_at = now();
        $deleted = $asset_delete->save();
        $newValues = 'deleted = ' . $asset_delete->deleted . ', status = ' . $asset_delete->status . ', deleted_at = ' .$asset_delete->deleted_at;
        if ($deleted) {

            // storeChangeLog($record_id,$record_no, $oldValues, $newValues, $action, $table, $reason)
            $this->storeChangeLog($asset_delete->assets_id, $asset_delete->assets1 . $asset_delete->assets2, $oldValues, $newValues, 'Delete', 'Assets', $request->reason ?? 'No reason provided');
            // $this->initailize_record($request->id);
            return redirect()->back()->with('success', "Delete Record Success.");
        } else {
            return redirect()->back()->with('fail', "Opps. Something went wrong.");
        }
    }
    public function print_qr($assets)
    {

        if (Auth::user()->permission->assets_read == 1) {
            $qr_code = QrCode::size(50)->format('svg')->generate($assets);

            // Save the SVG to temporary storage
            $svgContent = $qr_code;
            Storage::disk('public')->put('qrcodes/my-qrcode.svg', $svgContent);

            return view('backend.print-qr', ['qr_code' => $qr_code, 'raw' => $assets]);
        } else {
            return redirect('/')->with('fail', 'You do not have permission Assets Read.');
        }
    }

    public function multi_print(Request $request)
    {
        $id = explode(',', $request->id);

        $count = count($id);
        $array_qr = [];

        if ($count > 0) {
            foreach ($id as $item) {

                $object = StoredAssets::where('assets_id', $item)->first();
                if ($object != null) {

                    array_push($array_qr, $object);
                }
            }
        }
        $count_array_qr = count($array_qr);


        // if($count_array_qr != 0){
        //     // return $array_qr;
        //     return view('backend.print-qr', ['array_qr' => $array_qr]);
        // }else{
        //     if ($count > 0) {
        //         foreach ($id as $item) {

        //             $object = StoredAssets::where('id', $item)->where('last_varaint',1)->first();
        //             if($object != null){
        //                 array_push($array_qr, $object);
        //             }

        //         }
        // }
        if ($count_array_qr != 0) {

            return view('backend.print-qr', ['array_qr' => $array_qr]);
        } else {
            return redirect('/admin/assets/list/1')->with('fail', 'Opps. Somthing went wronge.');
        }
    }

    public function multi_export(request $request)
    {

        if (Auth::user()->permission->assets_read == 1) {
            $ids = explode(',', $request->id_export);
            sort($ids);
            $data = [];
            foreach ($ids as $id) {
                $assets =  StoredAssets::where('assetS_id', $id)->where("last_varaint", 1)
                    ->with(['images'])

                    ->first();
                if ($assets) {
                    Array_push($data, $assets);
                }
            }

            // return $data;
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $headers = [
                'A1' => 'ID',
                'B1' => 'Assets',
                'C1' => 'Refference',
                'D1' => 'Fix Assets No',
                'E1' => 'Item',
                'F1' => 'Issue Date',
                'G1' => 'Initial Condition',
                'H1' => 'Specifications',
                'I1' => 'Item Description',
                'J1' => 'Assets Group',
                'K1' => 'Assets Remark',
                'L1' => 'Created At',
                'M1' => 'Assets Holder ID',
                'N1' => 'Name',
                'O1' => 'Position/Title',
                'P1' => 'Location',
                'Q1' => 'Department',
                'R1' => 'Company',
                'S1' => 'Assets Holder Remark',
                'T1' => 'GRN',
                'U1' => 'PO No',
                'V1' => 'PR',
                'W1' => 'DR',
                'X1' => 'DR request by',
                'Y1' => 'DR Date',
                'Z1' => 'Internal Document Remark',
                'AA1' => 'Assets Code (Account)',
                'AB1' => 'Invoice Date',
                'AC1' => 'Invoice No',
                'AD1' => 'Fix Asset No',
                'AE1' => 'Fix Asset Class',
                'AF1' => 'Fix Asset Sub Class',
                'AG1' => 'Depreciation Book Code',
                'AH1' => 'FA Posting Type',
                'AI1' => 'FA Location',
                'AJ1' => 'Cost',
                'AK1' => 'Currency',
                'AL1' => 'VAT',
                'AM1' => 'Description',
                'AN1' => 'Invoice Description',
                'AO1' => 'Vendor No',
                'AP1' => 'Vendor Name',
                'AQ1' => 'Address',
                'AR1' => 'Address 2',
                'AS1' => 'Contact',
                'AT1' => 'Phone',
                'AU1' => 'E-Mail',
                'AV1' => 'path',
                'AW1' => 'Image',
            ];
            // return $data;
            // Set headers in Excel
            foreach ($headers as $cell => $header) {
                $sheet->setCellValue($cell, $header);
            }
            $row = 2; // Starting from the second row as the first row is for headers
            foreach ($data as $assets) {



                // Assets Info
                $sheet->setCellValue('A' . $row, $assets->id);  // ID in column A
                $sheet->setCellValue('B' . $row, $assets->assets1 . $assets->assets2 ?? '');  // Combine assets1 and assets2 in column B
                $sheet->setCellValue('C' . $row, $assets->document);  // Document in column C
                $sheet->setCellValue('D' . $row, $assets->fa_no);  // Fix Assets No in column D
                $sheet->setCellValue('E' . $row, $assets->item);  // Item in column E
                $sheet->setCellValue('F' . $row, $assets->transaction_date);  // Issue Date in column F
                $sheet->setCellValue('G' . $row, $assets->initial_condition);  // Initial Condition in column G
                $sheet->setCellValue('H' . $row, $assets->specification);  // Specifications in column H
                $sheet->setCellValue('I' . $row, $assets->item_description);  // Item Description in column I
                $sheet->setCellValue('J' . $row, $assets->asset_group);  // Assets Group in column J
                $sheet->setCellValue('K' . $row, $assets->remark_assets);  // Assets Remark in column K
                $sheet->setCellValue('L' . $row, $assets->created_at);  // Created At in column L


                // Assets Holder
                $sheet->setCellValue('M' . $row, $assets->asset_holder);  // Asset Holder in column M
                $sheet->setCellValue('N' . $row, $assets->holder_name);  // Holder Name in column N
                $sheet->setCellValue('O' . $row, $assets->position);  // Position in column O
                $sheet->setCellValue('P' . $row, $assets->location);  // Location in column P
                $sheet->setCellValue('Q' . $row, $assets->department);  // Department in column Q
                $sheet->setCellValue('R' . $row, $assets->company);  // Company in column R
                $sheet->setCellValue('S' . $row, $assets->remark_holder);  // Remark Holder in column S


                // Internal Document
                $sheet->setCellValue('T' . $row, $assets->grn);  // GRN in column T
                $sheet->setCellValue('U' . $row, $assets->po);   // PO in column U
                $sheet->setCellValue('V' . $row, $assets->pr);   // PR in column V
                $sheet->setCellValue('W' . $row, $assets->dr);   // DR in column W
                $sheet->setCellValue('X' . $row, $assets->dr_requested_by);  // DR requested by in column X
                $sheet->setCellValue('Y' . $row, $assets->dr_date);  // DR Date in column Y
                $sheet->setCellValue('Z' . $row, $assets->remark_internal_doc);  // Internal Document Remark in column Z

                // ERP Invoice
                $sheet->setCellValue('AA' . $row, $assets->asset_code_account);  // Assets Code (Account) in column AA
                $sheet->setCellValue('AB' . $row, $assets->invoice_date);        // Invoice Date in column AB
                $sheet->setCellValue('AC' . $row, $assets->invoice_no);          // Invoice No in column AC
                $sheet->setCellValue('AD' . $row, $assets->fa);                  // Fix Asset No in column AD
                $sheet->setCellValue('AE' . $row, $assets->fa_class);            // Fix Asset Class in column AE
                $sheet->setCellValue('AF' . $row, $assets->fa_subclass);         // Fix Asset Sub Class in column AF
                $sheet->setCellValue('AG' . $row, $assets->depreciation);        // Depreciation Book Code in column AG
                $sheet->setCellValue('AH' . $row, $assets->fa_type);             // FA Posting Type in column AH
                $sheet->setCellValue('AI' . $row, $assets->fa_location);         // FA Location in column AI
                $sheet->setCellValue('AJ' . $row, $assets->cost);                // Cost in column AJ
                $sheet->setCellValue('AK' . $row, $assets->currency);            // Currency in column AK
                $sheet->setCellValue('AL' . $row, $assets->vat);                 // VAT in column AL
                $sheet->setCellValue('AM' . $row, $assets->description);         // Description in column AM
                $sheet->setCellValue('AN' . $row, $assets->invoice_description);  // Invoice Description in column AN


                // Vendor Info
                $sheet->setCellValue('AO' . $row, $assets->vendor); // Set vendor in column AO
                $sheet->setCellValue('AP' . $row, $assets->vendor_name); // Set vendor_name in column AP
                $sheet->setCellValue('AQ' . $row, $assets->address);
                $sheet->setCellValue('AR' . $row, $assets->address2);
                $sheet->setCellValue('AS' . $row, $assets->contact);
                $sheet->setCellValue('AT' . $row, $assets->phone);
                $sheet->setCellValue('AU' . $row, $assets->email); // Adjust column for email if necessary
                // Image
                // Assuming you want to display the image path or URL in the Excel file

                $total_image = count($assets->images);
                $colIndex = Coordinate::columnIndexFromString('AW');
                foreach ($assets->images as $item) {
                    if ($assets->varaint == $item->varaint) {
                        $colLetter = Coordinate::stringFromColumnIndex($colIndex);

                        $date = explode('-', $item->created_at);
                        $year = $date[0];
                        $month = $date[1];
                        // $path= "/storage/uploads/image/".$item->image;

                        $imagePath = public_path("storage/uploads/image/$year/$month/" . $item->image);

                        if (file_exists($imagePath)) {
                            // Set cell dimensions
                            $cellWidth = 200;  // Cell width (adjust as needed)
                            $cellHeight = 150; // Cell height (adjust as needed)
                            $sheet->getColumnDimension($colLetter)->setWidth($cellWidth / 5.5); // Convert px to Excel width
                            $sheet->getRowDimension($row)->setRowHeight($cellHeight);

                            // Get original image dimensions
                            [$originalWidth, $originalHeight] = getimagesize($imagePath);

                            // Calculate the best scale factor to fit the image inside the cell while maintaining aspect ratio
                            $scale = min($cellWidth / $originalWidth, $cellHeight / $originalHeight);

                            // Apply new dimensions
                            $newWidth = $originalWidth * $scale;
                            $newHeight = $originalHeight * $scale;

                            $drawing = new Drawing();
                            $drawing->setPath($imagePath);
                            $drawing->setResizeProportional(true); // Ensure proportional scaling
                            $drawing->setWidth($newWidth);
                            $drawing->setHeight($newHeight);
                            $drawing->setCoordinates("{$colLetter}{$row}");
                            $drawing->setWorksheet($sheet);

                            // Center the image inside the cell
                            $drawing->setOffsetX(($cellWidth - $newWidth) / 2);
                            $drawing->setOffsetY(($cellHeight - $newHeight) / 2);

                            $colIndex++; // Move to the next column
                        } else {
                            \Log::error("Image not found: " . $imagePath);
                        }
                    }
                }



                // Move to the next row for the next data entry
                $row++;
            }


            // Auto-fit columns from A to AU
            for ($col = 'A'; $col !== 'AV'; $col++) { // 'AV' is exclusive, so it will go up to 'AU'
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }


            $writer = new Xlsx($spreadsheet);
            $filename = 'users.xlsx';
            $response = new StreamedResponse(function () use ($writer) {
                $writer->save('php://output');
            });

            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
            $response->headers->set('Cache-Control', 'max-age=0');

            // Save the spreadsheet to a temporary file
            $today = today();
            $filename = 'Assets.xlsx';
            $tempFilePath = storage_path('app/' . $filename);
            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFilePath);

            // Prepare the response to download the file
            return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
        } else {
            return redirect('/')->with('fail', 'You do not have permission Assets Read to Export Data.');
        }
    }

    public function multi_export_movement(request $request)
    {

        if (Auth::user()->permission->assets_read == 1) {
            $ids = explode(',', $request->id_export);
            sort($ids);
            $data = [];
            foreach ($ids as $id) {
                $assets =  movement::where('assetS_id', $id)->where("last_varaint", 1)
                    ->with(['images'])

                    ->first();
                if ($assets) {
                    Array_push($data, $assets);
                }
            }

            // return $data;
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $headers = [
                'A1' => 'ID',
                'B1' => 'Assets',
                'C1' => 'Refference',
                'D1' => 'Fix Assets No',
                'E1' => 'Item',
                'F1' => 'Issue Date',
                'G1' => 'Initial Condition',
                'H1' => 'Specifications',
                'I1' => 'Item Description',
                'J1' => 'Assets Group',
                'K1' => 'Assets Remark',
                'L1' => 'Created At',
                'M1' => 'Assets Holder ID',
                'N1' => 'Name',
                'O1' => 'Position/Title',
                'P1' => 'Location',
                'Q1' => 'Department',
                'R1' => 'Company',
                'S1' => 'Assets Holder Remark',
                'T1' => 'GRN',
                'U1' => 'PO No',
                'V1' => 'PR',
                'W1' => 'DR',
                'X1' => 'DR request by',
                'Y1' => 'DR Date',
                'Z1' => 'Internal Document Remark',
                'AA1' => 'Assets Code (Account)',
                'AB1' => 'Invoice Date',
                'AC1' => 'Invoice No',
                'AD1' => 'Fix Asset No',
                'AE1' => 'Fix Asset Class',
                'AF1' => 'Fix Asset Sub Class',
                'AG1' => 'Depreciation Book Code',
                'AH1' => 'FA Posting Type',
                'AI1' => 'FA Location',
                'AJ1' => 'Cost',
                'AK1' => 'Currency',
                'AL1' => 'VAT',
                'AM1' => 'Description',
                'AN1' => 'Invoice Description',
                'AO1' => 'Vendor No',
                'AP1' => 'Vendor Name',
                'AQ1' => 'Address',
                'AR1' => 'Address 2',
                'AS1' => 'Contact',
                'AT1' => 'Phone',
                'AU1' => 'E-Mail',
                'AV1' => 'path',
                'AW1' => 'Image',
            ];
            // return $data;
            // Set headers in Excel
            foreach ($headers as $cell => $header) {
                $sheet->setCellValue($cell, $header);
            }
            $row = 2; // Starting from the second row as the first row is for headers
            foreach ($data as $assets) {



                // Assets Info
                $sheet->setCellValue('A' . $row, $assets->id);  // ID in column A
                $sheet->setCellValue('B' . $row, $assets->assets1 . $assets->assets2 ?? '');  // Combine assets1 and assets2 in column B
                $sheet->setCellValue('C' . $row, $assets->document);  // Document in column C
                $sheet->setCellValue('D' . $row, $assets->fa_no);  // Fix Assets No in column D
                $sheet->setCellValue('E' . $row, $assets->item);  // Item in column E
                $sheet->setCellValue('F' . $row, $assets->transaction_date);  // Issue Date in column F
                $sheet->setCellValue('G' . $row, $assets->initial_condition);  // Initial Condition in column G
                $sheet->setCellValue('H' . $row, $assets->specification);  // Specifications in column H
                $sheet->setCellValue('I' . $row, $assets->item_description);  // Item Description in column I
                $sheet->setCellValue('J' . $row, $assets->asset_group);  // Assets Group in column J
                $sheet->setCellValue('K' . $row, $assets->remark_assets);  // Assets Remark in column K
                $sheet->setCellValue('L' . $row, $assets->created_at);  // Created At in column L


                // Assets Holder
                $sheet->setCellValue('M' . $row, $assets->asset_holder);  // Asset Holder in column M
                $sheet->setCellValue('N' . $row, $assets->holder_name);  // Holder Name in column N
                $sheet->setCellValue('O' . $row, $assets->position);  // Position in column O
                $sheet->setCellValue('P' . $row, $assets->location);  // Location in column P
                $sheet->setCellValue('Q' . $row, $assets->department);  // Department in column Q
                $sheet->setCellValue('R' . $row, $assets->company);  // Company in column R
                $sheet->setCellValue('S' . $row, $assets->remark_holder);  // Remark Holder in column S


                // Internal Document
                $sheet->setCellValue('T' . $row, $assets->grn);  // GRN in column T
                $sheet->setCellValue('U' . $row, $assets->po);   // PO in column U
                $sheet->setCellValue('V' . $row, $assets->pr);   // PR in column V
                $sheet->setCellValue('W' . $row, $assets->dr);   // DR in column W
                $sheet->setCellValue('X' . $row, $assets->dr_requested_by);  // DR requested by in column X
                $sheet->setCellValue('Y' . $row, $assets->dr_date);  // DR Date in column Y
                $sheet->setCellValue('Z' . $row, $assets->remark_internal_doc);  // Internal Document Remark in column Z

                // ERP Invoice
                $sheet->setCellValue('AA' . $row, $assets->asset_code_account);  // Assets Code (Account) in column AA
                $sheet->setCellValue('AB' . $row, $assets->invoice_date);        // Invoice Date in column AB
                $sheet->setCellValue('AC' . $row, $assets->invoice_no);          // Invoice No in column AC
                $sheet->setCellValue('AD' . $row, $assets->fa);                  // Fix Asset No in column AD
                $sheet->setCellValue('AE' . $row, $assets->fa_class);            // Fix Asset Class in column AE
                $sheet->setCellValue('AF' . $row, $assets->fa_subclass);         // Fix Asset Sub Class in column AF
                $sheet->setCellValue('AG' . $row, $assets->depreciation);        // Depreciation Book Code in column AG
                $sheet->setCellValue('AH' . $row, $assets->fa_type);             // FA Posting Type in column AH
                $sheet->setCellValue('AI' . $row, $assets->fa_location);         // FA Location in column AI
                $sheet->setCellValue('AJ' . $row, $assets->cost);                // Cost in column AJ
                $sheet->setCellValue('AK' . $row, $assets->currency);            // Currency in column AK
                $sheet->setCellValue('AL' . $row, $assets->vat);                 // VAT in column AL
                $sheet->setCellValue('AM' . $row, $assets->description);         // Description in column AM
                $sheet->setCellValue('AN' . $row, $assets->invoice_description);  // Invoice Description in column AN


                // Vendor Info
                $sheet->setCellValue('AO' . $row, $assets->vendor); // Set vendor in column AO
                $sheet->setCellValue('AP' . $row, $assets->vendor_name); // Set vendor_name in column AP
                $sheet->setCellValue('AQ' . $row, $assets->address);
                $sheet->setCellValue('AR' . $row, $assets->address2);
                $sheet->setCellValue('AS' . $row, $assets->contact);
                $sheet->setCellValue('AT' . $row, $assets->phone);
                $sheet->setCellValue('AU' . $row, $assets->email); // Adjust column for email if necessary
                // Image
                // Assuming you want to display the image path or URL in the Excel file

                $total_image = count($assets->images);
                $colIndex = Coordinate::columnIndexFromString('AW');
                foreach ($assets->images as $item) {
                    if ($assets->varaint == $item->varaint) {
                        $colLetter = Coordinate::stringFromColumnIndex($colIndex);

                        $date = explode('-', $item->created_at);
                        $year = $date[0];
                        $month = $date[1];
                        // $path= "/storage/uploads/image/".$item->image;

                        $imagePath = public_path("storage/uploads/image/$year/$month/" . $item->image);

                        if (file_exists($imagePath)) {
                            // Set cell dimensions
                            $cellWidth = 200;  // Cell width (adjust as needed)
                            $cellHeight = 150; // Cell height (adjust as needed)
                            $sheet->getColumnDimension($colLetter)->setWidth($cellWidth / 5.5); // Convert px to Excel width
                            $sheet->getRowDimension($row)->setRowHeight($cellHeight);

                            // Get original image dimensions
                            [$originalWidth, $originalHeight] = getimagesize($imagePath);

                            // Calculate the best scale factor to fit the image inside the cell while maintaining aspect ratio
                            $scale = min($cellWidth / $originalWidth, $cellHeight / $originalHeight);

                            // Apply new dimensions
                            $newWidth = $originalWidth * $scale;
                            $newHeight = $originalHeight * $scale;

                            $drawing = new Drawing();
                            $drawing->setPath($imagePath);
                            $drawing->setResizeProportional(true); // Ensure proportional scaling
                            $drawing->setWidth($newWidth);
                            $drawing->setHeight($newHeight);
                            $drawing->setCoordinates("{$colLetter}{$row}");
                            $drawing->setWorksheet($sheet);

                            // Center the image inside the cell
                            $drawing->setOffsetX(($cellWidth - $newWidth) / 2);
                            $drawing->setOffsetY(($cellHeight - $newHeight) / 2);

                            $colIndex++; // Move to the next column
                        } else {
                            \Log::error("Image not found: " . $imagePath);
                        }
                    }
                }



                // Move to the next row for the next data entry
                $row++;
            }


            // Auto-fit columns from A to AU
            for ($col = 'A'; $col !== 'AV'; $col++) { // 'AV' is exclusive, so it will go up to 'AU'
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }


            $writer = new Xlsx($spreadsheet);
            $filename = 'users.xlsx';
            $response = new StreamedResponse(function () use ($writer) {
                $writer->save('php://output');
            });

            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
            $response->headers->set('Cache-Control', 'max-age=0');

            // Save the spreadsheet to a temporary file
            $today = today();
            $filename = 'Assets.xlsx';
            $tempFilePath = storage_path('app/' . $filename);
            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFilePath);

            // Prepare the response to download the file
            return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
        } else {
            return redirect('/')->with('fail', 'You do not have permission Assets Read to Export Data.');
        }
    }



    // public function view_asset($id)
    // {
    //     if (Auth::user()->permission->assets_read == 1) {
    //         $asset = StoredAssets::with(['images', 'files'])
    //             ->where('assets_id', $id)
    //             ->Orderby('varaint', 'asc')
    //             ->get();
    //         $count = count($asset);
    //         $count -= 1;
    //         $current_varaint = $count;
    //         $qr_code = "No QR Code Generated";



    //         if ($asset[$count]->assets1 . $asset[$count]->assets2 != "") {
    //             $qr_code = QrCode::size(300)->format('svg')->generate($asset[$count]->assets1 . $asset[$count]->assets2);
    //         }
    //         // Save the SVG to temporary storage
    //         $svgContent = $qr_code;
    //         if ($svgContent) {
    //             Storage::disk('public')->put('qrcodes/my-qrcode.svg', $svgContent);
    //         }

    //         $update_able = 0;

    //         $department = QuickData::where('type', 'department')->select('content')->orderby('id', 'desc')->get();
    //         $company = QuickData::where('type', 'company')->select('content')->orderby('id', 'desc')->get();
    //         // return $count;
    //         if (Auth::user()->role == "admin") {

    //             // return $asset;
    //             return view('backend.update-assets-by-variant', [
    //                 'asset' => $asset,
    //                 'total_varaint' => $count,
    //                 'current_varaint' => $current_varaint,
    //                 'department' => $department,
    //                 'company' => $company,
    //                 'qr_code' => $qr_code,
    //                 'update_able' =>  $update_able

    //             ]);
    //         } elseif (Auth::user()->role == "staff") {

    //             return view('backend.update-assets', [
    //                 'asset' => $asset[$count],
    //                 'department' => $department,
    //                 'company' => $company,
    //                 'qr_code' => $qr_code,
    //                 'update_able' =>  $update_able

    //             ]);
    //         } else {
    //             return view('backend.dashboard')->with('fail', "You do not have permission on this function.");
    //         }
    //     } else {
    //         return redirect('/')->with('fail', 'You do not have permission Assets Update.');
    //     }
    // }




    public function assets_import()
    {
        if(Auth::user()->permission->assets_write != 1){
            return redirect()->back()->with('error','You do not has permission');
        }

        return view('backend.import');
    }


    public function downloadAssetsTemplate()
    {
        if(Auth::user()->permission->assets_write != 1){
            return redirect()->back()->with('error','You do not has permission');
        }
        $spreadsheet = new Spreadsheet();
        $lastRowImport = 1000; // max rows in Sheet1

        // Helper Styles
        $applyHeaderStyle = function ($sheet, $range) {
            $sheet->getStyle($range)->getFont()->setBold(true);
            $sheet->getStyle($range)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('4F81BD');
            $sheet->getStyle($range)->getFont()->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        };
        $applyTableBorders = function ($sheet, $range) {
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        };

        // -------------------- SHEET 1: Assets Import --------------------
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Assets Import');

        $headers = [
            'reference',
            'assets1',
            'assets2',
            'fa_no',
            'item',
            'transaction_date',
            'initial_condition',
            'specification',
            'item_description',
            'asset_group',
            'remark_assets',
            'asset_holder',
            'holder_name',
            'position',
            'location',
            'department',
            'company',
            'remark_holder',
            'grn',
            'po',
            'pr',
            'dr',
            'dr_requested_by',
            'dr_date',
            'remark_internal_doc',
            'ref_movement',
            'purpose',
            'status_recieved',
            'to_ref',
        ];

        $lastColLetter = Coordinate::stringFromColumnIndex(count($headers));
        foreach ($headers as $i => $header) {
            $colLetter = Coordinate::stringFromColumnIndex($i + 1);
            $sheet1->setCellValue($colLetter . '1', $header);
        }

        $applyHeaderStyle($sheet1, "A1:{$lastColLetter}1");
        $sheet1->freezePane('A2');
        foreach (range(1, count($headers)) as $colIndex) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet1->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Example row
        $sheet1->fromArray([[
            'Example Assets',
            'P-M-SE-N054',
            'HR',
            'FA25/2123',
            'Laptop',
            date('Y-m-d'),
            'New',
            'Intel i7, 16GB RAM',
            'Dell Laptop',
            'IT Equipment',
            '',
            'INV0125',
            'MOT Sakirin',
            'Administrator Manager',
            'HQ Room2 OFFICE ABC',
            'Administration & HR',
            'PPM',
            '',
            'GRN25/2123',
            'PO25/0456',
            'PR25/1244',
            'DR0025',
            'Mot Sakirin',
            date('Y-m-d'),
            'Urgent purchase',
            'MOV001',
            'Relocation to new office',
            'Received',
            'TO001',
        ]], null, 'A2');
        $applyTableBorders($sheet1, "A1:{$lastColLetter}2");

        // -------------------- SHEET 2: Departments --------------------
        $departments = [
            'Accounting & Finance',
            'Administration & HR',
            'Management',
            'Maintenance',
            'Planning',
            'Purchase',
            'Regulatory Affairs',
            'External Project & Special Project',
            'Warehouse',
            'Logistic',
            'MIS',
            'Consultant',
            'Research & Development',
            'Commercial',
            'Production',
            'Quality Control',
            'Quality Assurance',
            'Pizza Project',
            'Kitchen Center',
            'Export and Marketing',
            'Quality Production',
            'Order',
        ];

        $sheetDept = $spreadsheet->createSheet();
        $sheetDept->setTitle('Departments');
        $sheetDept->fromArray(array_map(fn($d) => [$d], $departments), null, 'A1');
        $applyHeaderStyle($sheetDept, "A1");
        $applyTableBorders($sheetDept, "A1:A" . count($departments));
        $sheetDept->getColumnDimension('A')->setAutoSize(true);
        $sheetDept->freezePane('A2');

        // -------------------- SHEET 3: Companies --------------------
        $companies = ['CFR', 'Depomex', 'INV', 'Other', 'PPM', 'PPM&Confirel'];

        $sheetComp = $spreadsheet->createSheet();
        $sheetComp->setTitle('Companies');
        $sheetComp->fromArray(array_map(fn($c) => [$c], $companies), null, 'A1');
        $applyHeaderStyle($sheetComp, "A1");
        $applyTableBorders($sheetComp, "A1:A" . count($companies));
        $sheetComp->getColumnDimension('A')->setAutoSize(true);
        $sheetComp->freezePane('A2');

        // -------------------- SHEET 4: Status Received --------------------
        $statusOptions = ['Old', 'Good', 'Broken', 'Low', 'Medium', 'Other'];

        $sheetStatus = $spreadsheet->createSheet();
        $sheetStatus->setTitle('Status Received');
        $sheetStatus->fromArray(array_map(fn($s) => [$s], $statusOptions), null, 'A1');
        $applyHeaderStyle($sheetStatus, "A1");
        $applyTableBorders($sheetStatus, "A1:A" . count($statusOptions));
        $sheetStatus->getColumnDimension('A')->setAutoSize(true);
        $sheetStatus->freezePane('A2');

        // -------------------- APPLY VALIDATION --------------------
        $validationColumns = [
            'department' => ['sheet' => 'Departments', 'count' => count($departments)],
            'company' => ['sheet' => 'Companies', 'count' => count($companies)],
            'status_recieved' => ['sheet' => 'Status Received', 'count' => count($statusOptions)],
        ];

        foreach ($validationColumns as $colName => $info) {
            $colIndex = array_search($colName, $headers) + 1;
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);

            $dv = new DataValidation();
            $dv->setType(DataValidation::TYPE_LIST)
                ->setErrorStyle(DataValidation::STYLE_STOP)
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setFormula1("='{$info['sheet']}'!\$A\$1:\$A\$" . $info['count']);

            // Apply the same validation object to the entire column at once
            $sheet1->setDataValidation(
                $colLetter . '2:' . $colLetter . $lastRowImport,
                clone $dv
            );
        }

        // -------------------- FINALIZE --------------------
        $spreadsheet->setActiveSheetIndex(0);
        $writer = new Xlsx($spreadsheet);
        $fileName = 'assets_import_template.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$fileName}\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    public function import_submit(Request $request)
    {
          if(Auth::user()->permission->assets_write != 1){
            return redirect()->back()->with('error','You do not has permission');
        }

        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $validData = [];
        $errors = [];

        DB::beginTransaction();
        try {
            $rowIndex = 1;

            foreach (array_slice($rows, 1) as $row) {
                $rowIndex++;

                if (empty($row['A']) && empty($row['B']) && empty($row['C'])) {
                    continue;
                }

                if (empty($row['B']) || empty($row['C'])) {
                    $errors[] = "Import Error: Row {$rowIndex} – Missing required fields (assets1 or assets2).";
                    continue;
                }

                // Transaction date validation
                try {
                    $transactionDate = \Carbon\Carbon::parse($row['F'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $errors[] = "Import Error: Row {$rowIndex} – Transaction date is missing or invalid ('{$row['F']}').";
                    continue;
                }

                // DR date optional
                try {
                    $drDate = !empty($row['X']) ? \Carbon\Carbon::parse($row['X'])->format('Y-m-d') : '1900-01-01';
                } catch (\Exception $e) {
                    $drDate = '1900-01-01';
                }

                // Build data array
                $data = [
                    'reference'         => trim($row['A']),
                    'assets1'           => trim($row['B']),
                    'assets2'           => '-' . trim($row['C']),
                    'fa_no'             => trim($row['D']),
                    'item'              => trim($row['E']),
                    'transaction_date'  => $transactionDate,
                    'initial_condition' => trim($row['G']),
                    'specification'     => trim($row['H']),
                    'item_description'  => trim($row['I']),
                    'asset_group'       => trim($row['J']),
                    'remark_assets'     => trim($row['K']),
                    'asset_holder'      => trim($row['L']),
                    'holder_name'       => trim($row['M']),
                    'position'          => trim($row['N']),
                    'location'          => trim($row['O']),
                    'department'        => trim($row['P']),
                    'company'           => trim($row['Q']),
                    'remark_holder'     => trim($row['R']),
                    'grn'               => trim($row['S']),
                    'po'                => trim($row['T']),
                    'pr'                => trim($row['U']),
                    'dr'                => trim($row['V']),
                    'dr_requested_by'   => trim($row['W']),
                    'dr_date'           => $drDate,
                    'remark_internal_doc' => trim($row['Y']),
                    'ref_movement'      => trim($row['Z']),
                    'purpose'           => trim($row['AA']),
                    'status_recieved'   => trim($row['AB']),
                    'to_ref'            => trim($row['AC']),
                    'old_code'          => '',
                    'variant'           => 1,
                    'last_varaint'      => 1,
                    'status'            => 1, // New record status = 1
                ];

                // Accounting data
                $accounting = RawFixAssets::where('assets', $data['assets1'])->first();
                $data['asset_code_account']   = $accounting->asset_code_account   ?? '';
                $data['invoice_date']         = !empty($accounting->invoice_date) ? $accounting->invoice_date : '1900-01-01';
                $data['invoice_no']           = $accounting->invoice_no          ?? '';
                $data['fa']                   = $accounting->fa                  ?? '';
                $data['fa_class']             = $accounting->fa_class            ?? '';
                $data['fa_subclass']          = $accounting->fa_subclass         ?? '';
                $data['depreciation']         = $accounting->depreciation        ?? '';
                $data['fa_type']              = $accounting->fa_type             ?? '';
                $data['fa_location']          = $accounting->fa_location         ?? '';
                $data['cost']                 = $accounting ? (is_numeric($accounting->cost) ? (float)$accounting->cost : 0) : 0;
                $data['vat']                  = $accounting ? (is_numeric($accounting->vat)  ? (float)$accounting->vat  : 0) : 0;
                $data['currency']             = $accounting->currency            ?? '';
                $data['description']          = $accounting->description         ?? '';
                $data['invoice_description']  = $accounting->invoice_description ?? '';
                $data['vendor']               = $accounting->vendor              ?? '';
                $data['vendor_name']          = $accounting->vendor_name         ?? '';
                $data['address']              = $accounting->address             ?? '';
                $data['address2']             = $accounting->address2            ?? '';
                $data['contact']              = $accounting->contact             ?? '';
                $data['phone']                = $accounting->phone               ?? '';
                $data['email']                = $accounting->email               ?? '';

                // Update all existing records to status 0
                movement::where('assets1', $data['assets1'])
                    ->where('status', 1)
                    ->update(['status' => 0]);

                // Add new record to insert later
                $validData[] = $data;
            }

            if (!empty($errors)) {
                DB::rollBack();
                return back()->with('errorList', $errors)->with('error', 'Import failed: one or more rows are invalid.');
            }


            foreach ($validData as $data) {
                // generate a unique string PK
                $data['assets_id'] = Str::uuid();  // generates a unique string ID
                $record = Movement::create($data);
                $insertedId = $record->assets_id;  // now you can use it immediately
                // now $record->assets_id has a valid value

                $this->storeChangeLog(
                    $insertedId,
                    $record->assets1 . $record->assets2,
                    null,   // old values
                    null,   // new values
                    'Import',
                    'Assets and Movement',
                    'Import from Excel file'
                );
            }
            DB::commit();
            return back()->with('success', "Assets imported successfully! Total rows inserted: " . count($validData));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed due to unexpected error: ' . $e->getMessage());
        }
    }




    // No Deleted Allow  and Only 1 Record of new Register
    public function assets_new($page){
        // return Auth::user()->Permission;
        if(Auth::user()->permission->assets_read != 1){
            return redirect()->back()->with('error','You do not has permission');
        }


        $viewpoint = User_property::where('user_id',Auth::user()->id)->where('type','viewpoint')->first();
        $limit = $viewpoint->value ?? 50;



        $count_post = New_assets::count();
        $total_page = ceil($count_post / $limit);
        $offset = 0;
        if ($page != 0) {
            $offset = ($page - 1) * $limit;
        }

        $sql =  New_assets::orderBy('assets1', 'desc')->where('deleted','<>',1)
            ->limit($limit)
            ->offset($offset);

            // Filter Deleted data  if not super admin
            if(Auth::user()->role == 'admin'){
                $sql->where('deleted',0);
            }

        $asset = $sql->get();
        return view('backend.assets_new_list', [
            'asset' => $asset,
            'total_page' => $total_page,
            'page' => $page,
            'total_assets' => $count_post,
            'total_page' => $total_page,
            'limit' =>  $limit
        ]);
    }
}
