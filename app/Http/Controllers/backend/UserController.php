<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Models\User_property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use App\Models\Group;
use App\Models\UserUnit;

class UserController extends Controller
{
    public function list_user($page)
    {
        $viewpoint = User_property::where('user_id', Auth::user()->id)->where('type', 'viewpoint')->first();
        $limit = $viewpoint->value ?? 50;



        $count_post = User::count();
        $total_page = ceil($count_post / $limit);
        $offset = 0;
        if ($page != 0) {
            $offset = ($page - 1) * $limit;
        }


        $user = User::with(['Company', 'Department', 'Division', 'Section', 'Group'])
            ->limit($limit)
            ->offset($offset)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.list-user', [
            'user' => $user,
            'total_page' => $total_page,
            'page' => $page,
            'total_record' => $count_post,
            'total_page' => $total_page,
            'limit' =>  $limit
        ]);
    }

    public function add_user()
    {
        if (Auth::user()->permission->user_write != 1) {
            $this->permission_alert(
                'User Write.'
            );
        }

        $companies = Company::all();
        return view('backend.add-user', compact('companies'));
    }


    public function add_submit(Request $request)
    {
        // 1️⃣ Create new user
        $user = new User();
        $user->role      = $request->role;
        $user->name      = $request->login_name;
        $user->email     = $request->email;
        $user->fname     = $request->fname;
        $user->lname     = $request->lname;
        $user->phone     = $request->phone;
        $user->id_card   = $request->id_card;
        $user->position  = $request->position;
        $user->password  = Hash::make($request->password);
        $user->save();

        // 2️⃣ Log user fields individually
        $userColumns = ['role', 'name', 'email', 'fname', 'lname', 'phone', 'company', 'department'];
        foreach ($userColumns as $col) {
            $oldValue = null; // new record
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

        // 3️⃣ Attach permissions (single row)
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
        $permission->user_id = $user->id;

        foreach ($permissions as $perm) {
            $permission->$perm = $request->has($perm) ? 1 : 0;
        }
        $permission->save();

        // 3️⃣b Log each permission individually
        foreach ($permissions as $perm) {
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

        // 4️⃣ Create default user properties
        User_property::insert([
            ['user_id' => $user->id, 'type' => 'viewpoint', 'value' => 50],
            ['user_id' => $user->id, 'type' => 'minimize', 'value' => 1],
        ]);

        // 5️⃣ Add user unit
        $userUnit = new UserUnit();
        $userUnit->user_id       = $user->id;
        $userUnit->company_id    = $request->company_id;
        $userUnit->department_id = $request->department_id;
        $userUnit->division_id   = $request->division_id;
        $userUnit->section_id    = $request->section_id;
        $userUnit->group_id      = $request->group_id;
        $userUnit->save();

        return redirect('/admin/user/list')->with('success', 'Added 1 user, logged all fields, and saved user unit.');
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
        $user = User::with(['Permission', 'Company', 'Department', 'Division', 'Section', 'Group'])

            ->where('id', $id)
            ->first();
        // return $user;
        $companies = Company::all();

        return view('backend.user-update', [
            'user' => $user,
            'edit_able' => $edit_able,
            'companies' => $companies
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

        $user = User::with(['Permission'])

            ->where('id', $id)
            ->first();

        $companies = Company::all();


        return view('backend.user-update', [
            'user' => $user,
            'edit_able' => 0,
            'companies' => $companies
        ]);
    }

    public function getChildUnits($type, $parent_id)
    {
        $parent_id = (int) $parent_id; // cast to integer

        switch ($type) {
            case 'department':
                $units = Department::where('company_id', $parent_id)->orderBy('name')->get(['id', 'name']);
                break;

            case 'division':
                $units = Division::where('department_id', $parent_id)->orderBy('name')->get(['id', 'name']);
                break;

            case 'section':
                $units = Section::where('division_id', $parent_id)->orderBy('name')->get(['id', 'name']);
                break;

            case 'group':
                $units = Group::where('section_id', $parent_id)->orderBy('name')->get(['id', 'name']);
                break;

            default:
                $units = collect(); // empty collection if type is wrong
                break;
        }

        return response()->json($units);
    }
    public function search(Request $request)
    {
        $query = User::with(['Company', 'Department']);

        if ($request->filled('company')) {
            $query->whereHas('Company', fn($q) => $q->where('code', 'like', "%{$request->company}%"));
        }

        if ($request->filled('department')) {
            $query->whereHas('Department', fn($q) => $q->where('name', 'like', "%{$request->department}%"));
        }

        if ($request->filled('name')) {
            $query->whereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%{$request->name}%"]);
        }

        if ($request->filled('id')) {
            $query->where('id_card', 'like', "%{$request->id}%");
        }

        return response()->json($query->limit(50)->get());
    }
}
