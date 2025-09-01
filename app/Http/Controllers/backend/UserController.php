<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list_user()
    {
        $user = User::orderby('id', 'desc')->get();

        return view('backend.list-user', ['user' => $user]);
    }

    public function add_user()
    {
        return view('backend.add-user');
    }

    public function add_user2()
    {
        return view('backend.add-user2');
    }

    public function add_submit(Request $request)
    {
        $user = new User();
        $user->role       = $request->role;
        $user->name       = $request->login_name;
        $user->email      = $request->email;
        $user->fname      = $request->fname;
        $user->lname      = $request->lname;
        $user->phone      = $request->phone;
        $user->company    = $request->company;
        $user->department = $request->department;
        $user->password   = Hash::make($request->password);
        $user->save();

        // ✅ Attach permissions to this user
        $permission = new Permission();
        $permission->user_id         = $user->id; // <-- important
        $permission->user_read       = $request->has('user_read') ? 1 : 0;
        $permission->user_write      = $request->has('user_write') ? 1 : 0;
        $permission->user_update     = $request->has('user_update') ? 1 : 0;
        $permission->user_delete     = $request->has('user_delete') ? 1 : 0;
        $permission->assets_read     = $request->has('assets_read') ? 1 : 0;
        $permission->assets_write    = $request->has('assets_write') ? 1 : 0;
        $permission->assets_update   = $request->has('assets_update') ? 1 : 0;
        $permission->assets_delete   = $request->has('assets_delete') ? 1 : 0;
        $permission->transfer_read   = $request->has('transfer_read') ? 1 : 0;
        $permission->transfer_write  = $request->has('transfer_write') ? 1 : 0;
        $permission->transfer_update = $request->has('transfer_update') ? 1 : 0;
        $permission->transfer_delete = $request->has('transfer_delete') ? 1 : 0;
        $permission->quick_read      = $request->has('quick_read') ? 1 : 0;
        $permission->quick_write     = $request->has('quick_write') ? 1 : 0;
        $permission->quick_update    = $request->has('quick_update') ? 1 : 0;
        $permission->quick_delete    = $request->has('quick_delete') ? 1 : 0;
        $permission->save();

        return redirect('/admin/user/list')->with('success', 'Added 1 user.');
    }

    public function delete_user(Request $request)
    {

        $auth  = Auth::user()->id;

        if ($request->id == $auth) {
            return redirect('/admin/user/list')->with('fail', 'You can not delete your user. change to another user to delete your user');
        }

        $user = User::where('id', $request->id)->first();
        $this->Change_log($user->id, "", "Delete", "User Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
        $user->delete();
        if ($user) {
            return redirect('/admin/user/list')->with('success', 'Deleted User.');
        } else {
            return redirect('/admin/user/list')->with('fail', 'Opp. Operation fail.');
        }
    }
    public function update_user($id)
    {



        $edit_able = 1;
        $user = User::with(['Permission'])

            ->where('id', $id)
            ->first();

        // return $user;
        return view('backend.user-update', [
            'user' => $user,
            'edit_able' => $edit_able
        ]);
    }

    public function update_user_submit(Request $request)
    {
        if (!empty(Auth::user())) {
            if (!empty($request->user_read)) {
                $user_read  = 1;
            } else {
                $user_read  = 0;
            }
            if (!empty($request->user_write)) {
                $user_write  = 1;
            } else {
                $user_write  = 0;
            }
            if (!empty($request->user_delete)) {
                $user_delete  = 1;
            } else {
                $user_delete  = 0;
            }
            if (!empty($request->user_update)) {
                $user_update  = 1;
            } else {
                $user_update  = 0;
            }
            if (!empty($request->assets_read)) {
                $assets_read  = 1;
            } else {
                $assets_read  = 0;
            }
            if (!empty($request->assets_write)) {
                $assets_write  = 1;
            } else {
                $assets_write  = 0;
            }
            if (!empty($request->assets_delete)) {
                $assets_delete  = 1;
            } else {
                $assets_delete  = 0;
            }
            if (!empty($request->assets_update)) {
                $assets_update  = 1;
            } else {
                $assets_update  = 0;
            }
            if (!empty($request->transfer_read)) {
                $transfer_read  = 1;
            } else {
                $transfer_read  = 0;
            }
            if (!empty($request->transfer_write)) {
                $transfer_write  = 1;
            } else {
                $transfer_write  = 0;
            }
            if (!empty($request->transfer_delete)) {
                $transfer_delete  = 1;
            } else {
                $transfer_delete  = 0;
            }
            if (!empty($request->transfer_update)) {
                $transfer_update  = 1;
            } else {
                $transfer_update   = 0;
            }
            if (!empty($request->status)) {
                $status = 1;
            } else {
                $status = 0;
            }

            if (!empty($request->quick_read)) {
                $quick_read  = 1;
            } else {
                $quick_read  = 0;
            }
            if (!empty($request->quick_write)) {
                $quick_write  = 1;
            } else {
                $quick_write  = 0;
            }
            if (!empty($request->quick_delete)) {
                $quick_delete  = 1;
            } else {
                $quick_delete  = 0;
            }
            if (!empty($request->quick_update)) {
                $quick_update  = 1;
            } else {
                $quick_update  = 0;
            }


            $user = User::where('id', $request->id)->first();

            $user->name = $request->login_name;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->phone = $request->phone;
            $user->company = $request->company;
            $user->department = $request->department;
            $user->status = $status;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $permission = $user->permission;
            $permission->user_read = $user_read;
            $permission->user_write = $user_write;
            $permission->user_update = $user_update;
            $permission->user_delete = $user_delete;
            $permission->assets_read = $assets_read;
            $permission->assets_write = $assets_write;
            $permission->assets_update = $assets_update;
            $permission->assets_delete = $assets_delete;


            $permission->transfer_read = $transfer_read;
            $permission->transfer_write = $transfer_write;
            $permission->transfer_update = $transfer_update;
            $permission->transfer_delete = $transfer_delete;


            $permission->quick_read = $quick_read;
            $permission->quick_write = $quick_write;
            $permission->quick_update = $quick_update;
            $permission->quick_delete = $quick_delete;
            $permission->update();


            $this->Change_log($user->id, "", "Update", "User Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
            return redirect('/admin/user/list')->with('success', 'Update success.');
        } else {
            return redirect('/')->with('fail', 'You are unauthorized.');
        }
    }


    public function view_user($id)
    {

        $edit_able = 0;
        $user = User::with(['Permission'])

            ->where('id', $id)
            ->first();

        // return $user;
        return view('backend.user-update', [
            'user' => $user,
            'edit_able' => $edit_able
        ]);
    }
}
