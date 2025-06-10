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

    public function add_transfer($page)
    {

        if(Auth::user()->permission->transfer_write == 1){
        if($page == "1"){
            $page = 1;
        }
        $data = StoredAssets::Orderby('assets_id', 'desc')->where('last_varaint', 1);

        if(Auth::user()->role == 'admin'){
            // $data->where('status',0);
        }elseif(Auth::user()->role == 'staff'){
            $data->where('status','<>',1);
        }



        $limit = 150;
        $offset = 0;


        if($page != 0){
            $offset = ($page - 1) * $limit;
        }

        $count_post = $data->count();
        $data->select('document', 'assets1', 'assets2', 'created_at', 'assets_id', 'fa', 'invoice_no', 'item_description', 'invoice_description','status','total_movement');
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
    }else{
            return redirect('/')->with('fail','You do not have permission Movement Write.');
        }
    }

    public function add_transfer_detail($id)
    {



        $new = 0;

        $asset = StoredAssets::with(['images', 'files'])
            ->where('assets_id', $id)
            ->where('last_varaint', 1)
            ->first();
        $old_reference = '';
        $old_reference = $asset->document;
        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
        $company  = QuickData::where('type', "company")->select('id', 'content')->orderby('id', 'desc')->get();


        $old_data_qty = Movement::where('assets_id',$id)->count();
        $old_movement = 'N/A';

        $old_user = '';
        $old_company = '';
        $old_department = '';
        $old_location = '';
        if($old_data_qty > 0){
            $new = 1;
            $count_movement_ = Movement::where('assets_id',$id)->orderby('id','desc')->where('status','<>',3)->count();

            if($count_movement_ > 0){
                $old_movement_data = Movement::where('assets_id',$id)->orderby('id','desc')->where('status','<>',3)->first();
                $old_movement = $old_movement_data->movement_no;
                $old_company =  $old_movement_data->to_company;
                $old_user =  $old_movement_data->to_name;
                $old_department = $old_movement_data->to_department;
                $old_location = $old_movement_data->to_location;
            }else{
            $old_movement = 'N/A';
            $old_reference = $asset->document;
            $old_company = $asset->company;
            $old_user = $asset->holder_name;
            $old_department = $asset->department;
            $old_location = $asset->location;
            }


        }else{
            $old_movement = 'N/A';
            $old_reference = $asset->document;
            $old_company = $asset->company;
            $old_user = $asset->holder_name;
            $old_department = $asset->department;
            $old_location = $asset->location;
        }

        return view("backend.add-movement", [
        'asset' => $asset,
        'department' => $department,
        'company' => $company,
        'old_movement' => $old_movement,
        'old_reference'=>$old_reference ,
        'old_user' => $old_user,
        'old_company' => $old_company,
        'old_department' => $old_department,
        'old_location'=> $old_location,
        'new' => $new
        ]);
    }

    public function add_transfer_submit(request $request) {
        if(Auth::user()->permission->transfer_write == 1){
            // Check if already have movment
            if($request->new == 1){
                $old_movement = movement::where('assets_id',$request->id_assets)->where('status','<>',3)->orderby('id','desc')->first();
                 if($old_movement){
                    $old_movement->status = 0;
                    $old_movement->save();
                 }
                }
                $aset =  StoredAssets::where('assets_id',$request->id_assets)->where('last_varaint',1)->first();
                $aset->total_movement += 1;
                $aset->save();


                $new_movement = new movement();
                $new_movement->movement_no =   $request->movement_no;
                $new_movement->movement_date =  $request->movement_date ? Carbon::parse( $request->movement_date)->format('Y-m-d H:i:s') : null;
                $new_movement->reference =  $request->reference??'';
                $new_movement->from_name = $request->from_name??'';
                $new_movement->from_company = $request->from_company??'';
                $new_movement->from_department =  $request->from_department??'';
                $new_movement->from_location = $request->from_location??'';
                $new_movement->given_by = $request->given_by??'';
                $new_movement->from_remark = $request->from_remark??'';
                $new_movement->to_name = $request->to_name??'';
                $new_movement->to_company = $request->to_company??'';
                $new_movement->to_department = $request->to_department??'';
                $new_movement->to_location = $request->to_location??'';
                $new_movement->received_by = $request->received_by??'';
                $new_movement->received_date = $request->received_date ? Carbon::parse($request->received_date)->format('Y-m-d H:i:s') : null;
                $new_movement->condition = $request->condition??'';
                $new_movement->purpose = $request->purpose??'';
                $new_movement-> verify_by = $request->verify_by??'';
                $new_movement->authorized_by = $request->authorized_by??'';
                $new_movement->assets_id = $request->id_assets??"";
                $new_movement->assets_no = $request->assets_no??"";
                $new_movement->varaint = $request->varaint??0;
                $new_movement->save();

                $this->Change_log( $new_movement->id,'', "Insert", "Movement Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
                if ($new_movement) {
                    return redirect('/admin/movement/list/1')->with('success', 'Added 1 Asset Movement.');
                } else {
                    return redirect('/admin/movement/list/1')->with('fail', 'Opp!. Something when wronge.');
                }




        }
        else{
            return redirect('/')->with('fail','You do not have permission Movement Write.');
        }
    }


    public function movement_list($page){



        if(Auth::user()->permission->transfer_read == 1){
            if($page == "1"){
                $page =1;
            }

            $limit = 150;
            $count_post = movement::count();

            $total_page = ceil($count_post/$limit);
            $offset = 0;
            if($page != 0){
                $offset = ($page - 1) * $limit;
            }



            $movement = movement::orderby('id','desc');
            // ->with(['assets'])


            $movement->limit($limit);
            $movement->offset($offset);

            if(auth::user()->role == 'staff'){
                $movement->where('status','<>',3);
            }
            $data = $movement->get();

            $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();


            return view('backend.list-movement',
        [
            'movement' => $data,
            'page' => $page,
            'total_record' =>$count_post,
            'total_page' => $total_page,
            'department' =>  $department
        ]);
        }else{
            return redirect('/')->with('fail','You do not have permission Movement Read.');
        }


    }

    public function update_movement_detail($id,$assets_id,$assets_varaint){
        if(Auth::user()->permission->transfer_update == 1){

            $movement = movement::where('id',$id)->first();

            $asset = StoredAssets::where('assets_id',$assets_id)->where('varaint',$assets_varaint)->first();
            $update_able = 1;
            $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
            return view('backend.update-movement',[
                'department' => $department,
                'movement' => $movement,
                'asset'=>$asset,
                'update_able' => $update_able
            ]);
        }else{
            return redirect('/')->with('fail','You do not have permission Movement Update.');
        }
    }

    public function view_movement_detail($id,$assets_id,$assets_varaint){

        if(Auth::user()->permission->transfer_read == 1){
            $movement = movement::where('id',$id)->first();
            $asset = StoredAssets::where('assets_id',$assets_id)->where('varaint',$assets_varaint)->first();
            $update_able = 0;

            $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();
            return view('backend.update-movement',[
                'department' => $department,
                'movement' => $movement,
                'asset'=>$asset,
                'update_able' => $update_able
            ]);
        }else{
            return redirect('/')->with('fail','You do not have permission Movement Read.');
        }

}
    public function delete_movement_detail(request $request) {

        if(Auth::user()->permission->transfer_delete == 1){

            if(Auth::user()->role == 'admin'){
                $deleted =  movement::where('id',$request->id)->first();

                if( $deleted){
                   $old_movement =  movement::where('assets_id',$deleted->assets_id)->where('id','<>', $deleted->id)->orderby('id','desc')->first();

                   $old_movement->status = 1;
                   $old_movement->save();

                }
                $deleted_id = $deleted->id;
                $deleted->delete();
                if($deleted){

                    $this->Change_log($deleted_id, '', "Delete Permanent", "Movement Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
                    return redirect('/admin/movement/list/1')->with('success','Deleted 1 Movement Record.');
                }else{
                    return redirect('/admin/movement/list/1')->with('fail','Opps!.Something Went wronge.');
                }
            }elseif(Auth::user()->role == 'staff'){
                $deleted =  movement::where('id',$request->id)->first();

                if( $deleted){
                    $old_movement =  movement::where('assets_id',$deleted->assets_id)->where('id','<>',$request->id)->where('status','<>',3)->orderby('id','desc')->first();
                    $old_movement->status = 1;
                    $old_movement->save();
                 }

                $deleted->status = 3;
                $deleted->save();
                if($deleted){

                    $this->Change_log($deleted_id, '', "Deleted", "Movement Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);

                    return redirect('/admin/movement/list/1')->with('success','Deleted 1 Movement Record.');
                }else{
                    return redirect('/admin/movement/list/1')->with('fail','Opps!.Something Went wronge.');
                }

            }

        }else{
            return redirect('/admin/movement/list/1')->with('fail','You do not have permission to delete movement Record.');
        }

    }

    public function update_movement_submit(request $request){


        if(Auth::user()->permission->transfer_update == 1){
        $movement = movement::where('id',$request->movement_id)->first();

        $movement->movement_no = $request->movement_no;
        $movement->movement_date = $request->movement_date;
        $movement->reference = $request->reference;
        $movement->from_name = $request->from_name;
        $movement->from_company = $request->from_company;
        $movement->from_department = $request->from_department;
        $movement->from_location = $request->from_location;
        $movement->given_by = $request->given_by;
        $movement->from_remark = $request->from_remark;
        $movement->to_name = $request->to_name;
        $movement->to_company = $request->to_company;
        $movement->to_department = $request->to_department;
        $movement->to_location = $request->to_location;
        $movement->received_by = $request->received_by;
        $movement->received_date = $request->received_date;
        $movement->condition = $request->condition;
        $movement->purpose = $request->purpose;
        $movement->verify_by = $request->verify_by;
        $movement->updated_at = now(); // or $request->updated_at if coming from the request
        $movement->authorized_by =$request->authorized_by;
        $movement->save();


        $this->Change_log($movement->id, '', "Update", "Movement Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);

        if($movement){
            return redirect('/admin/movement/list/1')->with('success','Updated Movement.');
        }else{
            return redirect('/admin/movement/list/1')->with('fail','Operation fail.');
        }

        }else{
            return redirect('/admin/movement/list/1')->with('fail','You do not have permission to Update movement Record.');
        }
    }

    public function movement_timeline($id){

        $asset = StoredAssets::where('assets_id',$id)
        ->with('movements')
        ->where('last_varaint', 1)
        ->get();
    return $asset;
}
}




// $this->Change_log($asset_user->id, 0, "Insert", "Asset Record", Auth::user()->fname . " " . Auth::user()->name, Auth::user()->id);
