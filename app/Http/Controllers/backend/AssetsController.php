<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileUser;
use App\Models\Fix_assets;
use App\Models\Image;
use App\Models\ImageUser;
use App\Models\RawFixAssets;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use App\Models\QuickData;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssetsController extends Controller
{
    public function assetes_add()
    {
        return view('backend.add-assets');
    }
    public function list_assets($page)
    {
        $limit = 250;
        if(Auth::user()->permission->assets_read == 1 && Auth::user()->role == 'admin'){

            $count_post = StoredAssets::where("last_varaint", 1)->count();
            $total_page = ceil($count_post/$limit);
            $offset = 0;
            if($page != 0){
                $offset = ($page - 1) * $limit;
            }

            $asset =  StoredAssets::orderBy('id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->where("last_varaint", 1)

                ->get();

            return view('backend.list_asset', [
                'asset' => $asset,
                'total_page' => $total_page,
                'page' => $page,
                'total_assets' =>$count_post,
                'total_page' => $total_page
            ]);


        }elseif(Auth::user()->permission->assets_read == 1 && Auth::user()->role == 'staff'){

            $count_post = StoredAssets::where("last_varaint", 1)->count();
            $total_page = ceil($count_post/$limit);
            $offset = 0;
            if($page != 0){
                $offset = ($page - 1) * $limit;
            }

            $asset =  StoredAssets::orderBy('assets_id', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->where("last_varaint", 1)
                ->where('status','<>',1)
                ->get();

            return view('backend.list_asset', [
                'asset' => $asset,
                'total_page' => $total_page,
                'page' => $page,
                'total_assets' =>$count_post,
                'total_page' => $total_page
            ]);
        }


    }

    public function list_select($page)
    {

        if(Auth::user()->permission->assets_write == 1){
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

            $total_page = ceil($count_post/$limit);
            $offset = 0;
            if($page != 0){
                $offset = ($page - 1) * $limit;
            }

            $data->limit($limit);
            $data->offset($offset);
            $data->orderBy('assets_date','desc');

            $datas = $data->get();

            // return $data;
            return view('backend.list-select', [
                'data' => $datas,
                'total_page' => $total_page,
                'page' => $page,
                'total_record' =>$count_post,


            ]);
        }else{
                return redirect('/')->with('fail','You do not have permission Assets Write.');
      }

    }

    public function assets_add($assets, $invoice)
    {

        if(Auth::user()->permission->assets_write == 1){
            if($invoice != "NA"){
                $modifiedString = str_replace('-', '/', $invoice);
            }


            // return $modifiedString;
            $sql= Fix_assets::where('assets', $assets);
            if($invoice != "NA"){
                $sql->where("fa", $modifiedString);
            }

            $asset = $sql->first();


            $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
            $company  = QuickData::where('type', "company")->select('id', 'content')->orderby('id', 'desc')->get();
            return view('backend.add-assets', [
                'asset' => $asset,
                'department' => $department,
                'company' => $company
            ]);
        }else{
                return redirect('/')->with('fail','You do not have permission Assets Write.');
        }


    }

    public function assets_add_submit(Request $request)
    {
        if(Auth::user()->permission->assets_write == 1){
            $asset_user = new StoredAssetsUser();

            // Asset Info
            $asset_user->document = $request->document ?? "";
            $asset_user->assets1 = $request->asset_code1 ?? "";
            $asset_user->assets2 = $request->asset_code2 ?? "";
            $asset_user->fa_no = $request->fa_no ?? "";
            $asset_user->item = $request->item ?? "";
            $asset_user->issue_date = $request->issue_date ? Carbon::parse($request->issue_date)->format('Y-m-d H:i:s') : null;
            $asset_user->initial_condition = $request->intail_condition ?? "";
            $asset_user->specification = $request->specification ?? "";
            $asset_user->item_description = $request->item_description ?? "";
            $asset_user->asset_group = $request->asset_group ?? "";
            $asset_user->remark_assets = $request->remark_assets ?? "";

            // Asset Holder
            $asset_user->asset_holder = $request->asset_holder ?? "";
            $asset_user->holder_name = $request->holder_name ?? "";
            $asset_user->position = $request->position ?? "";
            $asset_user->location = $request->location ?? ""; // Assuming this is 'location'
            $asset_user->department = $request->department ?? "";
            $asset_user->company = $request->company ?? "";
            $asset_user->remark_holder = $request->remark_holder ?? "";

            // Internal Document
            $asset_user->grn = $request->grn ?? "";
            $asset_user->po = $request->po ?? "";
            $asset_user->pr = $request->pr ?? "";
            $asset_user->dr = $request->dr ?? "";
            $asset_user->dr_requested_by = $request->dr_requested_by ?? "";
            $asset_user->dr_date = $request->dr_date ? Carbon::parse($request->dr_date)->format('Y-m-d H:i:s') : null;
            $asset_user->remark_internal_doc = $request->remark_internal_doc ?? "";

            // ERP Invoice
            $asset_user->asset_code_account = $request->asset_code_account ?? "";
            $asset_user->invoice_date = $request->invoice_posting_date ? Carbon::parse($request->invoice_posting_date)->format('Y-m-d H:i:s') : null;
            $asset_user->invoice_no = $request->invoice ?? "";
            $asset_user->fa = $request->fa ?? "";
            $asset_user->fa_class = $request->fa_class ?? "";
            $asset_user->fa_subclass = $request->fa_subclass ?? "";
            $asset_user->depreciation = $request->depreciation_book_code ?? "";
            $asset_user->fa_type = $request->fa_type ?? "";
            $asset_user->fa_location = $request->fa_location ?? "";
            $asset_user->cost = $request->cost ?? 0;
            $asset_user->currency = $request->currency ?? "";
            $asset_user->vat = $request->vat ?? "";
            $asset_user->description = $request->description ?? "";
            $asset_user->invoice_description = $request->invoice_description ?? "";

            // Vendor
            $asset_user->vendor = $request->vendor ?? "";
            $asset_user->vendor_name = $request->vendor_name ?? "";
            $asset_user->address = $request->address ?? "";
            $asset_user->address2 = $request->address2 ?? "";
            $asset_user->contact = $request->contact ?? "";
            $asset_user->phone = $request->phone ?? "";
            $asset_user->email = $request->email ?? "";

            // Save the data
            $asset_user->save();


            // return $asset_user->id;
            $asset = new StoredAssets();

            // Asset Info
            $asset->assets_id = $asset_user->id;
            $asset->document = $request->document ?? "";
            $asset->assets1 = $request->asset_code1 ?? "";
            $asset->assets2 = $request->asset_code2 ?? "";
            $asset->fa_no = $request->fa_no ?? "";
            $asset->item = $request->item ?? "";
            $asset->issue_date = $request->issue_date ? Carbon::parse($request->issue_date)->format('Y-m-d H:i:s') : null;
            $asset->initial_condition = $request->intail_condition ?? "";
            $asset->specification = $request->specification ?? "";
            $asset->item_description = $request->item_description ?? "";
            $asset->asset_group = $request->asset_group ?? "";
            $asset->remark_assets = $request->remark_assets ?? "";

            // Asset Holder
            $asset->asset_holder = $request->asset_holder ?? "";
            $asset->holder_name = $request->holder_name ?? "";
            $asset->position = $request->position ?? "";
            $asset->location = $request->location ?? "";
            $asset->department = $request->department ?? "";
            $asset->company = $request->company ?? "";
            $asset->remark_holder = $request->remark_holder ?? "";

            // Internal Document
            $asset->grn = $request->grn ?? "";
            $asset->po = $request->po ?? "";
            $asset->pr = $request->pr ?? "";
            $asset->dr = $request->dr ?? "";
            $asset->dr_requested_by = $request->dr_requested_by ?? "";
            $asset->dr_date = $request->dr_date ? Carbon::parse($request->dr_date)->format('Y-m-d H:i:s') : null;
            $asset->remark_internal_doc = $request->remark_internal_doc ?? "";

            // ERP Invoice
            $asset->asset_code_account = $request->asset_code_account ?? "";
            $asset->invoice_date = $request->invoice_posting_date ? Carbon::parse($request->invoice_posting_date)->format('Y-m-d H:i:s') : null;
            $asset->invoice_no = $request->invoice ?? "";
            $asset->fa = $request->fa ?? "";
            $asset->fa_class = $request->fa_class ?? "";
            $asset->fa_subclass = $request->fa_subclass ?? "";
            $asset->depreciation = $request->depreciation_book_code ?? "";
            $asset->fa_type = $request->fa_type ?? "";
            $asset->fa_location = $request->fa_location ?? "";
            $asset->cost = $request->cost ??0;
            $asset->currency = $request->currency ?? "";
            $asset->vat = $request->vat ?? "";
            $asset->description = $request->description ?? "";
            $asset->invoice_description = $request->invoice_description ?? "";

            // Vendor
            $asset->vendor = $request->vendor ?? "";
            $asset->vendor_name = $request->vendor_name ?? "";
            $asset->address = $request->address ?? "";
            $asset->address2 = $request->address2 ?? "";
            $asset->contact = $request->contact ?? "";
            $asset->phone = $request->phone ?? "";
            $asset->email = $request->email ?? "";

            // Save the data
            $asset->save();


            // Add New FIle
            if ($request->file_state > 0) {
                for ($i = 1; $i <= $request->file_state; $i++) {  // Start from 1
                    $fileKey = 'file_doc' . $i;  // Dynamic file input key

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $fileName = $this->upload_file($file);

                        $file = new File();
                        $file->asset_id = $asset_user->id;
                        $file->varaint = 0;
                        $file->file = $fileName;
                        $file->save();
                        $file = new FileUser();
                        $file->asset_id = $asset_user->id;
                        $file->file = $fileName;
                        $file->save();
                    }
                }
            }
            // Add New Image
            if ($request->image_state > 0) {
                for ($i = 1; $i <= $request->image_state; $i++) {  // Start from 1
                    $imageKey = 'image' . $i;  // Dynamic image input key
                    if ($request->hasFile($imageKey)) {
                        $file = $request->file($imageKey);
                        $thumbnail = $this->upload_image($file);

                        $image = new Image();
                        $image->asset_id = $asset_user->id;
                        $image->varaint = 0;
                        $image->image = $thumbnail;
                        $image->save();  // Don't forget to save the image
                        $image = new ImageUser();
                        $image->asset_id = $asset_user->id;
                        $image->image = $thumbnail;
                        $image->save();  // Don't forget to save the image
                        // return 1;
                    }
                }
            }

            $this->Change_log($asset_user->id, 0, "Insert", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);

            if ($asset) {
                return redirect('/admin/assets/list/1')->with('success', 'Added 1 Asset Record.');
            } else {
                return redirect('/admin/assets/list/1')->with('fail', 'Opp!. Something when wronge.');
            }
        }else{
                return redirect('/')->with('fail','You do not have permission Assets Write.');
      }

    }


    public function update_asset($id)
    {
        if(Auth::user()->permission->assets_update == 1){
            $update_able = 1;
                $asset = StoredAssets::with(['images', 'files'])
                ->where('id', $id)
                ->Orderby('varaint', 'asc')
                ->get();
            $count = count($asset);

            // return $asset;
            $count -= 1;
            $current_varaint = $count;
            $qr_code = "No QR Code Generated";
            if ($asset[$count]->assets1 . $asset[$count]->assets2 != "") {
                $qr_code = QrCode::size(300)->format('svg')->generate($asset[$count]->assets1 . $asset[$count]->assets2);
            }


            // Save the SVG to temporary storage
            $svgContent = $qr_code;
            if ($svgContent) {
                Storage::disk('public')->put('qrcodes/my-qrcode.svg', $svgContent);
            }



            $department = QuickData::where('type', 'Department')
            ->select('content')
            ->orderby('id', 'desc')
            ->get();
            $company = QuickData::where('type', 'company')
            ->select('content')
            ->orderby('id', 'desc')
            ->get();
            // return $count;
            if (Auth::user()->role == "admin") {

                // return $asset;
                return view('backend.update-assets-by-variant', [
                    'asset' => $asset,
                    'total_varaint' => $count,
                    'current_varaint' => $current_varaint,
                    'department' => $department,
                    'company' => $company,
                    'qr_code' => $qr_code,
                    'update_able'=>$update_able
                ]);
            } elseif (Auth::user()->role == "staff") {

                return view('backend.update-assets-by-variant', [
                    'asset' => $asset,
                    'total_varaint' => $count,
                    'current_varaint' => $current_varaint,
                    'department' => $department,
                    'company' => $company,
                    'qr_code' => $qr_code ,
                    'update_able'=>$update_able
                ]);
            } else {
                return view('backend.dashboard')->with('fail', "You do not have permission on this function.");
            }
            }else{
                    return redirect('/')->with('fail','You do not have permission Assets Update.');
      }

    }
    public function update_submit(Request $request)
    {

        if(Auth::user()->permission->assets_update == 1){
            $asset_user = StoredAssetsUser::where('id', $request->id)->first();

            // Asset Info
            $asset_user->document = $request->document ?? "";
            $asset_user->assets1 = $request->asset_code1 ?? "";
            $asset_user->assets2 = $request->asset_code2 ?? "";
            $asset_user->fa_no = $request->fa_no ?? "";
            $asset_user->item = $request->item ?? "";
            $asset_user->issue_date = $request->issue_date ? Carbon::parse($request->issue_date)->format('Y-m-d H:i:s') : null;
            $asset_user->initial_condition = $request->intail_condition ?? "";
            $asset_user->specification = $request->specification ?? "";
            $asset_user->item_description = $request->item_description ?? "";
            $asset_user->asset_group = $request->asset_group ?? "";
            $asset_user->remark_assets = $request->remark_assets ?? "";

            // Asset Holder
            $asset_user->asset_holder = $request->asset_holder ?? "";
            $asset_user->holder_name = $request->holder_name ?? "";
            $asset_user->position = $request->position ?? "";
            $asset_user->location = $request->location ?? ""; // Assuming this is 'location'
            $asset_user->department = $request->department ?? "";
            $asset_user->company = $request->company ?? "";
            $asset_user->remark_holder = $request->remark_holder ?? "";

            // Internal Document
            $asset_user->grn = $request->grn ?? "";
            $asset_user->po = $request->po ?? "";
            $asset_user->pr = $request->pr ?? "";
            $asset_user->dr = $request->dr ?? "";
            $asset_user->dr_requested_by = $request->dr_requested_by ?? "";
            $asset_user->dr_date = $request->dr_date ? Carbon::parse($request->dr_date)->format('Y-m-d H:i:s') : null;
            $asset_user->remark_internal_doc = $request->remark_internal_doc ?? "";

            // ERP Invoice
            $asset_user->asset_code_account = $request->asset_code_account ?? "";
            $asset_user->invoice_date = $request->invoice_posting_date ? Carbon::parse($request->invoice_posting_date)->format('Y-m-d H:i:s') : null;
            $asset_user->invoice_no = $request->invoice ?? "";
            $asset_user->fa = $request->fa ?? "";
            $asset_user->fa_class = $request->fa_class ?? "";
            $asset_user->fa_subclass = $request->fa_subclass ?? "";
            $asset_user->depreciation = $request->depreciation_book_code ?? "";
            $asset_user->fa_type = $request->fa_type ?? "";
            $asset_user->fa_location = $request->fa_location ?? "";
            $asset_user->cost = $request->cost ?? "";
            $asset_user->currency = $request->currency ?? "";
            $asset_user->vat = $request->vat ?? "";
            $asset_user->description = $request->description ?? "";
            $asset_user->invoice_description = $request->invoice_description ?? "";

            // Vendor
            $asset_user->vendor = $request->vendor ?? "";
            $asset_user->vendor_name = $request->vendor_name ?? "";
            $asset_user->address = $request->address ?? "";
            $asset_user->address2 = $request->address2 ?? "";
            $asset_user->contact = $request->contact ?? "";
            $asset_user->phone = $request->phone ?? "";
            $asset_user->email = $request->email ?? "";
            $asset_user->status = $request->status ?? 0;

            // Save the data
            $asset_user->save();


            $last_varaint = StoredAssets::where("assets_id", $request->id)->where("last_varaint", 1)->select("varaint")->first();
            if (!empty($last_varaint)) {

                // Update Current Varaint to 0
                $modify_last = StoredAssets::where("assets_id", $asset_user->id)->where("last_varaint", 1)->first();
                $modify_last->last_varaint = 0;
                $modify_last->save();


                $var = $last_varaint->varaint += 1;
                // Admin Side
                $asset = new StoredAssets();

                // Asset Info
                $asset->assets_id = $asset_user->id;
                $asset->varaint = $var;
                $asset->document = $request->document ?? "";
                $asset->assets1 = $request->asset_code1 ?? "";
                $asset->assets2 = $request->asset_code2 ?? "";

                $asset->fa_no = $request->fa_no ?? "";
                $asset->item = $request->item ?? "";
                $asset->issue_date = $request->issue_date ? Carbon::parse($request->issue_date)->format('Y-m-d H:i:s') : null;
                $asset->initial_condition = $request->intail_condition ?? "";
                $asset->specification = $request->specification ?? "";
                $asset->item_description = $request->item_description ?? "";
                $asset->asset_group = $request->asset_group ?? "";
                $asset->remark_assets = $request->remark_assets ?? "";

                // Asset Holder
                $asset->asset_holder = $request->asset_holder ?? "";
                $asset->holder_name = $request->holder_name ?? "";
                $asset->position = $request->position ?? "";
                $asset->location = $request->location ?? "";
                $asset->department = $request->department ?? "";
                $asset->company = $request->company ?? "";
                $asset->remark_holder = $request->remark_holder ?? "";

                // Internal Document
                $asset->grn = $request->grn ?? "";
                $asset->po = $request->po ?? "";
                $asset->pr = $request->pr ?? "";
                $asset->dr = $request->dr ?? "";
                $asset->dr_requested_by = $request->dr_requested_by ?? "";
                $asset->dr_date = $request->dr_date ? Carbon::parse($request->dr_date)->format('Y-m-d H:i:s') : null;
                $asset->remark_internal_doc = $request->remark_internal_doc ?? "";

                // ERP Invoice
                $asset->asset_code_account = $request->asset_code_account ?? "";
                $asset->invoice_date = $request->invoice_posting_date ? Carbon::parse($request->invoice_posting_date)->format('Y-m-d H:i:s') : null;
                $asset->invoice_no = $request->invoice ?? "";
                $asset->fa = $request->fa ?? "";
                $asset->fa_class = $request->fa_class ?? "";
                $asset->fa_subclass = $request->fa_subclass ?? "";
                $asset->depreciation = $request->depreciation_book_code ?? "";
                $asset->fa_type = $request->fa_type ?? "";
                $asset->fa_location = $request->fa_location ?? "";
                $asset->cost = $request->cost ?? "";
                $asset->currency = $request->currency ?? "";
                $asset->vat = $request->vat ?? "";
                $asset->description = $request->description ?? "";
                $asset->invoice_description = $request->invoice_description ?? "";

                // Vendor
                $asset->vendor = $request->vendor ?? "";
                $asset->vendor_name = $request->vendor_name ?? "";
                $asset->address = $request->address ?? "";
                $asset->address2 = $request->address2 ?? "";
                $asset->contact = $request->contact ?? "";
                $asset->phone = $request->phone ?? "";
                $asset->email = $request->email ?? "";
                $asset->status = $request->status ?? 0;
                // Save the data
                $asset->save();
            }
            // Remove Existed File
            $this->remove_existed_file($request);

            // Add New FIle
            if ($request->file_state > 0) {
                for ($i = 1; $i <= $request->file_state; $i++) {  // Start from 1
                    $fileKey = 'file_doc' . $i;  // Dynamic file input key

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $fileName = $this->upload_file($file);

                        $file = new File();
                        $file->asset_id = $asset_user->id;
                        $file->varaint = $var;
                        $file->file = $fileName;
                        $file->save();
                        $file = new FileUser();
                        $file->asset_id = $asset_user->id;
                        $file->file = $fileName;
                        $file->save();
                    }
                }
            }
            // Add New Image
            if ($request->image_state > 0) {
                for ($i = 1; $i <= $request->image_state; $i++) {  // Start from 1
                    $imageKey = 'image' . $i;  // Dynamic image input key
                    if ($request->hasFile($imageKey)) {
                        $file = $request->file($imageKey);
                        $thumbnail = $this->upload_image($file);

                        $image = new Image();
                        $image->asset_id = $asset_user->id;
                        $image->varaint = $var;
                        $image->image = $thumbnail;
                        $image->save();  // Don't forget to save the image
                        $image = new ImageUser();
                        $image->asset_id = $asset_user->id;
                        $image->image = $thumbnail;
                        $image->save();  // Don't forget to save the image
                        // return 1;
                    }
                }
            }


            $this->update_existing_to_new_varaint($request, $asset_user->id, $var);
            $this->Change_log($asset_user->id, $last_varaint->varaint, "Update From", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
            $this->Change_log($asset_user->id, $last_varaint->varaint + 1, "Update To", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
            if ($asset_user) {
                return redirect('/admin/assets/list/1')->with('success', 'Update Asset Record Success.');
            } else {
                return redirect('/admin/assets/list/1')->with('fail', 'Opp!. Something when wronge.');
            }
        }else{
                return redirect('/')->with('fail','You do not have permission Assets Update.');
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

    public function view_varaint_asset($var, $id)
    {
        if(Auth::user()->permission->assets_read == 1){
            $update_able = 1;
            $asset = StoredAssets::with(['images', 'files'])
            ->where('assets_id', $id)
            ->Orderby('varaint', 'asc')
            ->get();

            $count = count($asset);
            $count -= 1;
            $current_varaint = $var;


            $qr_code = "No QR Code Generated";
            if ($asset[$var]->assets1 . $asset[$var]->assets2 != "") {
                $qr_code = QrCode::size(300)->format('svg')->generate($asset[$var]->assets1 . $asset[$var]->assets2);
            }


            return view('backend.update-assets-by-variant', ['asset' => $asset, 'total_varaint' => $count, 'current_varaint' => $current_varaint, 'qr_code' => $qr_code,'update_able' => $update_able]);
        }else{
                return redirect('/')->with('fail','You do not have permission Assets Read.');
      }

    }

    public function delete_admin_asset(request $request)
    {

        // if(Auth::user()->permission->assets_delete == 1 && Auth::user()->role == 'admin')  {
        //     $assets_id = $request->id;

        //     // Remove file and Image from server permanent
        //     $this->initailize_record($assets_id);
        //     File::where('asset_id', $assets_id)->delete();
        //     Image::where('asset_id', $assets_id)->delete();
        //     StoredAssets::where('assets_id', $assets_id)->delete();
        //     StoredAssetsUser::where('id', $assets_id)->delete();

        //     $this->Change_log($assets_id, "All Varaint", "Delete Permanent", "Asset Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
        //     return redirect("/admin/assets/list/1");


        // }elseif(Auth::user()->permission->assets_delete == 1 && Auth::user()->role == 'staff'){
            // $asset = StoredAssets::where("assets_id", $request->id)->where("last_varaint", 1)->first();
            // $asset->status = 1;


            // $asset->save();

            $asset_delete = StoredAssets::where('id', $request->id) ->where("last_varaint", 1)->first();
            $asset_delete->status = 1;
            $asset_delete->deleted_at = Carbon::parse(today())->format('Y-m-d H:i:s');
            $deleted = $asset_delete->save();



            $this->Change_log($asset_delete->assets_id, $asset_delete->varaint, "Delete", "Asset Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);

            if ($deleted) {
                return redirect("/admin/assets/list/1")->with('success', "Delete Record Success.");
            } else {
                return redirect("/admin/assets/list/1")->with('fail', "Opps. Somthing went wronge.");
            }
        // }
    //     else{
    //             return redirect('/')->with('fail','You do not have permission Asset Delete Role: Admin.');
    //   }
    }

    public function initailize_record($id)
    {

        $File = File::where('asset_id', $id)->get();
        $Image = Image::where('asset_id', $id)->get();

        if ($Image) {

            foreach ($Image as $item) {

                $filePath = public_path("uploads/image/" . $item->image);

                if (file_exists($filePath)) {

                    unlink($filePath);
                }
            }
        }
        $filePath = null;
        if ($File) {
            foreach ($File as $item) {
                $filePath = public_path("uploads/files/" . $item->file);

                if (file_exists($filePath)) {

                    unlink($filePath);
                }
            }
        }
    }

    public function restore(request $request)
    {
        if(Auth::user()->permission->assets_update == 1 && Auth::user()->role == 'admin'){
                     // Update Existing Last Varaint
        $last_varaint = StoredAssets::where("assets_id", $request->id)->where("last_varaint", 1)->select("varaint", "assets_id")->first();
        if (!empty($last_varaint)) {

            // Update Last Varaint to old
            $modify_last = StoredAssets::where("assets_id", $request->id)->where("last_varaint", 1)->first();
            $modify_last->last_varaint = 0;
            $modify_last->save();
            $var = $last_varaint->varaint += 1;

            // Create New Record as Last Varaint
            $asset = new StoredAssets();
            $asset->assets_id = $request->id;
            $asset->varaint = $var;
            $asset->document = $request->document ?? "";
            $asset->assets1 = $request->asset_code1 ?? "";
            $asset->assets2 = $request->asset_code2 ?? "";
            $asset->fa_no = $request->fa_no ?? "";
            $asset->item = $request->item ?? "";
            $asset->issue_date = $request->issue_date ? Carbon::parse($request->issue_date)->format('Y-m-d H:i:s') : null;
            $asset->initial_condition = $request->intail_condition ?? "";
            $asset->specification = $request->specification ?? "";
            $asset->item_description = $request->item_description ?? "";
            $asset->asset_group = $request->asset_group ?? "";
            $asset->remark_assets = $request->remark_assets ?? "";

            // Asset Holder
            $asset->asset_holder = $request->asset_holder ?? "";
            $asset->holder_name = $request->holder_name ?? "";
            $asset->position = $request->position ?? "";
            $asset->location = $request->location ?? "";
            $asset->department = $request->department ?? "";
            $asset->company = $request->company ?? "";
            $asset->remark_holder = $request->remark_holder ?? "";

            // Internal Document
            $asset->grn = $request->grn ?? "";
            $asset->po = $request->po ?? "";
            $asset->pr = $request->pr ?? "";
            $asset->dr = $request->dr ?? "";
            $asset->dr_requested_by = $request->dr_requested_by ?? "";
            $asset->dr_date = $request->dr_date ? Carbon::parse($request->dr_date)->format('Y-m-d H:i:s') : null;
            $asset->remark_internal_doc = $request->remark_internal_doc ?? "";

            // ERP Invoice
            $asset->asset_code_account = $request->asset_code_account ?? "";
            $asset->invoice_date = $request->invoice_posting_date ? Carbon::parse($request->invoice_posting_date)->format('Y-m-d H:i:s') : null;
            $asset->invoice_no = $request->invoice ?? "";
            $asset->fa = $request->fa ?? "";
            $asset->fa_class = $request->fa_class ?? "";
            $asset->fa_subclass = $request->fa_subclass ?? "";
            $asset->depreciation = $request->depreciation_book_code ?? "";
            $asset->fa_type = $request->fa_type ?? "";
            $asset->fa_location = $request->fa_location ?? "";
            $asset->cost = $request->cost ?? "";
            $asset->currency = $request->currency ?? "";
            $asset->vat = $request->vat ?? "";
            $asset->description = $request->description ?? "";
            $asset->invoice_description = $request->invoice_description ?? "";

            // Vendor
            $asset->vendor = $request->vendor ?? "";
            $asset->vendor_name = $request->vendor_name ?? "";
            $asset->address = $request->address ?? "";
            $asset->address2 = $request->address2 ?? "";
            $asset->contact = $request->contact ?? "";
            $asset->phone = $request->phone ?? "";
            $asset->email = $request->email ?? "";
            $asset->save();








            // Update Disbled Assets at user to Enable and update some Restore data
            $asset_user =  StoredAssetsUser::where('id', $last_varaint->assets_id)->first();
            $asset_user->status = 0;
            $asset_user->document = $request->document ?? "";
            $asset_user->assets1 = $request->asset_code1 ?? "";
            $asset_user->assets2 = $request->asset_code2 ?? "";
            $asset_user->fa_no = $request->fa_no ?? "";
            $asset_user->item = $request->item ?? "";
            $asset_user->issue_date = $request->issue_date ? Carbon::parse($request->issue_date)->format('Y-m-d H:i:s') : null;
            $asset_user->initial_condition = $request->intail_condition ?? "";
            $asset_user->specification = $request->specification ?? "";
            $asset_user->item_description = $request->item_description ?? "";
            $asset_user->asset_group = $request->asset_group ?? "";
            $asset_user->remark_assets = $request->remark_assets ?? "";

            // Asset Holder
            $asset_user->asset_holder = $request->asset_holder ?? "";
            $asset_user->holder_name = $request->holder_name ?? "";
            $asset_user->position = $request->position ?? "";
            $asset_user->location = $request->location ?? "";
            $asset_user->department = $request->department ?? "";
            $asset_user->company = $request->company ?? "";
            $asset_user->remark_holder = $request->remark_holder ?? "";

            // Internal Document
            $asset_user->grn = $request->grn ?? "";
            $asset_user->po = $request->po ?? "";
            $asset_user->pr = $request->pr ?? "";
            $asset_user->dr = $request->dr ?? "";
            $asset_user->dr_requested_by = $request->dr_requested_by ?? "";
            $asset_user->dr_date = $request->dr_date ? Carbon::parse($request->dr_date)->format('Y-m-d H:i:s') : null;
            $asset_user->remark_internal_doc = $request->remark_internal_doc ?? "";

            // ERP Invoice
            $asset_user->asset_code_account = $request->asset_code_account ?? "";
            $asset_user->invoice_date = $request->invoice_posting_date ? Carbon::parse($request->invoice_posting_date)->format('Y-m-d H:i:s') : null;
            $asset_user->invoice_no = $request->invoice ?? "";
            $asset_user->fa = $request->fa ?? "";
            $asset_user->fa_class = $request->fa_class ?? "";
            $asset_user->fa_subclass = $request->fa_subclass ?? "";
            $asset_user->depreciation = $request->depreciation_book_code ?? "";
            $asset_user->fa_type = $request->fa_type ?? "";
            $asset_user->fa_location = $request->fa_location ?? "";
            $asset_user->cost = $request->cost ?? "";
            $asset_user->currency = $request->currency ?? "";
            $asset_user->vat = $request->vat ?? "";
            $asset_user->description = $request->description ?? "";
            $asset_user->invoice_description = $request->invoice_description ?? "";

            // Vendor
            $asset_user->vendor = $request->vendor ?? "";
            $asset_user->vendor_name = $request->vendor_name ?? "";
            $asset_user->address = $request->address ?? "";
            $asset_user->address2 = $request->address2 ?? "";
            $asset_user->contact = $request->contact ?? "";
            $asset_user->phone = $request->phone ?? "";
            $asset_user->email = $request->email ?? "";
            $asset_user->save();
        } else {
            return redirect('/admin/assets/list/1')->with('fail', 'Record Not Found.');
        }
        // Add New FIle
        if ($request->file_state > 0) {
            for ($i = 1; $i <= $request->file_state; $i++) {  // Start from 1
                $fileKey = 'file_doc' . $i;  // Dynamic file input key

                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $fileName = $this->upload_file($file);

                    $file = new File();
                    $file->asset_id = $last_varaint->assets_id;
                    $file->varaint = $var;
                    $file->file = $fileName;
                    $file->save();
                    $file = new FileUser();
                    $file->asset_id = $last_varaint->assets_id;
                    $file->file = $fileName;
                    $file->save();
                }
            }
        }
        // Add New Image
        if ($request->image_state > 0) {
            for ($i = 1; $i <= $request->image_state; $i++) {  // Start from 1
                $imageKey = 'image' . $i;  // Dynamic image input key
                if ($request->hasFile($imageKey)) {
                    $file = $request->file($imageKey);
                    $thumbnail = $this->upload_image($file);

                    $image = new Image();
                    $image->asset_id = $last_varaint->assets_id;
                    $image->varaint = $var;
                    $image->image = $thumbnail;
                    $image->save();  // Don't forget to save the image
                    $image = new ImageUser();
                    $image->asset_id = $last_varaint->assets_id;
                    $image->image = $thumbnail;
                    $image->save();  // Don't forget to save the image
                    // return 1;
                }
            }
        }


        $this->Change_log($asset->assets_id, $asset->varaint, "Restore", "Asset Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);

        $this->update_existing_to_new_varaint($request, $last_varaint->assets_id, $var);

        if ($last_varaint) {
            return redirect('/admin/assets/list/1')->with('success', 'Restore Success.');
        } else {
            return redirect('/admin/assets/list/1')->with('fail', 'Opp!. Something when wronge.');
        }
        }else{
                return redirect('/')->with('fail','You do not have permission Update to Restore Old Assets and Role: admin .');
      }

    }
    public function print_qr($assets)
    {

        if(Auth::user()->permission->assets_read == 1){
            $qr_code = QrCode::size(50)->format('svg')->generate($assets);

            // Save the SVG to temporary storage
            $svgContent = $qr_code;
            Storage::disk('public')->put('qrcodes/my-qrcode.svg', $svgContent);

            return view('backend.print-qr', ['qr_code' => $qr_code, 'raw' => $assets]);

        }else{
                return redirect('/')->with('fail','You do not have permission Assets Read.');
      }

    }

    public function multi_print(Request $request)
    {
        $id = explode(',', $request->id);

        $count = count($id);
        $array_qr = [];

        if ($count > 0) {
            foreach ($id as $item) {

                $object = StoredAssets::where('id', $item)->first();
                if($object != null){

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
     if($count_array_qr != 0){

        return view('backend.print-qr', ['array_qr' => $array_qr]);
        }
        else{
            return redirect('/admin/assets/list/1')->with('fail', 'Opps. Somthing went wronge.');
        }

    }

    public function multi_export(request $request)
    {
        if(Auth::user()->permission->assets_read == 1){
            $ids = explode(',', $request->id_export);
            sort($ids);
            $data = [];
            foreach ($ids as $id) {
                $assets =  StoredAssetsUser::where('id', $id)->first();
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
                'AU1' => 'E-Mail'
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
                $sheet->setCellValue('B' . $row, $assets->assets1 . ' ' . $assets->assets2);  // Combine assets1 and assets2 in column B
                $sheet->setCellValue('C' . $row, $assets->document);  // Document in column C
                $sheet->setCellValue('D' . $row, $assets->fa_no);  // Fix Assets No in column D
                $sheet->setCellValue('E' . $row, $assets->item);  // Item in column E
                $sheet->setCellValue('F' . $row, $assets->issue_date);  // Issue Date in column F
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
        }else{
            return redirect('/')->with('fail','You do not have permission Assets Read to Export Data.');
        }
    }




    public function view_asset($id){
        if(Auth::user()->permission->assets_read == 1){
            $asset = StoredAssets::with(['images', 'files'])
            ->where('assets_id', $id)
            ->Orderby('varaint', 'asc')
            ->get();
        $count = count($asset);
        $count -= 1;
        $current_varaint = $count;
        $qr_code = "No QR Code Generated";



        if ($asset[$count]->assets1 . $asset[$count]->assets2 != "") {
            $qr_code = QrCode::size(300)->format('svg')->generate($asset[$count]->assets1 . $asset[$count]->assets2);
        }
        // Save the SVG to temporary storage
        $svgContent = $qr_code;
        if ($svgContent) {
            Storage::disk('public')->put('qrcodes/my-qrcode.svg', $svgContent);
        }

        $update_able = 0;

        $department = QuickData::where('type', 'department')->select('content')->orderby('id', 'desc')->get();
        $company = QuickData::where('type', 'company')->select('content')->orderby('id', 'desc')->get();
        // return $count;
        if (Auth::user()->role == "admin") {

            // return $asset;
            return view('backend.update-assets-by-variant', [
                'asset' => $asset,
                 'total_varaint' => $count,
                 'current_varaint' => $current_varaint,
                 'department' => $department,
                 'company' => $company,
                 'qr_code' => $qr_code,
                 'update_able' =>  $update_able

                ]);
        } elseif (Auth::user()->role == "staff") {

            return view('backend.update-assets', [
                'asset' => $asset[$count],
                'department' => $department,
                 'company' => $company,
                  'qr_code' => $qr_code,
                  'update_able' =>  $update_able

                ]);
        } else {
            return view('backend.dashboard')->with('fail', "You do not have permission on this function.");
        }
        }else{
                return redirect('/')->with('fail','You do not have permission Assets Update.');
  }
    }
}
