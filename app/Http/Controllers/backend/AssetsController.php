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

class AssetsController extends Controller
{
    public function assetes_add()
    {
        return view('backend.add-assets');
    }
    public function list_assets()
    {
        $start_year = date('Y');
        $start_month_day = '01-01';
        $start_date = $start_year . '-' . $start_month_day;
        $end_date = date('Y-m-d');


        if (Auth::user()->permission->assets_read == 1) {
            if (Auth::user()->role == "admin") {
                $asset =  StoredAssets::orderBy('assets_id', 'desc')
                    ->where("last_varaint", 1)
                    ->get();


                return view('backend.list_asset', [
                    'asset' => $asset,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]);
            } elseif (Auth::user()->role == "staff") {


                $asset =  StoredAssetsUser::orderBy('id', 'desc')
                    ->where('deleted', 0)
                    ->get();
                // return $asset;
                return view('backend.list_asset_staff', [
                    'asset' => $asset,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]);
            } else {
                return redirect("/")->with("fail", "You do not have User role in system.");
            }
        } else {
            return redirect("/")->with("fail", "You do not have permssion on read Assets Section.");
        }
    }

    public function list_select()
    {

        $start_year = date('Y');
        $start_month_day = '01-01';
        $start_date = $start_year . '-' . $start_month_day;
        $end_date = date('Y-m-d');

        // return "start_date : ". $start_date. "  end date: ".$end_date; 
        $data = RawFixAssets::select(
            'assets',
            'invoice_no',
            'description',
            'fa_subclass',
            'fa_class_code',
            'fa',
            'state',
            DB::raw("FORMAT(posting_date, 'yyyy-MM-dd') as assets_date")

        )

            ->orderBy('assets_date', 'desc')
            ->whereBetween('posting_date', [$start_date, $end_date])
            ->get();

        // return $data;
        return view('backend.list-select', [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function assets_add($assets, $invoice)
    {
        $modifiedString = str_replace('-', '/', $invoice);

        // return $modifiedString;
        $asset = Fix_assets::where('assets', $assets)
            ->where("fa", $modifiedString)
            ->first();

        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
        $company  = QuickData::where('type', "company")->select('id', 'content')->orderby('id', 'desc')->get();
        return view('backend.add-assets', [
            'asset' => $asset,
            'department' => $department,
            'company' => $company
        ]);
    }
    public function assets_add_by_search(Request $request)
    {


        //   "end_date": null,
        $query = null;
        $query = RawFixAssets::orderBy("assets_date", "desc");
        // return "case 1";
        if (!empty($request->assets)) {
            $query->where('assets', 'like', strtoupper('%' . $request->assets) . '%');
        }
        if (!empty($request->fa)) {
            $query->where('fa', 'like', strtoupper('%' . $request->fa) . '%');
        }
        if (!empty($request->invoice)) {
            $query->where('invoice_no', 'like', strtoupper('%' . $request->invoice) . '%');
        }
        if (!empty($request->description)) {
            $query->where('description', 'like', strtoupper('%' . $request->description) . '%');
        }
        if (!empty($request->state)) {
            if ($request->state != "All") {
                $query->where('state', $request->state);
            }
        }

        if ($request->start_date != "" && $request->end_date == "") {

            $query->whereBetween('assets_date', '<=', $request->end_date);
        } elseif ($request->start_date == "" && $request->end_date != "") {

            $query->whereBetween('assets_date', '>=', $request->start_date);
        } elseif ($request->start_date != "" && $request->end_date != "") {

            $query->whereBetween('assets_date', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date == "" && $request->end_date == "") {
        }
        $query->select(
            'assets',
            'invoice_no',
            'description',
            'fa_subclass',
            'fa_class_code',
            'fa',
            'state',
            DB::raw("FORMAT(posting_date, 'yyyy-MM-dd') as assets_date")
        );
        $data = $query->get();



        $count = COUNT($data);

        if ($count == 0) {
            return "case 2";
            $query = RawFixAssets::orderBy("assets_date", "desc");

            if (!empty($request->assets)) {
                $query->where('assets', 'like', '%' . $request->assets . '%');
            }
            if (!empty($request->fa)) {
                $query->where('fa', 'like', '%' . $request->fa . '%');
            }
            if (!empty($request->invoice)) {
                $query->where('invoice_no', 'like', '%' . $request->invoice . '%');
            }
            if (!empty($request->description)) {
                $query->where('description', 'like', '%' . $request->description . '%');
            }
            if (!empty($request->state)) {
                if ($request->state != "All") {
                    $query->where('state', $request->state);
                }
            }
            if ($request->start_date != "" && $request->end_date == "") {

                $query->whereBetween('assets_date', '<=', $request->end_date);
            } elseif ($request->start_date == "" && $request->end_date != "") {

                $query->whereBetween('assets_date', '>=', $request->start_date);
            } elseif ($request->start_date != "" && $request->end_date != "") {

                $query->whereBetween('assets_date', [$request->start_date, $request->end_date]);
            } elseif ($request->start_date == "" && $request->end_date == "") {
            }

            $query->select(
                'assets',
                'invoice_no',
                'description',
                'fa_subclass',
                'fa_class_code',
                'fa',
                'state',
                DB::raw("FORMAT(posting_date, 'yyyy-MM-dd') as assets_date")
            );
            $data = $query->get();
        }

        $search = array(
            "assets" => $request->assets,
            "fa" => $request->fa,
            "invoice" => $request->invoice,
            "description" => $request->description,
            "state"  => $request->state,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        );


        return view('backend.list-select', [
            'data' => $data,

            'search' => $search
        ]);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function list_asset_search(Request $request)
    {


        $query = null;
        $query = StoredAssets::orderBy("issue_date", "desc");

        if (!empty($request->assets)) {
            $query->where('assets', 'like', strtoupper('%' . $request->assets) . '%');
        }
        if (!empty($request->fa)) {
            $query->where('fa', 'like', strtoupper('%' . $request->fa) . '%');
        }
        if (!empty($request->fa)) {
            $query->where('invoice_no', 'like', strtoupper('%' . $request->invoice) . '%');
        }

        if (!empty($request->description)) {
            $query->where('description', 'like', strtoupper('%' . $request->description) . '%');
        }
        if (!empty($request->state)) {
            if ($request->state != "All") {
                $query->where('state', $request->state);
            }
        }
        $query->whereBetween('issue_date', [$request->start_date, $request->end_date]);
        $query->select(
            '*',

            DB::raw("FORMAT(issue_date, 'yyyy-MM-dd') as assets_date")
        );
        $asset = $query->get();



        $count = COUNT($asset);

        if ($count == 0) {
            $query = StoredAssets::orderBy("issue_date", "desc");

            if (!empty($request->assets)) {
                $query->where('assets', 'like', '%' . $request->assets . '%');
            }
            if (!empty($request->fa)) {
                $query->where('fa', 'like', '%' . $request->fa . '%');
            }
            if (!empty($request->fa)) {
                $query->where('invoice_no', 'like', '%' . $request->invoice . '%');
            }

            if (!empty($request->description)) {
                $query->where('description', 'like', '%' . $request->description . '%');
            }
            if (!empty($request->state)) {
                if ($request->state != "All") {
                    $query->where('state', $request->state);
                }
            }

            $query->select(
                '*',

                DB::raw("FORMAT(issue_date, 'yyyy-MM-dd') as assets_date")
            );
            $asset = $query->get();
        }
        // return $request->state;
        $search = array(
            "assets" => $request->assets,
            "fa" => $request->fa,
            "invoice" => $request->invoice,
            "description" => $request->description,
            "state"  => $request->state,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        );

        return view('backend.list-assets', [
            'asset' => $asset,
            'search' => $search
        ]);
    }
    public function assets_add_submit(Request $request)
    {
        // return $request;
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
            return redirect('/admin/assets/list')->with('success', 'Added 1 Asset Record.');
        } else {
            return redirect('/admin/assets/list')->with('fail', 'Opp!. Something when wronge.');
        }
    }

    public function update_asset($id)
    {

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



        $department = QuickData::where('type', 'department')->select('content')->orderby('id', 'desc')->get();
        $company = QuickData::where('type', 'company')->select('content')->orderby('id', 'desc')->get();
        // return $count;
        if (Auth::user()->role == "admin") {

            // return $asset;
            return view('backend.update-assets-by-variant', ['asset' => $asset, 'total_varaint' => $count, 'current_varaint' => $current_varaint, 'department' => $department, 'company' => $company, 'qr_code' => $qr_code]);
        } elseif (Auth::user()->role == "staff") {

            return view('backend.update-assets', ['asset' => $asset[$count], 'department' => $department, 'company' => $company, 'qr_code' => $qr_code]);
        } else {
            return view('backend.dashboard')->with('fail', "You do not have permission on this function.");
        }
    }
    public function update_submit(Request $request)
    {
        $asset_user = StoredAssetsUser::where('id', $request->id)->first();
        // return  $asset_user;
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
            return redirect('/admin/assets/list')->with('success', 'Update Asset Record Success.');
        } else {
            return redirect('/admin/assets/list')->with('fail', 'Opp!. Something when wronge.');
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
    public function staff_delete_submit(request $request)
    {

        $asset = StoredAssets::where("assets_id", $request->id)->where("last_varaint", 1)->first();
        $asset->deleted = 1;
        $asset->deleted_at = Carbon::parse(today())->format('Y-m-d H:i:s');

        $asset->save();

        $asset_delete = StoredAssetsUser::where('id', $request->id)->first();
        $asset_delete->deleted = 1;
        $asset_delete->save();



        $this->Change_log($asset->assets_id, $asset->varaint, "Delete", "Asset Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);

        if ($asset_delete) {
            return redirect("/admin/assets/list")->with('success', "Delete Record Success.");
        } else {
            return redirect("/admin/assets/list")->with('fail', "Opps. Somthing went wronge.");
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


        return view('backend.update-assets-by-variant', ['asset' => $asset, 'total_varaint' => $count, 'current_varaint' => $current_varaint,'qr_code' => $qr_code]);
    }

    public function delete_admin_asset(request $request)
    {
        $assets_id = $request->id;

        // Remove file and Image from server permanent 
        $this->initailize_record($assets_id);
        File::where('asset_id', $assets_id)->delete();
        Image::where('asset_id', $assets_id)->delete();
        StoredAssets::where('assets_id', $assets_id)->delete();
        StoredAssetsUser::where('id', $assets_id)->delete();

        $this->Change_log($assets_id, "All Varaint", "Delete Permanent", "Asset Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
        return redirect("/admin/assets/list");
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
            $asset_user->deleted = 0;
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
            return redirect('/admin/assets/list')->with('fail', 'Record Not Found.');
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
            return redirect('/admin/assets/list')->with('success', 'Restore Success.');
        } else {
            return redirect('/admin/assets/list')->with('fail', 'Opp!. Something when wronge.');
        }
    }
    public function print_qr($assets)
    {
        $qr_code = QrCode::size(50)->format('svg')->generate($assets);

        // Save the SVG to temporary storage
        $svgContent = $qr_code;
        Storage::disk('public')->put('qrcodes/my-qrcode.svg', $svgContent);

        return view('backend.print-qr', ['qr_code' => $qr_code, 'raw' => $assets]);
    }

    public function multi_print(Request $request){
        $id = explode(',',$request->id);
        
        $count = count($id);
        $array_qr = [];
        if($count > 0 ){
            foreach($id as $item){
                $object = StoredAssetsUser::where('id',$item)->first();
                array_push($array_qr,$object);
            }
        }

        return view('backend.print-qr',['array_qr'=>$array_qr]);
    }
}
