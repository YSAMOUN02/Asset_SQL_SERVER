<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\QuickData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuickDataController extends Controller
{
    public function control_quick_data(){

        $data = QuickData::orderby('id','desc')->get();
        return view('backend.add-quick-data',['data'=>$data]);
    }

    public function add_submit_quick_data(Request $request){
        $data = New QuickData();
        $data->content = $request->content;
        $data->type = $request->type;
        $data->created_by = Auth::user()->name;
        $data->save();
        return $request;
    }

    public function delete_quick_data(Request $request){
        $deleted = QuickData::where('id',$request->id)->first();

        $deleted->delete();

        if($deleted){

            return redirect("/quick/data")->with('success',"Data delete success.");
        }else{

            return redirect("/quick/data")->with('fail',"Data delete fail.");
        }
    }
    public function update_quick_data(Request $request){

        $update = QuickData::where('id',$request->id)->first();
        $update->content = $request->content;
        $update->type = $request->type;
        $update->save();
        if($update){

            return redirect("/quick/data")->with('success',"Data update success.");
        }else{

            return redirect("/quick/data")->with('fail',"Data update fail.");
        }
    }
}
