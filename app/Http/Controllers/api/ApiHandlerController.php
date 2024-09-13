<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Fix_assets;
use App\Models\RawFixAssets;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiHandlerController extends Controller
{
    public function raw_search_detail($id){
        
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
                if($state == "All"){
                    if($start != "NA" && $end != "NA"){
                        $sql->whereBetween('posting_date', [$start,$end]);
                    }elseif($start != "NA" && $end == "NA"){
                        $sql->where('posting_date' ,">=", $start);
                    }elseif($start== "NA" && $end !="NA"){
                        $sql->where('posting_date' ,"<=", $end);
                    }
                  
                }elseif($state == "invoice"){
                    if($start != "NA" && $end != "NA"){
                        $sql->whereBetween('posting_date', [$start,$end]);
                    }elseif($start != "NA" && $end == "NA"){
                        $sql->where('posting_date' ,">=", $start);
                    }elseif($start== "NA" && $end !="NA"){
                        $sql->where('posting_date' ,"<", $end);
                    }
                    $sql->where('state','like', ["%" . $state. "%"]);
                }elseif($state == "no_invoice"){
                    $sql->where("state",'like' ,["%" . $state. "%"]);
                }
            }
           

    

            $data = $sql->get();
            $count = $data->count();
        
            // if ($count == 0) {
            //     // Perform a second search with uppercase values if the first search fails
            //     $sql = RawFixAssets::orderBy("assets_date", "desc");
        
          
        

            //     if ($assets != "NA") {
            //         $sql->where("assets", "like", ["%" . strtoupper($assets) . "%"]);
            //     }
            //     if ($fa != "NA") {

            //         $sql->where("fa", "like",  ["%" . strtoupper( $modifiedString_fa ) . "%"]);
            //     }
            //     if ($invoice != "NA") {
          
            //         $sql->where("invoice_no", "like"  ["%" . strtoupper( $invoice ) . "%"]);
            //     }
            //     if ($description != "NA") {
        

            //         $sql->where("description", "like",  ["%" . strtoupper( $description  ) . "%"]);
                
            //     }
            //     if ($state != "NA") {
            //         if($state != "All"){
            //             $sql->whereRaw("UPPER(state) like ?", ["%" . strtoupper($state) . "%"]);
                  
            //         }
            //     }
        
            //     $count = count($data);
            // }


                // Log the SQL query for debugging
                Log::info('SQL Query', ['sql' => $sql->toSql(), 'bindings' => $sql->getBindings()]);




            if ($count > 0) {
                return response()->json($data);
            } else {
                return response()->json( []);
            }
  
    }

    public function fa_location() {
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


    public function assets_status(){
                $data = StoredAssetsUser::select(
            DB::raw("LEFT(DATENAME(MONTH, created_at), 3) AS label"),
            DB::raw("COUNT(id) AS value")
        )
        ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("LEFT(DATENAME(MONTH, created_at), 3)"))
        ->orderBy(DB::raw("MONTH(created_at)"))
        ->whereYear('created_at', today()->year)
        ->get();
    
        return response()->json($data );
    }
   

}

