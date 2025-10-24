<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use App\Models\Fix_assets;
use App\Models\QuickData;
use App\Models\Unit;
use App\Models\StoredAssets;
use App\Models\New_assets;
use App\Models\TempCode;
use App\Models\User_property;
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
        } elseif (Auth::attempt(['name' => $name_email, 'temp_password' => $password], $remember)) {
            $user = Auth::user();
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'success' => 'Login Success.',
                'token' => $token,
                'user' => $user,
            ]);
        } elseif (Auth::attempt(['email' => $name_email, 'temp_password' => $password], $remember)) {
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

        $assets = Fix_assets::where('assets', 'like', '%' . $id . '%')->get();
        $count = count($assets);
        if ($count == 0) {
            $assets = Fix_assets::where('assets', 'like', '%' . strtoupper($id) . '%')->get();
        }

        return response()->json($assets);
    }


    public function Search_Raw_assets(Request $request)
    {


        $assets = $request->asset_val ?? 'NA';
        $fa = $request->fa_val ?? 'NA';
        $invoice = $request->invoice_val ?? 'NA';
        $description = $request->description_val ?? 'NA';
        $start = $request->start_val ?? 'NA';
        $end = $request->end_val ?? 'NA';
        $state = $request->state_val ?? 'NA';
        $page = $request->page ?? 0;
        $is_registered = $request->is_registered ?? 'NA';

        $viewpoint = User_property::where('user_id', Auth::user()->id)
            ->where('type', 'viewpoint')->first();
        $limit = $viewpoint->value ?? 50;
        $offset = $page > 0 ? ($page - 1) * $limit : 0;

        // Base query: join Raw Fix Assets view with assets_transaction table
        $sql = DB::table('Raw Fix Assets as r')
            ->leftJoin('assets_transaction as m', function ($join) {
                $join->on(DB::raw('r.assets COLLATE SQL_Latin1_General_CP1_CI_AS'), '=', 'm.assets1');
            })
            ->select(
                'r.*',
                DB::raw('CASE WHEN m.assets1 IS NULL THEN 0 ELSE 1 END as is_registered'),
                DB::raw("FORMAT(r.posting_date, 'yyyy-MM-dd') as assets_date")
            );

        // Filters
        if (strtolower($assets) !== 'na') $sql->whereRaw('LOWER(r.assets) LIKE ?', ['%' . strtolower($assets) . '%']);
        if (strtolower($fa) !== 'na') $sql->whereRaw('LOWER(r.fa) LIKE ?', ['%' . strtolower($fa) . '%']);
        if (strtolower($invoice) !== 'na') $sql->whereRaw('LOWER(r.invoice_no) LIKE ?', ['%' . strtolower($invoice) . '%']);
        if (strtolower($description) !== 'na') $sql->whereRaw('LOWER(r.description) LIKE ?', ['%' . strtolower($description) . '%']);

        if ($state != 'NA') {
            if ($state == 'All') {
                if ($start != 'NA' && $end != 'NA') $sql->whereBetween('r.posting_date', [$start, $end]);
                elseif ($start != 'NA') $sql->where('r.posting_date', '>=', $start);
                elseif ($end != 'NA') $sql->where('r.posting_date', '<=', $end);
            } elseif ($state == 'invoice') {
                if ($start != 'NA' && $end != 'NA') $sql->whereBetween('r.posting_date', [$start, $end]);
                elseif ($start != 'NA') $sql->where('r.posting_date', '>=', $start);
                elseif ($end != 'NA') $sql->where('r.posting_date', '<', $end);
                $sql->where('r.state', 'like', '%invoice%');
            } elseif ($state == 'no_invoice') {
                $sql->where('r.state', 'no_invoice');
            }
        }

        // Get all results first (filtering by is_registered in PHP)
        $all_data = $sql->orderBy('r.posting_date', 'desc')->get();

        if ($is_registered !== 'NA') {
            $all_data = $all_data->filter(function ($item) use ($is_registered) {
                return intval($item->is_registered) == intval($is_registered);
            })->values();
        }

        $total_count = $all_data->count();
        $asset_data = $all_data->slice($offset, $limit)->values();
        $total_pages = ceil($total_count / $limit);

        return response()->json($total_count > 0 ? (object)[
            'page' => $page,
            'total_page' => $total_pages,
            'total_record' => $total_count,
            'data' => $asset_data
        ] : []);
    }



    public function search_list_asset_more(Request $request)
    {
        $company = $request->company ?? "";
        $department = $request->department ?? "";
        $assets = $request->asset ?? "";
        $item = $request->description ?? "";
        $start = $request->start ?? "";
        $end = $request->end ?? "";
        $state = $request->state ?? "NA";
        $type = $request->type ?? "NA";
        $value = $request->value ?? "NA";
        $user = $request->user ?? "NA";
        $page = $request->page ?? 1;

        // ✅ Base fields to always return
        $selectFields = [
            'assets_id',
            'reference',
            'assets1',
            'assets2',
            'item',
            'transaction_date',
            'initial_condition',
            'specification',
            'holder_name',
            'department',
            'company',
            'status_recieved',
            'old_code',
            'status',
            'deleted',
            'created_at',
            'variant'
        ];

        // Add dynamic $type field if needed
        if ($type != "NA" && !in_array($type, $selectFields)) {
            $selectFields[] = $type;
        }

        // Build query
        $data = StoredAssets::select($selectFields)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('assets1', 'desc');

        // Filters
        if ($user != "NA") {
            $data->where("holder_name", 'LIKE', "%" . $user . "%");
        }
        if ($assets != "NA") {
            $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%" . $assets . "%");
        }
        if ($company != "NA") {
            $data->where("company", 'LIKE', "%" . $company . "%");
        }
        if ($department != "NA") {
            $data->where("department", 'LIKE', "%" . $department . "%");
        }
        if ($item != "NA") {
            $data->where("description", 'LIKE', "%" . $item . "%");
        }

        // Date filters
        if ($start != "NA" && $end != "NA") {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();
            $data->whereBetween('transaction_date', [$startDate, $endDate]);
        } elseif ($start != "NA") {
            $startDate = Carbon::parse($start)->startOfDay();
            $data->where('transaction_date', '>=', $startDate);
        } elseif ($end != "NA") {
            $endDate = Carbon::parse($end)->endOfDay();
            $data->where('transaction_date', '<=', $endDate);
        }

        // Status filter
        if ($state != "NA") {
            if ($state == 0) {
                $data->where("status", 0);
            } elseif ($state == 1) {
                $data->where("status", 1);
            } elseif ($state == 2) {
                $data->where("status", 2);
            }
        }

        // Dynamic $type filter
        if ($type != "NA" && $value != "NA") {
            $data->where($type, 'LIKE', '%' . $value . '%');
        }

        // Pagination
        $viewpoint = User_property::where('user_id', Auth::user()->id)
            ->where('type', 'viewpoint')
            ->first();

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user' || Auth::user()->role == 'super_normal') {
            $data->where('deleted', 0);
        }
        $limit = $viewpoint->value ?? 50;
        $offset = ($page != 0) ? ($page - 1) * $limit : 0;
        $count = $data->where('deleted', 0)->count();

        $asset_data = $data->limit($limit)
            ->offset($offset)
            ->get();

        $total_pages = ceil($count / $limit);

        // Response
        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $asset_data;

        if ($count > 0) {
            return response()->json($arr)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache');
        } else {
            return response()->json([]);
        }
    }


    public function search_list_movement_more(Request $request)
    {
        $company = $request->company ?? "";
        $department = $request->department ?? "";
        $assets = $request->asset ?? "";
        $item = $request->description ?? "";
        $start = $request->start ?? "";
        $end = $request->end ?? "";
        $state = $request->state ?? "NA";
        $type = $request->type ?? "NA";
        $value = $request->value ?? "NA";
        $user = $request->user ?? "NA";
        $page = $request->page ?? 1;

        // Base fields to always return
        $selectFields = [
            'assets_id',
            'reference',
            'assets1',
            'assets2',
            'item',
            'transaction_date',
            'initial_condition',
            'specification',
            'holder_name',
            'department',
            'company',
            'status_recieved',
            'old_code',
            'status',
            'deleted',
            'created_at',
            'variant'
        ];

        // Add dynamic $type field if needed
        if ($type != "NA" && !in_array($type, $selectFields)) {
            $selectFields[] = $type;
        }

        // Build query
        $data = movement::select($selectFields)
            ->orderBy('transaction_date', 'desc');

        // Filters
        if ($user != "NA") {
            $data->where("holder_name", 'LIKE', "%" . $user . "%");
        }
        if ($assets != "NA") {
            $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%" . $assets . "%");
        }
        if ($company != "NA") {
            $data->where("company", 'LIKE', "%" . $company . "%");
        }
        if ($department != "NA") {
            $data->where("department", 'LIKE', "%" . $department . "%");
        }
        if ($item != "NA") {
            $data->where("item", 'LIKE', "%" . $item . "%");
        }

        // Date filters
        if ($start != "NA" && $end != "NA") {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();
            $data->whereBetween('transaction_date', [$startDate, $endDate]);
        } elseif ($start != "NA") {
            $startDate = Carbon::parse($start)->startOfDay();
            $data->where('transaction_date', '>=', $startDate);
        } elseif ($end != "NA") {
            $endDate = Carbon::parse($end)->endOfDay();
            $data->where('transaction_date', '<=', $endDate);
        }

        // Status filter
        if ($state != "NA") {
            if ($state == 0) {
                $data->where("status", 0);
            } elseif ($state == 1) {
                $data->where("status", 1);
            }
        }

        // Dynamic $type filter
        if ($type != "NA" && $value != "NA") {
            $data->where($type, 'LIKE', '%' . $value . '%');
        }

        // Pagination
        $viewpoint = User_property::where('user_id', Auth::user()->id)
            ->where('type', 'viewpoint')
            ->first();
        $limit = $viewpoint->value ?? 50;
        $offset = ($page != 0) ? ($page - 1) * $limit : 0;

        $count = $data->where('deleted',0)->count();

        // Filter deleted only for admin
       if (Auth::user()->role == 'admin' || Auth::user()->role == 'user' || Auth::user()->role == 'super_normal') {
            $data->where('deleted', 0);
        }

        $asset_data = $data->limit($limit)
            ->offset($offset)
            ->get();

        $total_pages = ceil($count / $limit);

        // Response
        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $asset_data;

        if ($count > 0) {
            return response()->json($arr)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache');
        } else {
            return response()->json([]);
        }
    }


    public function seach_changeLog(Request $request)
    {

        $start = $request->start ?? "NA";
        $end = $request->end ?? "NA";

        $key = $request->key ?? 'NA';
        $varaint = $request->varaint ?? 'NA';
        $change = $request->change ?? 'NA';
        $section = $request->section ?? 'NA';
        $change_by = $request->change_by ?? 'NA';
        $page = $request->page;

        $changeLog = ChangeLog::orderBy("id", "desc");
        if ($key != 'NA') {
            $changeLog->where('key', 'LIKE', '%' . $key . '%');
        }
        if ($varaint != 'NA') {
            $changeLog->where('varaint', 'LIKE', '%' . $varaint . '%');
        }

        if ($change  != 'NA') {
            $changeLog->where('change', 'LIKE', '%' . $change . '%');
        }


        if ($section != 'NA') {
            $changeLog->where('section', 'LIKE', '%' . $section . '%');
        }
        if ($change_by != 'NA') {
            $changeLog->where('change_by', $change_by);
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


        $viewpoint = User_property::where('user_id', Auth::user()->id)->where('type', 'viewpoint')->first();
        $limit = $viewpoint->value ?? 50;

        $total_pages = ceil($count / $limit);
        $offet = 0;
        if ($page != 0) {
            $offet = ($page - 1) * $limit;
        }

        $count_record =   $changeLog->count();
        $changeLog->limit($limit);
        $changeLog->offset($offet);
        $datas = $changeLog->get();
        $count = count($datas);



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


    public function mobile_search(Request $request)
    {
        $assets = $request->assets ?? 'NA';
        $role = $request->role ?? 'NA';

        if ($assets != 'NA') {
            if ($role == 'admin') {
                $sql =  StoredAssets::orderBy('assets_id', 'desc');
                $sql->where("last_varaint", 1);
                $sql->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%" . $assets . "%");
                $count =  $sql->count();
                $sql->limit(15);
                $datas = $sql->get();


                $arr = new arr();
                $arr->page  = 1;
                $arr->total_page = 1;
                $arr->total_record = $count;
                $arr->data = $datas;


                if ($count > 0) {
                    return response()->json($arr);
                } else {
                    return response()->json([]);
                }
            } else {
                // staff
            }
        }
        return response()->json([]);
    }




    public function check_name_for_reset_password(Request $request)
    {
        $name_email = $request->name_email;

        $count = 0;
        $user = User::where('name', $name_email)->first();


        if (empty($user)) {
            $user = User::where('email', $name_email)->first();
        }


        if (empty($user)) {
            return response()->json(["Invalid Name or Email."], 200);
        } else {




            $code = str_pad(rand(0, 99999), 10, '0', STR_PAD_LEFT);

            $new_code = new TempCode();
            $new_code->code = $code;
            $new_code->expire_at = Carbon::now()->addMinutes(15); // ✅ expires in 15 minutes
            $new_code->user_id = $user->id;
            $new_code->user_name = $user->name;
            $new_code->user_email = $user->email;
            $new_code->save();



            $fullname = $user->fname . ' ' . $user->lname;



            $mailData = [
                'fullName' => $fullname,
                'company' => $user->company,
                'department' => $user->department,
                'email' => $user->email,
                'temp_password' => $code,
                'phone' => $user->phone,

            ];
            // return response()->json(, 200);
            Mail::to($user->email)->send(new Mail_data($mailData));
            return response()->json("Code has sent to email:  " . $user->email . '  Check your Inbox to recieve Code.', 200);
        }
    }


    public function search_list_asset_new_more(Request $request)
    {
        $company = $request->company ?? "";
        $department = $request->department ?? "";
        $assets = $request->asset ?? "";
        $item = $request->description ?? "";
        $start = $request->start ?? "";
        $end = $request->end ?? "";
        $state = $request->state ?? "NA";
        $type = $request->type ?? "NA";
        $value = $request->value ?? "NA";
        $user = $request->user ?? "NA";
        $page = $request->page ?? 1;

        // Base fields to always return
        $selectFields = [
            'assets_id',
            'reference',
            'assets1',
            'assets2',
            'item',
            'transaction_date',
            'initial_condition',
            'specification',
            'holder_name',
            'department',
            'company',
            'status_recieved',
            'old_code',
            'status',
            'deleted',
            'created_at',
            'variant'
        ];

        // Add dynamic $type field if needed
        if ($type != "NA" && !in_array($type, $selectFields)) {
            $selectFields[] = $type;
        }

        // Build query
        $data = New_assets::select($selectFields)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('assets1', 'desc')
            ->where('deleted', '<>', 1);

        // Filters
        if ($user != "NA") {
            $data->where("holder_name", 'LIKE', "%" . $user . "%");
        }
        if ($assets != "NA") {
            $data->where(DB::raw("CONCAT(assets1, assets2)"), 'LIKE', "%" . $assets . "%");
        }
        if ($company != "NA") {
            $data->where("company", 'LIKE', "%" . $company . "%");
        }
        if ($department != "NA") {
            $data->where("department", 'LIKE', "%" . $department . "%");
        }
        if ($item != "NA") {
            $data->where("item", 'LIKE', "%" . $item . "%");
        }

        // Date filters
        if ($start != "NA" && $end != "NA") {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();
            $data->whereBetween('transaction_date', [$startDate, $endDate]);
        } elseif ($start != "NA") {
            $startDate = Carbon::parse($start)->startOfDay();
            $data->where('transaction_date', '>=', $startDate);
        } elseif ($end != "NA") {
            $endDate = Carbon::parse($end)->endOfDay();
            $data->where('transaction_date', '<=', $endDate);
        }

        // Status filter
        if ($state != "NA") {
            if ($state == 0) {
                $data->where("status", 0);
            } elseif ($state == 1) {
                $data->where("status", 1);
            }
        }

        // Dynamic $type filter
        if ($type != "NA" && $value != "NA") {
            $data->where($type, 'LIKE', '%' . $value . '%');
        }

        // Pagination
        $viewpoint = User_property::where('user_id', Auth::user()->id)
            ->where('type', 'viewpoint')
            ->first();
        $limit = $viewpoint->value ?? 50;
        $offset = ($page != 0) ? ($page - 1) * $limit : 0;
        $count = $data->where('deleted',0)->count();

        // Filter deleted only for admin
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'user' || Auth::user()->role == 'super_normal') {
            $data->where('deleted', 0);
        }

        $asset_data = $data->limit($limit)
            ->offset($offset)
            ->get();

        $total_pages = ceil($count / $limit);

        // Response
        $arr = new arr();
        $arr->page = $page;
        $arr->total_page = $total_pages;
        $arr->total_record = $count;
        $arr->data = $asset_data;

        if ($count > 0) {
            return response()->json($arr)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache');
        } else {
            return response()->json([]);
        }
    }



    public function updateToggle(Request $request)
    {
        $userId = $request->id; // make sure you trust this or validate
        $type = $request->type; // should be 'minimize'
        $value = $request->value; // 0 or 1

        if (!$userId || $type !== 'minimize') {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        // Find or create the record
        $property = User_property::firstOrNew([
            'user_id' => $userId,
            'type' => 'minimize'
        ]);

        // Update value
        $property->value = $value;
        $property->save();

        return response()->json($value); // returns 0 or 1
    }
    public function children($id)
    {
        $unit = Unit::findOrFail($id);

        // get immediate children (id, name, type)
        $children = $unit->children()->select('id', 'name', 'type')->get();

        return response()->json($children);
    }
    public function fetchUsers(Request $request)
    {
        $q = $request->query('q', ''); // search term, default empty

        $users = User::select('id', 'fname', 'lname')
            ->when($q != '', function ($query) use ($q) {
                $query->whereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%{$q}%"]);
            })
            ->where('status', 1)
            ->take(20) // limit results
            ->get()
            ->map(function ($u) {
                $u->full_name = trim($u->fname . ' ' . $u->lname);
                return $u;
            });

        return response()->json($users);
    }
}


class arr
{
    public $page;
    public $total_page;
    public $total_record;
    public $data;
}


class quick_data
{
    public $id;
    public $data;
}
