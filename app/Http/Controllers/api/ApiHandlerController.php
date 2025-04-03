<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use App\Models\Fix_assets;
use App\Models\QuickData;
use App\Models\RawFixAssets;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use App\Models\movement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail_data;
use Exception;

class ApiHandlerController extends Controller
{
    public function login_submit(Request $request)
    {
        $name_email = $request->input('name_email');
        $password = $request->password;
        $remember = $request->remember;

        if (Auth::attempt(['name' => $name_email, 'password' => $password], $remember)) {
            $user = Auth::user();
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'success' => 'Login Success.',
                'token' => $token,
                'user' => $user,
            ]);
        } elseif (Auth::attempt(['email' => $name_email, 'password' => $password], $remember)) {
            $user = Auth::user();
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'success' => 'Login Success.',
                'token' => $token,
                'user' => $user,
            ]);
        }
        elseif(Auth::attempt(['name' => $name_email , 'temp_password' => $password],$remember)){
            $user = Auth::user();
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'success' => 'Login Success.',
                'token' => $token,
                'user' => $user,
            ]);
        }
        elseif(Auth::attempt(['email' => $name_email , 'temp_password' => $password],$remember)){
            $user = Auth::user();
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'success' => 'Login Success.',
                'token' => $token,
                'user' => $user,
            ]);
        }
        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function raw_search_detail($id)
    {

        $assets = Fix_assets::where('assets','like', '%'.$id.'%' )->get();
        $count = count($assets);
        if($count == 0){
                    $assets = Fix_assets::where('assets','like', '%'.strtoupper($id).'%' )->get();
        }

        return response()->json($assets);
    }


    public function Search_Raw_assets(request $request)
    {
        $assets = $request->asset_val??'NA';
        $fa = $request->fa_val??'NA';
        $invoice = $request->invoice_val??'NA';
        $description = $request->description_val??'NA';
        $start = $request->start_val??'NA';
        $end = $request->end_val??'NA';
        $state = $request->state_val??'NA';
        $page = $request->page??0;

        $sql = RawFixAssets::orderBy("assets_date", "desc");

        if ($assets != "NA") {
            $sql->where("assets", "like", "%" . $assets . "%");
        }
        if ($fa != "NA") {

            $sql->where("fa", "like", "%" . $fa . "%");
        }
        if ($invoice != "NA") {

            $sql->where("invoice_no", "like", "%" .  $invoice . "%");
        }
        if ($description != "NA") {
            $sql->where("description", "like", "%".$description."%");
        }
        if ($state != "NA") {
            if ($state == "All") {

                // All Date is exist
                if ($start != "NA" && $end != "NA") {
                    $sql->whereBetween('posting_date', [$start, $end]);
                // End Only
                } elseif ($start != "NA" && $end == "NA") {
                    $sql->where('posting_date', ">=", $start);
                // Start Only
                } elseif ($start == "NA" && $end != "NA") {
                    $sql->where('posting_date', "<=", $end);
                }else{

                }
            } elseif ($state == "invoice") {
                if ($start != "NA" && $end != "NA") {
                    $sql->whereBetween('posting_date', [$start, $end]);
                } elseif ($start != "NA" && $end == "NA") {
                    $sql->where('posting_date', ">=", $start);
                } elseif ($start == "NA" && $end != "NA") {
                    $sql->where('posting_date', "<", $end);
                }else{

                }
                $sql->where('state', 'like', ["%" . $state . "%"]);
            } elseif ($state == "no_invoice") {

                $sql->where("state",  $state );
            }
        }




        $limit = 150;
        $offet = 0;
        if($page != 0){
            $offet = ($page - 1) * $limit;
        }
        $count = $sql->count();



        $sql->limit($limit);
        $sql->offset($offet);
        $asset_data = $sql->get();
        $total_pages = ceil($count/$limit);


        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $asset_data;



        if ($count > 0) {
            return response()->json($arr);
        } else {
            return response()->json([]);
        }
    }




    public function fa_location()
    {
        $data = StoredAssetsUser::select("fa_type")->distinct()->get();

        $arr = [];
        foreach ($data as $item) {
            $count = StoredAssetsUser::where("fa_type", $item->fa_type)->count();

            if ($count) {
                // Push both the type and its count into the array
                array_push($arr, ['label' => $item->fa_type, 'value' => $count]);
            }
        }
        // Return the array as a JSON response
        return response()->json($arr);
    }


    public function assets_status()
    {
        $data = StoredAssetsUser::select(
            DB::raw("LEFT(DATENAME(MONTH, created_at), 3) AS label"),
            DB::raw("COUNT(id) AS value")
        )
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("LEFT(DATENAME(MONTH, created_at), 3)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->whereYear('created_at', today()->year)
            ->get();

        return response()->json($data);
    }

    public function search_list_asset(request $request)
    {
        $fa = $request->fa ?? "";
        $modifiedString_fa = str_replace('-', '/', $fa);

        $invoice = $request->invoice ?? "";
        $modifiedString_invoice  = str_replace('-', '/', $invoice);

        $assets = $request->asset ?? "";
        $modifiedString_assets = str_replace('/', '-', $assets);


        $description = $request->description ?? "";

        $modifiedString_decs = str_replace('-', '/', $description);
        $start = $request->start ?? "";

        $end = $request->end ?? "";
        $state = $request->state ?? "";

        $id = $request->id;

        $data =  StoredAssets::orderBy('assets_id', 'desc')
            ->where("last_varaint", 1);

        if ($id != "NA") {
            $data->where("assets_id", 'LIKE', "%".$id."%");
        }
        if ($assets != "NA") {
            $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%" . $modifiedString_assets . "%");
        }
        if ($fa != "NA") {
            $data->where("fa", 'LIKE', "%" . $modifiedString_fa . "%");
        }
        if ($invoice != "NA") {
            $data->where("invoice_no", 'LIKE', "%" . $modifiedString_invoice . "%");
        }
        if ($description != "NA") {
            $data->where("description", 'LIKE', "%" . $modifiedString_decs . "%");
        }

        // $sql->whereBetween('posting_date', [$start, $end]);
        // Two date
        if ($start != "NA" && $end != "NA") {
            $data->whereBetween("created_at", [$start, $end]);

            // Start Only
        } elseif ($start != "NA" && $end == "NA") {
            $data->where("created_at", '>=', $start);
            // End Only
        } elseif ($start == "NA" && $end != "NA") {
            $data->where("created_at", '<=', $end);
        }

        if ($state == "All") {
        } elseif ($state == 0) {
            $data->where("status", 0);
        } elseif ($state == 1) {
            $data->where("status", 1);
        } elseif ($state == 2) {
            $data->where("status", 2);
        }

        $asset_data = $data->get();

        // $asset_data = [$id];
        return response()->json($asset_data);

        // return response()->json($test);
    }

    public function search_list_asset_more(request $request)
    {

        $fa = $request->fa ?? "";
        $invoice = $request->invoice ?? "";
        $assets = $request->asset ?? "";
        $description = $request->description ?? "";
        $start = $request->start ?? "";
        $end = $request->end ?? "";
        $state = $request->state ?? "NA";
        $type = $request->type ?? "NA";
        $value = $request->value ?? "NA";
        $id = $request->id ?? "NA";
        $page =$request->page??1;


        $data =  StoredAssets::orderBy('assets_id', 'desc')
            ->where("last_varaint", 1);

        if ($id != "NA") {
            $data->where("assets_id", 'LIKE', "%".$id."%");
        }
        if ($assets != "NA") {
            $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%".$assets."%");
        }
        if ($fa != "NA") {
            $data->where("fa", 'LIKE',"%".$fa."%");
        }
        if ($invoice != "NA") {
            $data->where("invoice_no", 'LIKE',"%".$invoice."%");
        }
        if ($description != "NA") {
            $data->where("description", 'LIKE',"%".$description."%");
        }

        // Check if start and end are provided and not "NA"

        if ($start != "NA" && $end != "NA") {
            // Ensure both start and end are in the correct date format (e.g., 'Y-m-d H:i:s')
            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay(); // or use ->toDateTimeString() if needed
            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay(); // or use ->toDateTimeString()


            $data->whereBetween('issue_date', [$startDate, $endDate]);

            // Start date only provided
        } elseif ($start != "NA" && $end == "NA") {

            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
            $data->where('issue_date', '>=', $startDate);

            // End date only provided
        } elseif ($start == "NA" && $end != "NA") {

            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
            $data->where('issue_date', '<=', $endDate);
        }


        if($state != "NA"){
            if ($state == "All") {
            } elseif ($state == 0) {
                $data->where("status", 0);
            } elseif ($state == 1) {
                $data->where("status", 1);
            } elseif ($state == 2) {
                $data->where("status", 2);
            }


        }

        if ($type != "NA" && $value != "NA") {
            $data->where($type, 'LIKE', '%' . $value . '%');
        }


        $limit = 150;

        $offet = 0;
        if($page != 0){
            $offet = ($page - 1) * $limit;
        }
        $count = $data->count();

        $data->limit($limit);
        $data->offset($offet);
        $asset_data = $data->get();

        $total_pages = ceil($count/$limit);

        // return response()->json($count);
        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $asset_data;


        if ($count > 0) {
            return response()->json($arr );
        } else {
            return response()->json([]);
        }
    }


    // public function search_list_asset_more_staff(request $request)
    // {




    //     $fa = $request->fa ?? "";
    //     $invoice = $request->invoice ?? "";
    //     $assets = $request->asset ?? "";
    //     $description = $request->description ?? "";
    //     $start = $request->start ?? "";
    //     $end = $request->end ?? "";
    //     $state = $request->state ?? "NA";
    //     $type = $request->type ?? "NA";
    //     $value = $request->value ?? "NA";
    //     $id = $request->id ?? "NA";
    //     $page =$request->page??1;

    //     // return response()->json([$fa,$invoice,$assets]);

    //     $data =  StoredAssetsUser::orderBy('id', 'desc')
    //         ->where("status",'<>', 1);

    //     if ($id != "NA") {
    //         $data->where("id", 'LIKE', "%".$id."%");
    //     }
    //     if ($assets != "NA") {
    //         $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%".$assets."%");
    //     }
    //     if ($fa != "NA") {
    //         $data->where("fa", 'LIKE',"%".$fa."%");
    //     }
    //     if ($invoice != "NA") {
    //         $data->where("invoice_no", 'LIKE',"%".$invoice."%");
    //     }
    //     if ($description != "NA") {
    //         $data->where("description", 'LIKE',"%".$description."%");
    //     }



    //     // Check if start and end are provided and not "NA"
    //     if ($start != "NA" && $end != "NA") {
    //         // Ensure both start and end are in the correct date format (e.g., 'Y-m-d H:i:s')
    //         $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay(); // or use ->toDateTimeString() if needed
    //         $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay(); // or use ->toDateTimeString()

    //         // Query between the start and end dates
    //         $data->whereBetween('created_at', [$startDate, $endDate]);

    //         // Start date only provided
    //     } elseif ($start != "NA" && $end == "NA") {
    //         $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
    //         $data->where('created_at', '>=', $startDate);

    //         // End date only provided
    //     } elseif ($start == "NA" && $end != "NA") {
    //         $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
    //         $data->where('created_at', '<=', $endDate);
    //     }


    //     if($state != "NA"){
    //         if ($state == "All") {
    //         } elseif ($state == 0) {
    //             $data->where("status", 0);
    //         } elseif ($state == 1) {
    //             $data->where("status", 1);
    //         } elseif ($state == 2) {
    //             $data->where("status", 2);
    //         }


    //     }

    //     if ($type != "NA" && $value != "NA") {
    //         $data->where($type, 'LIKE', '%' . $value . '%');
    //     }


    //     $limit = 150;

    //     $offet = 0;
    //     if($page != 0){
    //         $offet = ($page - 1) * $limit;
    //     }
    //     $count = $data->count();

    //     $data->limit($limit);
    //     $data->offset($offet);
    //     $asset_data = $data->get();

    //     $total_pages = ceil($count/$limit);

    //     // return response()->json($count);
    //     $arr = new arr();
    //     $arr->page = $page;
    //     $arr->total_page = $total_pages;
    //     $arr->total_record = $count;
    //     $arr->data = $asset_data;


    //     if ($count > 0) {
    //         return response()->json($arr );
    //     } else {
    //         return response()->json([]);
    //     }
    // }
    public function seach_changeLog(Request $request)
    {

        $start = $request->start ?? "NA";
        $end = $request->end ?? "NA";

        $key = $request->key??'NA';
        $varaint = $request->varaint??'NA';
        $change = $request->change??'NA';
        $section = $request->section??'NA';
        $change_by= $request->change_by??'NA';
        $page =$request->page;

        $changeLog = ChangeLog::orderBy("id", "desc");
            if($key != 'NA'){
                $changeLog->where('key','LIKE', '%'. $key .'%');
            }
            if($varaint != 'NA'){
                $changeLog->where('varaint','LIKE', '%'.$varaint.'%');
            }

            if($change  != 'NA'){
                $changeLog->where('change','LIKE', '%'.$change .'%');
            }


            if($section != 'NA'){
                $changeLog->where('section','LIKE', '%'.$section.'%');
            }
            if($change_by != 'NA'){
                $changeLog->where('change_by',$change_by);
            }

          // Check if start and end are provided and not "NA"
          if ($start != "NA" && $end != "NA") {
            // Ensure both start and end are in the correct date format (e.g., 'Y-m-d H:i:s')
            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay(); // or use ->toDateTimeString() if needed
            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay(); // or use ->toDateTimeString()

            // Query between the start and end dates
            $changeLog->whereBetween('created_at', [$startDate, $endDate]);

            // Start date only provided
        } elseif ($start != "NA" && $end == "NA") {
            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
            $changeLog->where('created_at', '>=', $startDate);

            // End date only provided
        } elseif ($start == "NA" && $end != "NA") {
            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
            $changeLog->where('created_at', '<=', $endDate);
        }


            $data = $changeLog->get();
            $count = count($data);


            $limit = 150;

            $total_pages = ceil($count/$limit);
            $offet = 0;
            if($page != 0){
                $offet = ($page - 1) * $limit;
            }

            $count_record =   $changeLog->count();
            $changeLog->limit($limit);
            $changeLog->offset($offet);
            $datas = $changeLog->get();
            $count = count($datas );



           $arr = new arr();
           $arr->page = $page;
           $arr->total_page = $total_pages;
           $arr->total_record = $count_record;
           $arr->data = $datas;


            if ($count > 0) {
                return response()->json($arr);
            } else {
                return response()->json([]);
            }


    }
    public function qucik_data_search(Request $request){
        $type = $request->type??'NA';
        $content = $request->content??'NA';
        $page = $request->page??1;

        $data = QuickData::orderby('id','desc');
        if($type    != 'NA' && $content != 'NA'){
            $data->where($type,'LIKE', '%'.$content.'%');
        }
        $count_post =  $data->count();

        $limit = 150;
        $total_pages = ceil($count_post/$limit);
        $offet = 0;
        if($page != 0){
            $offet = ($page - 1) * $limit;
        }

        $data->limit($limit);
        $data->offset($offet);



        $datas = $data->get();
        $arr = new arr();

        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count_post;
        $arr->data = $datas;

        if($count_post > 0 ){
            return response()->json($arr);
        }else{
            return response()->json([]);
        }

    }

    public function mobile_search(Request $request){
        $assets = $request->assets??'NA';
        $role = $request->role??'NA';

        if($assets != 'NA'){
            if($role == 'admin'){
                $sql =  StoredAssets::orderBy('assets_id', 'desc');
                $sql->where("last_varaint", 1);
                $sql->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%".$assets."%");
                $count =  $sql->count();
                $sql->limit(15);
                $datas = $sql->get();


                $arr = new arr();
                $arr->page  =1;
                $arr->total_page = 1;
                $arr->total_record = $count ;
                $arr->data = $datas;


                if($count > 0){
                    return response()->json($arr);
                }else{
                    return response()->json([]);
                }

            }else{
                // staff
            }



        }
        return response()->json([]);
    }

    public function search_list_movement_more(Request $request){




        $fa = $request->fa ?? "";
        $invoice = $request->invoice ?? "";
        $assets = $request->asset ?? "";
        $description = $request->description ?? "";
        $start = $request->start ?? "";
        $end = $request->end ?? "";
        // $state = $request->state ?? "NA";
        $type = $request->type ?? "NA";
        $value = $request->value ?? "NA";
        $id = $request->id ?? "NA";
        $page =$request->page??1;
        $role = $request->role??'NA';




        $data =  StoredAssets::orderBy('assets_id', 'desc')
            ->where("last_varaint", 1);
        if($role != 'NA'){
            if($role == 'staff'){
                $data->where('status', '<>', 1);
            }
        }
        if ($id != "NA") {
            $data->where("assets_id", 'LIKE', "%".$id."%");
        }
        if ($assets != "NA") {
            $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%".$assets."%");
        }
        if ($fa != "NA") {
            $data->where("fa", 'LIKE',"%".$fa."%");
        }
        if ($invoice != "NA") {
            $data->where("invoice_no", 'LIKE',"%".$invoice."%");
        }
        if ($description != "NA") {
            $data->where("description", 'LIKE',"%".$description."%");
        }



        // Check if start and end are provided and not "NA"
        if ($start != "NA" && $end != "NA") {
            // Ensure both start and end are in the correct date format (e.g., 'Y-m-d H:i:s')
            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay(); // or use ->toDateTimeString() if needed
            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay(); // or use ->toDateTimeString()

            // Query between the start and end dates
            $data->whereBetween('created_at', [$startDate, $endDate]);

            // Start date only provided
        } elseif ($start != "NA" && $end == "NA") {
            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
            $data->where('created_at', '>=', $startDate);

            // End date only provided
        } elseif ($start == "NA" && $end != "NA") {
            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
            $data->where('created_at', '<=', $endDate);
        }

        $data->where("status", 0);


        if ($type != "NA" && $value != "NA") {
            $data->where($type, 'LIKE', '%' . $value . '%');
        }


        $limit = 150;

        $offet = 0;
        if($page != 0){
            $offet = ($page - 1) * $limit;
        }
        $data->where('status','<>',1);
        $count = $data->count();

        $data->limit($limit);
        $data->offset($offet);

        $asset_data = $data->get();

        $total_pages = ceil($count/$limit);

        // return response()->json($count);
        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $asset_data;


        if ($count > 0) {
            return response()->json($arr );
        } else {
            return response()->json([]);
        }
    }


    public function search_movement_more(Request $request){
        $limit = 150;

        $id = $request->movement_id ??'NA';
        $movement_no = $request->movement_no??'NA';
        $assets = $request->assets??'NA';
        $status  = $request->status??'NA';
        $from_department = $request->from_department??'NA';
        $to_department   = $request->to_department??'NA';
        $start = $request->start_date??'NA';
        $end = $request->end_date??'NA';
        $other_search  = $request->other_search??'NA';
        $other_value = $request->other_value??'NA';
        $page = $request->page??1;


        $data = movement::orderBy('id','desc');

        if($id != 'NA'){
            $data->where('id','LIKE','%'.$id.'%');
        }
        if($movement_no != 'NA'){
            $data->where('movement_no','LIKE','%'.$movement_no.'%');
        }
        if($assets != 'NA'){
            $data->where('assets_no','LIKE','%'.$assets.'%');
        }

        if($from_department != 'NA'){
            $data->where('from_department','LIKE','%'.$from_department.'%');
        }
        if($to_department != 'NA'){
            $data->where('to_department','LIKE','%'.$to_department.'%');
        }


       // Check if start and end are provided and not "NA"
       if ($start != "NA" && $end != "NA") {
        // Ensure both start and end are in the correct date format (e.g., 'Y-m-d H:i:s')
        $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay(); // or use ->toDateTimeString() if needed
        $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay(); // or use ->toDateTimeString()

        // Query between the start and end dates
        $data->whereBetween('created_at', [$startDate, $endDate]);

        // Start date only provided
        } elseif ($start != "NA" && $end == "NA") {
            $startDate = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
            $data->where('created_at', '>=', $startDate);

            // End date only provided
        } elseif ($start == "NA" && $end != "NA") {
            $endDate = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
            $data->where('created_at', '<=', $endDate);
        }

        if ($other_search != "NA" && $other_value  != "NA") {
            $data->where($other_search, 'LIKE', '%' . $other_value . '%');
        }

        if($status != 'NA'){
            if($status != 'All'){
                if($status == 'not3'){
                    $data->where('status','<>',3);
                }else{
                    $data->where('status',$status);
                }

            }

        }
        $offet = 0;
        if($page != 0){
            $offet = ($page - 1) * $limit;
        }


        $count = $data->count();
        $data->limit($limit);
        $data->offset($offet);
        $datas = $data->get();


        $total_pages = ceil($count/$limit);

        // return response()->json($count);
        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $datas;

        if( $count > 0){
            return response()->json($arr);
        }else{
            return response()->json(["No found"]);
        }

    }
    public function check_name_for_reset_password(Request $request){
        $name_email = $request->name_email;

        $count = 0;
        $user = User::where('name',$name_email)->first();


        if(empty($user)){
            $user = User::where('email',$name_email)->first();
        }


        if(empty($user)){
            return response()->json(["Invalid Name or Email."], 200 );
        }else{

            $temp_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
            $user->temp_password =  Hash::make($temp_password);
            $user->temp_password_expires_at = Carbon::now()->addMinutes(15); // Password expires in 15 minutes
            $user->save();




            $fullname = $user->fname.' '.$user->lname;

                 $mailData = [
                    'fullName' => $fullname,
                    'company' => $user->company,
                    'department' => $user->department,
                    'email' => $user->email,
                    'temp_password' => $temp_password,
                    'phone' => $user->phone,

                ];
                // return response()->json(, 200);
                Mail::to($user->email)->send(new Mail_data($mailData));
            return response()->json("Code has sent to email:  ".$user->email.'  Check your Inbox to recieve Code.' , 200);
        }


    }
}


class arr {
    public $page;
    public $total_page;
    public $total_record;
    public $data;

}
