<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Fix_assets;
use App\Models\Register_assets;
use App\Models\StoredAssets;
use App\Models\TempCode;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\movement;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard_admin($report = null, $year = null, $month = null)
    {

        $report = $report ?? 1; // default to report 1 if null
        $year = $year ?? now()->year;   // default to current year if null
        $month = $month ?? now()->month; // default to current month if null

        $yearFilter  = ($year === 'all' || $year === null) ? null : (int) $year;
        $monthFilter = ($month === 'all' || $month === null) ? null : (int) $month;

        $year_name  = $yearFilter ? $yearFilter : 'All Years';
        $month_name = $monthFilter ? Carbon::create()->month($monthFilter)->format('F') : 'All Months';

        if ($report == 1) {
            // Chart 1: This Month Status

            // Base query helper
            function applyDateFilters($query, $yearFilter, $monthFilter)
            {
                if ($yearFilter) {
                    $query->whereYear('transaction_date', $yearFilter);
                }
                if ($monthFilter) {
                    $query->whereMonth('transaction_date', $monthFilter);
                }
                return $query;
            }

            if ($year == 'all') {
                $year = now()->year;
            }
            if ($month == 'all') {
                $month = now()->month;
            }
            // --- This Month / Year Active Assets ---
            $assetsQuery = Register_assets::where('deleted', 0)->where('status', 1);

            // Apply date filters (or default to today if none)
            $assetsQueryMonth = clone $assetsQuery;
            $assetsQueryMonth = applyDateFilters($assetsQueryMonth, $yearFilter ?? Carbon::now()->year, $monthFilter ?? Carbon::now()->month);
            $this_month_status = $assetsQueryMonth->select('company', DB::raw('COUNT(*) as total'))
                ->groupBy('company')
                ->pluck('total', 'company');
            $total_qty_this_month = $this_month_status->sum();

            $assetsQueryYear = clone $assetsQuery;
            $assetsQueryYear = applyDateFilters($assetsQueryYear, $yearFilter ?? Carbon::now()->year, null); // only year
            $this_year_status = $assetsQueryYear->select('company', DB::raw('COUNT(*) as total'))
                ->groupBy('company')
                ->pluck('total', 'company');
            $total_qty_this_year = $this_year_status->sum();

            // --- This Month Movement ---
            $movementQuery = movement::where('deleted', 0)->whereIn('status', [0, 1]);
            $movementQueryMonth = clone $movementQuery;
            $movementQueryMonth = applyDateFilters($movementQueryMonth, $yearFilter ?? Carbon::now()->year, $monthFilter ?? Carbon::now()->month);
            $this_month_movement = $movementQueryMonth->select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $active_count = $this_month_movement[1] ?? 0;
            $inactive_count = $this_month_movement[0] ?? 0;
            $movement = $active_count + $inactive_count;

            // --- This Year Movement ---
            $movementQueryYear = clone $movementQuery;
            $movementQueryYear = applyDateFilters($movementQueryYear, $yearFilter ?? Carbon::now()->year, null);
            $this_year_movement = $movementQueryYear->select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $active_count_year = $this_year_movement[1] ?? 0;
            $inactive_count_year = $this_year_movement[0] ?? 0;
            $movement_year = $active_count_year + $inactive_count_year;

            return view('backend.dashboard_sumarry', compact(
                'year',
                'month',
                'month_name',
                'year_name',
                'report',
                // Chart 1
                'this_month_status',
                'total_qty_this_month',

                // Chart 2
                'this_year_status',
                'total_qty_this_year',

                // Chart 3
                'active_count',
                'inactive_count',
                'movement',

                // Chart 4
                'active_count_year',
                'inactive_count_year',
                'movement_year'
            ));
        } elseif ($report == 2) {
            // Handle filters

            // Base query builder for all reports
            $baseQuery = StoredAssets::query()
                ->when($yearFilter, function ($q) use ($yearFilter) {
                    $q->whereYear('transaction_date', '<=', $yearFilter);
                })
                ->when($monthFilter, function ($q) use ($monthFilter) {
                    $q->whereMonth('transaction_date', '<=', $monthFilter);
                });

            // Chart 1: Company for reports 2
            $companyRecords = (clone $baseQuery)
                ->selectRaw('company, COUNT(*) as total')
                ->groupBy('company')
                ->orderBy('company')
                ->get();


            $labels_company = $companyRecords->pluck('company');
            $data_company   = $companyRecords->pluck('total');
            $totalQty_company = $companyRecords->sum('total');
            $departmentsData = [];
            foreach ($labels_company as $company) {
                $departmentRecords = (clone $baseQuery)
                    ->selectRaw('department, COUNT(*) as total')
                    ->where('company', $company)
                    ->groupBy('department')
                    ->orderBy('department')
                    ->get();

                $departmentsData[$company] = [
                    'labels' => $departmentRecords->pluck('department'),
                    'data'   => $departmentRecords->pluck('total'),
                    'total'  => $departmentRecords->sum('total'),
                ];
            }

            return view('backend.dashboard_company_department', compact(
                'labels_company',
                'data_company',
                'year',
                'month',
                'totalQty_company',
                'month_name',
                'year_name',
                'report',
                'departmentsData'
            ));
        } elseif ($report == 3) {
            // Active counts per year
            $active_by_year = movement::selectRaw("
            YEAR(transaction_date) as year,
            COUNT(*) as active_count")
                ->groupByRaw("YEAR(transaction_date)")
                ->orderByRaw("YEAR(transaction_date) ASC")
                ->get();





            // Register counts per year
            $register_by_year = Register_assets::selectRaw("
            YEAR(transaction_date) as year,
            COUNT(*) as register_count")
                ->groupByRaw("YEAR(transaction_date)")
                ->orderByRaw("YEAR(transaction_date) ASC")
                ->get();

            $labels = $active_by_year->pluck('year');
            $activeData = $active_by_year->pluck('active_count');
            $registerData = $register_by_year->pluck('register_count');

            // Extract years and counts
            $labels = $register_by_year->pluck('year');
            $registerCounts = $register_by_year->pluck('register_count');

            // Compute cumulative register counts
            $cumulativeRegister = [];
            $sum = 0;
            foreach ($registerCounts as $count) {
                $sum += $count;
                $cumulativeRegister[] = $sum;
            }

            // Active counts (if you want them normal, keep as-is)
            $activeData = $active_by_year->pluck('active_count');






            return view('backend.dashboard_timeline', compact(
                'year',
                'month',
                'labels',
                'activeData',
                'registerData',
                'report',


                // chart 3
                'cumulativeRegister'
            ));
        }
    }


    public function login()
    {
        return view('backend.login');
    }
    public function login_submit(Request $request)
    {

        $name_email = $request->input('name_email');
        $password = $request->password;
        $remember = $request->remember;

        // Name
        if (Auth::attempt(['name' => $name_email, 'password' => $password], $remember)) {
            if (Auth::user()->status == 0) {
                Auth::logout();   return redirect("/login")->with('fail', 'Your user has been disable from System.');
            }
            return redirect('/')->with('sucess', 'Login Success.');

        // Email
        } elseif (Auth::attempt(['email' => $name_email, 'password' => $password], $remember)) {
            if (Auth::user()->status == 0) {
                Auth::logout();   return redirect("/login")->with('fail', 'Your user has been disable from System.');
            }

            return redirect('/')->with('sucess', 'Login Success.');
        }else {

            return redirect('/login')->with('fail', 'Invalid Credential');
        }
    }
    public function logout()
    {
        $auth = Auth::logout();

        if ($auth) {
            return redirect("/login")->with('success', 'Logout Suceess.');
        } else {
            return redirect("/")->with('fail', 'Logout Suceess.');
        }
    }
    public function forgot_password()
    {

        return view('backend.forgot_password');
    }








    public function login_submit_code_to_reset(Request $request)
    {

        $code = $request->code;
        $name_email = $request->user_name;
        //  return $name_email ;
        $tempCode = TempCode::where('code', $code)
            ->where('user_name', $name_email)
            ->first();


        if (!$tempCode) {
            $tempCode = TempCode::where('code', $code)
                ->where('user_email', $name_email)
                ->first();
        }

        if (!$tempCode) {
            return redirect()->back()->with('error', 'Code Not Found, Try again.');
        }
        // Compare current time with expire_at
        if (Carbon::now()->gt(Carbon::parse($tempCode->expire_at))) {
            return redirect('/forgot/password')->with('error', 'Code expired, try again.');
        }
        $user = User::where('id', $tempCode->user_id)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User Not Found.');
        }

        return view('backend.reset_password', [
            'user' => $user,
            'tempCode' => $tempCode
        ]);
    }
    public function reset_submit(request $request)
    {

        $tempCode = TempCode::where('code', $request->temp_code)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$tempCode) {
            return redirect('/forgot/password')->with('error', 'Invalid code.');
        }

        // Compare current time with expire_at
        if (Carbon::now()->gt(Carbon::parse($tempCode->expire_at))) {
            return redirect('/forgot/password')->with('error', 'Code expired, try again.');
        }
        $user = User::where('id', $request->user_id)->first();
        if (!$user) {
            return redirect('/forgot/password')->with('error', 'User Not Found.');
        }
        $user->password = Hash::make($request->password);
        $save = $user->save();

        if ($save) {
            return redirect('/login')->with('success', 'Reseted Passowrd Success.');
        } else {
            return redirect('/forgot/password')->with('error', 'Operation Fail');
        }
    }
}
