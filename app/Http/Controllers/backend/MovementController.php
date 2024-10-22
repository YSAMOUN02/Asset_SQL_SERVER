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

<<<<<<< HEAD
    public function add_transfer($page)
    {

        if($page == "1"){
            $page = 1;
        }
        $data = StoredAssets::Orderby('assets_id', 'desc')->where('last_varaint', 1);
        $data->where('status','<>',1);


        $limit = 150;
        $offset = 0;


        if($page != 0){
            $offset = ($page - 1) * $limit;
        }

        $count_post = $data->count();
        $data->select('document', 'assets1', 'assets2', 'created_at', 'assets_id', 'fa', 'invoice_no', 'item_description', 'invoice_description','status');
        $data ->limit($limit);
        $data->offset($offset);
        $datas = $data->get();

        $total_page = ceil($count_post/$limit);

        

        // return $datas;
        return view("backend.movement-select", [
            'data' => $datas,
            'page' => $page,
            'total_record' =>$count_post,
            'total_page' => $total_page
        ]);
=======
    public function add_transfer()
    {

        $data = StoredAssetsUser::Orderby('id', 'desc')
            ->select('document', 'assets1', 'assets2', 'created_at', 'id', 'fa', 'invoice_no', 'item_description', 'invoice_description')
            ->limit(100)
            ->get();


        // return $data;
        return view("backend.movement-select", ['data' => $data]);
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149
    }

    public function add_transfer_detail($id)
    {
<<<<<<< HEAD
        // $old_data = Movement::where()


=======
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149

        $asset = StoredAssets::with(['images', 'files'])
            ->where('assets_id', $id)
            ->where('last_varaint', 1)
            ->first();

<<<<<<< HEAD

        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
        $company  = QuickData::where('type', "company")->select('id', 'content')->orderby('id', 'desc')->get();


=======
                 
        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
        $company  = QuickData::where('type', "company")->select('id', 'content')->orderby('id', 'desc')->get();
      
        $given_by = User::select("name")->get();
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149

        return view("backend.add-movement", [
        'asset' => $asset,
        'department' => $department,
<<<<<<< HEAD
        'company' => $company

        ]);
    }
    public function add_transfer_submit(request $request) {

=======
        'company' => $company,
        'given_by' => $given_by
        ]);
    }
    public function add_transfer_submit(request $request) {
    
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149
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
<<<<<<< HEAD
        $new_movement->assets_id = $request->id_assets??"";
        $new_movement->assets_no = $request->assets_no??"";
        $new_movement->varaint = $request->varaint??0;
        $new_movement->save();

=======
        $new_movement->assets_no = $request->id_assets??"";
        $new_movement->varaint = $request->varaint??0;
        $new_movement->save();
          
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149
        $this->Change_log( $new_movement->id, 0, "Insert", "Movement Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
        if ($new_movement) {
            return redirect('/')->with('success', 'Added 1 Asset Movement.');
        } else {
            return redirect('/')->with('fail', 'Opp!. Something when wronge.');
        }
    }
<<<<<<< HEAD


    public function movement_list($page){
        if($page == "1"){
            $page =1;
        }
=======
    

    public function movement_list($page){

>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149

        $limit = 150;
        $count_post = movement::count();

        $total_page = ceil($count_post/$limit);
        $offset = 0;
        if($page != 0){
            $offset = ($page - 1) * $limit;
        }


<<<<<<< HEAD
        $movement = movement::orderby('id','desc')
        ->with(['assets'])
        ->where('status' , 0)
        ;
        $movement->limit($limit);
        $movement->offset($offset);
        $data = $movement->get();

        // return $data;
        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
        return view('backend.list-movement',
    [
        'movement' => $data,
        'page' => $page,
        'total_record' =>$count_post,
        'total_page' => $total_page,
        'department' =>  $department
=======
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
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149
    ]);
    }
}

<<<<<<< HEAD
// $this->Change_log($asset_user->id, 0, "Insert", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
=======
// $this->Change_log($asset_user->id, 0, "Insert", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
>>>>>>> 7e8c0a5877d164739db0cb203f83f0f2a0f09149
