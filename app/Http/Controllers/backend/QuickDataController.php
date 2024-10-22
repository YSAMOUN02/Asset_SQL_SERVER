<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\QuickData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuickDataController extends Controller
{
    public function control_quick_data($page){


        $limit = 150;
        // $count_post = QuickData::count();
        $count_post = 150;
        // return  $count_post ;
        $total_page = ceil($count_post/$limit);
        $offset = 0;
        if($page != 0){
            $offset = ($page - 1) * $limit;
        }

        $data = QuickData::orderby('id','desc')->limit($limit)->offset($offset)->get();
        $department = QuickData::where('type', "department")->select('id', 'content')->orderby('id', 'desc')->get();

        return view('backend.add-quick-data',[
            'data'=>$data,
            'page'=>$page,
            'total_page' => $total_page,
            'total_record' =>$count_post,
            'department' =>$department
        ]);
    }

    public function add_submit_quick_data(Request $request){


            $data = New QuickData();
            $data->content = $request->content;
            if($request->type == 'Employee'){
                $data->type = $request->type;
                $data->reference = $request->department_employee;
            }else{
                $data->type = $request->type;
            }
            $data->created_by = Auth::user()->name;
            $data->save();
            if($data){

                $this->Change_log($data->id, "", "Insert", "Quick Data Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
                return redirect("/quick/data/1")->with('success',"Added 1 Record success.");
            }else{

                return redirect("/quick/data/1")->with('fail',"Added  fail.");
            }
    }

    public function delete_quick_data(Request $request){
        $status = QuickData::where('id',$request->id)->first();

        $status->delete();


        if($status){

            $this->Change_log($status->id, "", "Delete", "Quick Data Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
            return redirect("/quick/data")->with('success',"Data delete success.");
        }else{

            return redirect("/quick/data")->with('fail',"Data delete fail.");
        }
    }
    public function update_quick_data(Request $request){

        $update = QuickData::where('id',$request->id)->first();
        $update->content = $request->content;
        if($request->reference_update != ''){
            $update->reference = $request->reference_update;
        }
        $update->type = $request->type;
        $update->save();



        if($update){

            $this->Change_log($update->id, "", "Update", "Quick Data Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
            return redirect("/quick/data/1")->with('success',"Data update success.");
        }else{

            return redirect("/quick/data/1")->with('fail',"Data update fail.");
        }
    }
}
