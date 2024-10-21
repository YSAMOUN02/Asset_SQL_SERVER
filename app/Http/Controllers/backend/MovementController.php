<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\movement;
use App\Models\QuickData;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{

    public function add_transfer()
    {

        $data = StoredAssetsUser::Orderby('id', 'desc')
            ->select('document', 'assets1', 'assets2', 'created_at', 'id', 'fa', 'invoice_no', 'item_description', 'invoice_description')
            ->limit(100)
            ->get();


        // return $data;
        return view("backend.movement-select", ['data' => $data]);
    }

    public function add_transfer_detail($id)
    {

        $asset = StoredAssets::with(['images', 'files'])
            ->where('assets_id', $id)
            ->where('last_varaint', 1)
            ->first();

                 
        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
        $company  = QuickData::where('type', "company")->select('id', 'content')->orderby('id', 'desc')->get();
      
        $given_by = User::select("name")->get();

        return view("backend.add-movement", [
        'asset' => $asset,
        'department' => $department,
        'company' => $company,
        'given_by' => $given_by
        ]);
    }
    public function add_transfer_submit(request $request) {
    
        $new_movement = new movement();
        $new_movement->movement_no =   $request->movement_no;
        $new_movement->movement_date =  $request->movement_date ? Carbon::parse( $request->movement_date)->format('Y-m-d H:i:s') : null;
        $new_movement->reference =  $request->reference??'';
        $new_movement->from_name = $request->from_name??'';
        $new_movement->from_department =  $request->from_department??'';
        $new_movement->from_location = $request->from_location??'';
        $new_movement->given_by = $request->given_by??'';
        $new_movement->from_remark = $request->from_remark??'';
        $new_movement->to_name = $request->to_name??'';
        $new_movement->to_department = $request->to_department??'';
        $new_movement->to_location = $request->to_location??'';
        $new_movement->received_by = $request->received_by??'';
        $new_movement->received_date = $request->received_date ? Carbon::parse($request->received_date)->format('Y-m-d H:i:s') : null;
        $new_movement->condition = $request->condition??'';
        $new_movement->purpose = $request->purpose??'';
        $new_movement-> verify_by = $request->verify_by??'';
        $new_movement->authorized_by = $request->authorized_by??'';
        $new_movement->assets_no = $request->id_assets??"";
        $new_movement->varaint = $request->varaint??0;
        $new_movement->save();
          
        $this->Change_log( $new_movement->id, 0, "Insert", "Movement Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
        if ($new_movement) {
            return redirect('/')->with('success', 'Added 1 Asset Movement.');
        } else {
            return redirect('/')->with('fail', 'Opp!. Something when wronge.');
        }
    }
    

    public function movement_list($page){


        $limit = 150;
        $count_post = movement::count();

        $total_page = ceil($count_post/$limit);
        $offset = 0;
        if($page != 0){
            $offset = ($page - 1) * $limit;
        }


        $movement = movement::orderby('id','desc')->with(['assets']);
        $movement->limit($limit);
        $movement->offset($offset);
        $data = $movement->get();
   
        return view('backend.list-movement',
    [
        'movement' => $data,
        'total_page' => $total_page,
        'page' => $page,
        'total_record' =>$count_post,
        'total_page' => $total_page
    ]);
    }
}

// $this->Change_log($asset_user->id, 0, "Insert", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);