<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

use App\Models\Company;
use App\Models\Location;
use App\Models\Department;
use App\Models\User_property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuickDataController extends Controller
{
    public function control_quick_data($page)
    {
           $viewpoint = User_property::where('user_id',Auth::user()->id)->where('type','viewpoint')->first();
        $limit = $viewpoint->value ?? 50;

        $count_post = Company::count();
        $total_page = ceil($count_post / $limit);

        $offset = ($page != 0) ? ($page - 1) * $limit : 0;

        // Apply limit and offset before get()
$datas = Company::with('departments')

    ->offset($offset)
    ->limit($limit)
    ->get();

            // return $datas;
        return view('backend.add-quick-data', [
            'data' => $datas,
            'page' => $page,
            'total_page' => $total_page,
            'total_record' => $count_post,
            // 'department' => $department
        ]);
    }

    public function add_submit_quick_data(Request $request){


            $data = New Company();
            $data->name = $request->content;
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
