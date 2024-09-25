<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Fix_assets;
use App\Models\RawFixAssets;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ApiHandlerController extends Controller
{
    public function login_submit(Request $request) {
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
    
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    
    
    public function raw_search_detail($id)
    {

        $assets = Fix_assets::where('assets', $id)->get();

        return $assets;
    }


    public function Search_Raw_assets($assets, $fa, $invoice, $description, $start, $end, $state)
    {
        $modifiedString_fa = str_replace('-', '/', $fa);
        $modifiedString_invoice = str_replace('-', '/', $invoice);
        $modifiedString_description = str_replace('-', '/', $description);

        // RENEWAL AMM OF COTRIM SUSP FL/50ML

        $sql = RawFixAssets::orderBy("assets_date", "desc");

        if ($assets != "NA") {
            $sql->where("assets", "like", "%" . $assets . "%");
        }
        if ($fa != "NA") {

            $sql->where("fa", "like", "%" . $modifiedString_fa  . "%");
        }
        if ($invoice != "NA") {

            $sql->where("invoice_no", "like", "%" . $modifiedString_invoice . "%");
        }
        if ($description != "NA") {
            $sql->where("description", "like", "%" . $modifiedString_description . "%");
        }
        if ($state != "NA") {
            if ($state == "All") {
                if ($start != "NA" && $end != "NA") {
                    $sql->whereBetween('posting_date', [$start, $end]);
                } elseif ($start != "NA" && $end == "NA") {
                    $sql->where('posting_date', ">=", $start);
                } elseif ($start == "NA" && $end != "NA") {
                    $sql->where('posting_date', "<=", $end);
                }
            } elseif ($state == "invoice") {
                if ($start != "NA" && $end != "NA") {
                    $sql->whereBetween('posting_date', [$start, $end]);
                } elseif ($start != "NA" && $end == "NA") {
                    $sql->where('posting_date', ">=", $start);
                } elseif ($start == "NA" && $end != "NA") {
                    $sql->where('posting_date', "<", $end);
                }
                $sql->where('state', 'like', ["%" . $state . "%"]);
            } elseif ($state == "no_invoice") {
                $sql->where("state", 'like', ["%" . $state . "%"]);
            }
        }




        $data = $sql->get();
        $count = $data->count();
        if ($count > 0) {
            $sql = RawFixAssets::orderBy("assets_date", "desc");

            if ($assets != "NA") {
                $sql->where("assets", "like", "%" . strtoupper($assets) . "%");
            }
            if ($fa != "NA") {
    
                $sql->where("fa", "like", "%" . strtoupper($modifiedString_fa)  . "%");
            }
            if ($invoice != "NA") {
    
                $sql->where("invoice_no", "like", "%" . strtoupper($modifiedString_invoice) . "%");
            }
            if ($description != "NA") {
                $sql->where("description", "like", "%" . strtoupper($modifiedString_description ). "%");
            }
            if ($state != "NA") {
                if ($state == "All") {
                    if ($start != "NA" && $end != "NA") {
                        $sql->whereBetween('posting_date', [$start, $end]);
                    } elseif ($start != "NA" && $end == "NA") {
                        $sql->where('posting_date', ">=", $start);
                    } elseif ($start == "NA" && $end != "NA") {
                        $sql->where('posting_date', "<=", $end);
                    }
                } elseif ($state == "invoice") {
                    if ($start != "NA" && $end != "NA") {
                        $sql->whereBetween('posting_date', [$start, $end]);
                    } elseif ($start != "NA" && $end == "NA") {
                        $sql->where('posting_date', ">=", $start);
                    } elseif ($start == "NA" && $end != "NA") {
                        $sql->where('posting_date', "<", $end);
                    }
                    $sql->where('state', 'like', ["%" . $state . "%"]);
                } elseif ($state == "no_invoice") {
                    $sql->where("state", 'like', ["%" . $state . "%"]);
                }
            }
            $data = $sql->get();
            $count = $data->count();
        }





        if ($count > 0) {
            return response()->json($data);
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
            $data->where("assets_id", $id);
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
            $data->where("deleted", 0);
        } elseif ($state == 1) {
            $data->where("deleted", 1);
        } elseif ($state == 2) {
            $data->where("deleted", 2);
        }

        $asset_data = $data->get();

        // $asset_data = [$id];
        return response()->json($asset_data);

        // return response()->json($test);
    }










    public function search_list_asset_more(request $request){
        $type = $request->type??"NA";
        $value = $request->value??"NA";
        $modifiedString_value  = str_replace('-', '/', $value);


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
            $data->where("assets_id", $id);
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
            $data->where("deleted", 0);
        } elseif ($state == 1) {
            $data->where("deleted", 1);
        } elseif ($state == 2) {
            $data->where("deleted", 2);
        }

        if($type != "NA" && $value != "NA"){
            $data->where($type,'LIKE','%'.$modifiedString_value.'%');
        }

        $asset_data = $data->get();

        // $asset_data = [$id];
        return response()->json($asset_data);
    }
}
