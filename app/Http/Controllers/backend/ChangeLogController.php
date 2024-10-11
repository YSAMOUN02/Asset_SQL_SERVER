<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChangeLogController extends Controller
{
    public function ChangeLog($page)
    {

    

        $limit = 150;
        $count_post = ChangeLog::count();
        // return  $count_post ;
        $total_page = ceil($count_post/$limit);
        $offet = 0;
        if($page != 0){
            $offet = ($page - 1) * $limit;
        }
       

        // Set the end date to the end of today
        $end_date = Carbon::now()->endOfDay(); // Sets the time to 23:59:59 of today
    
        // Fetch change log entries between the start and end dates
      
            $changeLog = ChangeLog::with(['users'])
            ->orderBy("id", "desc")
            ->limit($limit)
            ->offset($offet)
            ->get();
            $change_by = ChangeLog::select('change_by')->distinct()->get();


    
           
        
        // Pass the data to the view
        return view("backend.list-change-log", [
            'changeLog' => $changeLog,
            'change_by'=>$change_by,
            'total_page' => $total_page,
            'total_record' => $count_post,
            'page' => $page
        ]);
    }


}
