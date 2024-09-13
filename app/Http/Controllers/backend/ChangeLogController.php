<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use Illuminate\Http\Request;

class ChangeLogController extends Controller
{
    public function ChangeLog(){
        $changeLog = ChangeLog::with(['users'])->Orderby("id","desc")->get();

  
        // return $changeLog;
        return view("backend.list-change-log",['changeLog' =>$changeLog ]);
    }

    public function ChangeLogSearch(request $request){
      
        // "varaint": "fg",
        // "change": "efgdfg",
        // "section": "user",
        // "chang_by": "user",
        // "start_date": "2024-08-20",
        // "end_date": "2024-09-03"
        $changeLog = ChangeLog::with(['users']);
        
        if(!empty($request->varaint)){
            $changeLog->where("varaint","LIKE","%".$request->varaint."%");
        }
     
        if(!empty($request->change)){
            $changeLog->where("change","LIKE","%".$request->change."%");
        }
        if(!empty($request->section)){
            $changeLog->where("section","LIKE","%".$request->section."%");
        }
        if(!empty($request->chang_by)){
            $changeLog->where("change_by","LIKE","%".$request->chang_by."%");
        }
        $changeLog->Orderby("id","desc");
        $changeLog = $changeLog->get();

        return view("backend.list-change-log",['changeLog' =>$changeLog ]);
    }
}
