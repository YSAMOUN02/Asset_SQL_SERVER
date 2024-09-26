<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Fix_assets;
use App\Models\StoredAssets;
use App\Models\StoredAssetsUser;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function dashboard_admin(){
        // $data = StoredAssetsUser::select("fa_type")->distinct()->get();
        
        // $arr = [];
        // foreach ($data as $item) {
        //     $count = StoredAssetsUser::where("fa_type", $item->fa_type)->count();
            
        //     if ($count) {
        //         // Push both the type and its count into the array
        //         array_push($arr, ['label' => $item->fa_type, 'value' => $count]);
          
        //     }
        // }
        // return $arr;
        // // Return the array as a JSON response
        // return ($data) ;
        // // return $arr;
         
        return view('backend.dashboard');
    }
    public function login(){
        return view('backend.login');
    }
    public function login_submit(Request $request){
        
        $name_email = $request->input('name_email');
        $password = $request->password;
        $remember = $request->remember;
        
        if(Auth::attempt(['name' => $name_email, 'password' => $password],$remember)){
                if(Auth::user()->status == 0){
                    Auth::logout();
    
                        return redirect("/login")->with('fail','Your user has been disable from System.');
             
                }
            return view('backend.dashboard')->with('sucess','Login Success.');
        }
        elseif(Auth::attempt(['email' => $name_email , 'password' => $password],$remember)){
            if(Auth::user()->status == 0){
                Auth::logout();

                    return redirect("/login")->with('fail','Your user has been disable from System.');
         
            }
            return view('backend.dashboard')->with('sucess','Login Success.');
        }else{  
           
            return redirect('/login')->with('fail','Invalid Credential');
        }

    }
    public function logout(){
        $auth = Auth::logout();

        if($auth){
            return redirect("/login")->with('success','Logout Suceess.');
        }else{
            return redirect("/")->with('fail','Logout Suceess.');
        }
    }
}
