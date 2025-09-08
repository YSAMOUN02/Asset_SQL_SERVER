<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Models\User_property;
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
        if (Auth::user()->permission->user_write != 1) {
            $this->permission_alert(
                'User Write.'
            );
        }
        return view('backend.add-user');
    }


    public function add_submit(Request $request)
    {
        // 1️⃣ Create new user
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

        // 2️⃣ Log user fields individually
        $userColumns = [
            'role',
            'name',
            'email',
            'fname',
            'lname',
            'phone',
            'company',
            'department'
        ];

        foreach ($userColumns as $col) {
            $oldValue = null; // new record, so old is null
            $newValue = $col . ': ' . $user->$col;

            $this->storeChangeLog(
                $user->id,
                $user->name,
                $oldValue,
                $newValue,
                'Inserted',
                'users',
                "Set $col"
            );
        }

        // 3️⃣ Attach permissions and log each
        $permissions = [
            'user_read',
            'user_write',
            'user_update',
            'user_delete',
            'assets_read',
            'assets_write',
            'assets_update',
            'assets_delete',
            'transfer_read',
            'transfer_write',
            'transfer_update',
            'transfer_delete',
            'quick_read',
            'quick_write',
            'quick_update',
            'quick_delete'
        ];
        $permission = new Permission();
        foreach ($permissions as $perm) {

            $permission->user_id = $user->id;
            $permission->$perm = $request->has($perm) ? 1 : 0;
            $permission->save();

            $oldValue = null;
            $newValue = $perm . ': ' . $permission->$perm;

            $this->storeChangeLog(
                $user->id,
                $user->name,
                $oldValue,
                $newValue,
                'Inserted',
                'permissions',
                "Set $perm"
            );
        }

        // New View point
        $new_viewpoint = new User_property();
        $new_viewpoint->user_id = $user->id;
        $new_viewpoint->type = 'viewpoint';
        $new_viewpoint->value = 50;
        $new_viewpoint->save();






        return redirect('/admin/user/list')->with('success', 'Added 1 user and logged all fields.');
    }


    public function delete_user(Request $request)
    {

        $auth  = Auth::user()->id;

        if ($request->id == $auth) {
            return redirect('/admin/user/list')->with('fail', 'You can not delete your user. change to another user to delete your user');
        }

        $user = User::where('id', $request->id)->first();
        // $this->Change_log($user->id, "", "Delete", "User Record", Auth::user()->fname . " " . Auth::user()->lname, Auth::user()->id);
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


        return view('backend.user-update', [
            'user' => $user,
            'edit_able' => $edit_able
        ]);
    }

    public function update_user_submit(Request $request)
    {
        // 🔐 Authorization check
        if (empty(Auth::user())) {
            return redirect('/')->with('fail', 'You are unauthorized.');
        }
        if (Auth::user()->permission->user_update != 1) {
            return redirect('/')->with('fail', 'You are unauthorized.');
        }

        // 🔎 Find user
        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->with('fail', 'User not found.');
        }

        // Collect old values for logging
        $oldUserValues = $user->only([
            'name',
            'role',
            'email',
            'fname',
            'lname',
            'phone',
            'company',
            'department',
            'status'
        ]);

        $oldPermissionValues = $user->permission->only([
            'user_read',
            'user_write',
            'user_update',
            'user_delete',
            'assets_read',
            'assets_write',
            'assets_update',
            'assets_delete',
            'transfer_read',
            'transfer_write',
            'transfer_update',
            'transfer_delete',
            'quick_read',
            'quick_write',
            'quick_update',
            'quick_delete'
        ]);

        // ✅ Update user info
        $user->name       = $request->login_name;
        $user->role       = $request->role;
        $user->email      = $request->email;
        $user->fname      = $request->fname;
        $user->lname      = $request->lname;
        $user->phone      = $request->phone;
        $user->company    = $request->company;
        $user->department = $request->department;
        $user->status     = $request->has('status') ? 1 : 0;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // ✅ Update permissions
        $permission = $user->permission;
        $permissionFields = [
            'user_read',
            'user_write',
            'user_update',
            'user_delete',
            'assets_read',
            'assets_write',
            'assets_update',
            'assets_delete',
            'transfer_read',
            'transfer_write',
            'transfer_update',
            'transfer_delete',
            'quick_read',
            'quick_write',
            'quick_update',
            'quick_delete'
        ];

        foreach ($permissionFields as $field) {
            $permission->$field = $request->has($field) ? 1 : 0;
        }
        $permission->save();

        // 🔹 Log User Changes
        foreach ($oldUserValues as $col => $old) {
            $new = $user->$col;
            if ($old != $new) {
                $this->storeChangeLog(
                    $user->id,
                    $user->name,
                    "$col: $old",
                    "$col: $new",
                    'Updated',
                    'users',
                    "Field $col changed"
                );
            }
        }

        // 🔹 Log Permission Changes
        foreach ($oldPermissionValues as $col => $old) {
            $new = $permission->$col;
            if ($old != $new) {
                $this->storeChangeLog(
                    $user->id,
                    $user->name,
                    "$col: $old",
                    "$col: $new",
                    'Updated',
                    'permissions',
                    "Permission $col changed"
                );
            }
        }

        return redirect('/admin/user/list')->with('success', 'Update success.');
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
