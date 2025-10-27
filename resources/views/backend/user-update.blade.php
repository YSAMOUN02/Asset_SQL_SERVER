@extends('backend.master')
@section('content')
@section('header')
    (User Detail)
@endsection
<div class="border-b border-gray-200 dark:border-gray-700 ">
    <ul class="user_tab bg-white flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 ">
        <li class="me-2  active_tab ">

            <div
                class=" inline-flex items-center justify-center bg-white dark:bg-gray-900  p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                <i class="fa-solid fa-user"></i> &ensp;Profile
            </div>
        </li>
        <li class="  md:mx-9  lg:mx-36 normal_tab hover:cursor-pointer" onclick="change_permission()"
            onclick="change_permission()" data-dropdown-toggle="dropdownSearch">
            <div
                class="inline-flex items-center justify-center  bg-white dark:bg-gray-900 p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                <i class="fa-solid fa-list-check"></i> &ensp;Permission
            </div>

        </li>

    </ul>
</div>



<form id="user_form" action="/admin/user/update/submit" method="POST">
    @csrf
    <div class="p-8 h-max grid grid-cols-2  gap-6  md:grid-cols-2 bg-white dark:bg-gray-900 ">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                name</label>
            <input type="text" name="id" value="{{ $user->id }}" class="hidden">
            <input value="{{ $user->fname }}" type="text" id="first_name" name="fname"
                oninput="validateInputField(this,30)"
                 class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                name</label>
            <input type="text" value="{{ $user->lname }}" id="last_name" name="lname"
                oninput="validateInputField(this,50)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                Role</label>
            <select name="role"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="" id="">
                @if (!empty($user->role))
                    <option value="admin" @if ($user->role == 'dmin') selected @endif>Admin</option>
                    <option value="super_admin" @if ($user->role == 'super_admin') selected @endif>Super Admin</option>
                    <option value="super_normal" @if ($user->role == 'super_normal') selected @endif>Super Normal</option>
                    <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                @endif


            </select>
        </div>
        <div>
            <label for="user_login" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                Login</label>
            <input type="text" value="{{ $user->name }}" id="user_login" name="login_name"
                oninput="validateInputField(this,80)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>
            <label for="id_card" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Card</label>
            <input type="text" name="id_card" id="id_card" value="{{ $user->id_card }}"
                oninput="validateInputField(this,30)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="INV0001" />
        </div>
        <div>
            <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
            <input type="text" name="position" id="position" value="{{ $user->position }}"
                oninput="validateInputField(this,255)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div>
            <!-- Company -->
            <label class="text-black dark:text-white">Company</label>
            <input list="companies_list" id="company" name="company_name" autocomplete="off"
                value="{{ $user->company?->name ?? '' }}"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <input type="hidden" id="company_id" name="company_id" value="{{ $user->company?->id ?? '' }}">
            <datalist id="companies_list">
                @foreach ($companies as $company)
                    <option value="{{ $company->name }}" data-id="{{ $company->id }}"></option>
                @endforeach
            </datalist>
        </div>

        <div>
            <!-- Department -->
            <label class="text-black dark:text-white">Department</label>
            <input list="departments_list" id="department" name="department_name" autocomplete="off"
                value="{{ $user->department?->name ?? '' }}"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <input type="hidden" id="department_id" name="department_id" value="{{ $user->department?->id ?? '' }}">
            @php
                $departments = DB::table('department')
                    ->where('company_id', $user->company?->id ?? '')
                    ->get();
            @endphp
            <datalist id="departments_list">
                @foreach ($departments as $department)
                    <option value="{{ $department->name }}" data-id="{{ $department->id }}"></option>
                @endforeach
            </datalist>
        </div>

        <div>
            <!-- Division -->
            <label class="text-black dark:text-white">Division</label>
            <input list="divisions_list" id="division" name="division_name" autocomplete="off"
                value="{{ $user->division?->name ?? '' }}"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"">
            <input type="hidden" id="division_id" name="division_id" value="{{ $user->division?->id ?? '' }}">
            @php
                $divisions = DB::table('division')
                    ->where('department_id', $user->department?->id ?? '')
                    ->get();
            @endphp
            <datalist id="divisions_list">
                @foreach ($divisions as $division)
                    <option value="{{ $division->name }}" data-id="{{ $division->id }}"></option>
                @endforeach
            </datalist>
        </div>

        <div>
            <!-- Section -->
            <label class="text-black dark:text-white">Section</label>
            <input list="sections_list" id="section" name="section_name" autocomplete="off"
                value="{{ $user->section?->name ?? '' }}"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <input type="hidden" id="section_id" name="section_id" value="{{ $user->section?->id ?? '' }}">
            @php
                $sections = DB::table('section')
                    ->where('division_id', $user->division?->id ?? '')
                    ->get();
            @endphp
            <datalist id="sections_list">
                @foreach ($sections as $section)
                    <option value="{{ $section->name }}" data-id="{{ $section->id }}"></option>
                @endforeach
            </datalist>
        </div>

        <div>
            <!-- Group -->
            <label class="text-black dark:text-white">Group</label>
            <input list="groups_list" id="group" name="group_name" autocomplete="off"
                value="{{ $user->group?->name ?? '' }}"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <input type="hidden" id="group_id" name="group_id" value="{{ $user->group?->id ?? '' }}">
            @php
                $groups = DB::table('group')
                    ->where('section_id', $user->section?->id ?? '')
                    ->get();
            @endphp
            <datalist id="groups_list">
                @foreach ($groups as $group)
                    <option value="{{ $group->name }}" data-id="{{ $group->id }}"></option>
                @endforeach
            </datalist>
        </div>

        <div class="text-black dark:text-white">
            <!-- Phone -->
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                number</label>
            <input type="tel" id="phone" name="phone" value="{{ $user->phone }}"
                oninput="validateInputField(this,30)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>



    </div>
    <div class="bg-white dark:bg-gray-900   px-8 pb-4">
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                address</label>
            <input type="email" name="email" value="{{ $user->email }}" id="email"
                oninput="validateInputField(this,50)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="john.doe@company.com" />
        </div>
        <div class="mt-6">
            <label for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password" oninput="validateInputField(this,100)"
                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div class="mb-6 flex">
            <div>
                <label class="text-black dark:text-white mt-2" for="">Preview Password</label>&ensp;
                <input type="checkbox" id="show_pass" onchange="show_password()">
            </div>
            &ensp; &ensp;
            <div>
                <label class="text-black dark:text-white" for="status_user">Active</label>&ensp;
                @if ($user->status == 0)
                    <input type="checkbox" id="status_user" name="status">
                @else
                    <input type="checkbox" checked name="status" id="status_user">
                @endif

            </div>
        </div>
    </div>
    @if ($edit_able == 1)
        <div class="btn_float_right">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
    @endif


    <div class="toast_position hidden">
        <!-- Toast -->
        <div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 text-yellow-500 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        User Permission Not Set.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown menu -->
    <div id="dropdownSearch"
        class="grid grid-cols-2 md:grid-cols-2  lg:grid-cols-2 z-10 min-h-96 overflow-scroll hidden w-auto bg-white rounded-lg shadow dark:bg-gray-700">

        <div>
            <label class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300"
                for="">User Section</label>
            <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton">
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->user_read == 1)
                            <input id="user_read" checked type="checkbox" name="user_read"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="user_read" type="checkbox" name="user_read"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif
                        &ensp;<label for="user_read"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->user_write == 1)
                            <input id="user_write" checked type="checkbox" name="user_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="user_write" type="checkbox" name="user_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="user_write"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                    </div>
                </li>

                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->user_update == 1)
                            <input id="user_update" checked name="user_update" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="user_update" name="user_update" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="user_update"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->user_delete == 1)
                            <input id="user_delete" checked name="user_delete" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="user_delete" name="user_delete" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="user_delete"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                    </div>
                </li>
                <li>
                    <button type="button" class="p-2" onclick="set_permission('user')">Select All</button>

                </li>
            </ul>
        </div>
        <div>
            <label class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Assets
                Section</label>
            <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton">
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->assets_read == 1)
                            <input id="assets_read" name="assets_read" type="checkbox" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="assets_read" name="assets_read" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="assets_read"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->assets_write == 1)
                            <input id="assets_write" type="checkbox" checked name="assets_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="assets_write" type="checkbox" name="assets_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="assets_write"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->assets_update == 1)
                            <input id="assets_update" type="checkbox" checked name="assets_update"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="assets_update" type="checkbox" name="assets_update"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="assets_update"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->assets_delete == 1)
                            <input id="assets_delete" type="checkbox" checked name="assets_delete"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="assets_delete" type="checkbox" name="assets_delete"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif

                        &ensp;<label for="assets_delete"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                    </div>
                </li>
                <li>
                    <button type="button" class="p-2" onclick="set_permission('assets')">Select All</button>

                </li>
            </ul>
        </div>


        <div>
            <label class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Movement
                Section</label>
            <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton">
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->transfer_read == 1)
                            <input id="transfer_read" checked name="transfer_read" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="transfer_read" name="transfer_read" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif
                        &ensp;<label for="transfer_read"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->transfer_write == 1)
                            <input id="transfer_write" checked type="checkbox" name="transfer_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="transfer_write" type="checkbox" name="transfer_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif
                        &ensp;<label for="transfer_write"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->transfer_update == 1)
                            <input id="transfer_update" checked type="checkbox" name="transfer_update"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="transfer_update" type="checkbox" name="transfer_update"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif
                        &ensp;<label for="transfer_update"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->transfer_delete == 1)
                            <input id="transfer_delete" checked type="checkbox" name="transfer_delete"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @else
                            <input id="transfer_delete" type="checkbox" name="transfer_delete"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        @endif
                        &ensp;<label for="transfer_delete"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                    </div>
                </li>
                <li>
                    <button type="button" class="p-2" onclick="set_permission('transfer')">Select All</button>

                </li>
            </ul>
        </div>
        <div>
            <label class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Data
                Setup
                Section</label>
            <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton">
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->quick_read == 1)
                            <input id="quick_read" name="quick_read" type="checkbox" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            &ensp;<label for="quick_read"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                        @else
                            <input id="quick_read" name="quick_read" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            &ensp;<label for="quick_read"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                        @endif

                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->quick_write == 1)
                            <input id="quick_write" type="checkbox" name="quick_write" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            &ensp;<label for="quick_write"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                        @else
                            <input id="quick_write" type="checkbox" name="quick_write"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            &ensp;<label for="quick_write"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                        @endif

                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->quick_update == 1)
                            <input id="quick_update" type="checkbox" name="quick_update" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            &ensp;<label for="quick_update"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                        @else
                            <input id="quick_update" type="checkbox" name="quick_update"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            &ensp;<label for="quick_update"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                        @endif

                    </div>
                </li>
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        @if ($user->permission->quick_delete == 1)
                            <input id="quick_delete" type="checkbox" name="quick_delete" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

                            &ensp;<label for="quick_delete"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                        @else
                            <input id="quick_delete" type="checkbox" name="quick_delete"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

                            &ensp;<label for="quick_delete"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                        @endif


                    </div>
                </li>
                <li>
                    <button type="button" class="p-2" onclick="set_permission('quick')">Select All</button>

                </li>
            </ul>
        </div>
        <div>
            <ul class="h-auto px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton">
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        <input onchange="select_all_permission()" id="select_all" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        &ensp;<label
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Select
                            All</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function show_password() {
        const passInput = document.getElementById('password');
        const checkbox = document.getElementById('show_pass');

        if (checkbox.checked) {
            passInput.type = 'text'; // show password
        } else {
            passInput.type = 'password'; // hide password
        }
    }
    // Update datalist dynamically
    function updateDatalist(type, parentId, datalistId, inputId, hiddenId, label) {
        if (!parentId) {
            $('#' + datalistId).empty();
            $('#' + inputId).val('');
            $('#' + hiddenId).val('');
            toast_red.querySelector("p").textContent = `Please select a ${label} first`;
            toast_red.style.display = "block";
            return;
        }

        $.get('/units/' + type + '/' + parentId, function(data) {
            if (data.length === 0) {
                $('#' + datalistId).empty();
                $('#' + inputId).val('');
                $('#' + hiddenId).val('');
                toast_red.querySelector("p").textContent = `No ${label} found for selected parent`;
                toast_red.style.display = "block";
                return;
            }

            let options = '';
            $.each(data, function(i, unit) {
                options += `<option value="${unit.name}" data-id="${unit.id}"></option>`;
            });
            $('#' + datalistId).html(options);
            toast_red.style.display = "none";
        });
    }

    // Validate input & store ID in hidden field
    function saveSelectedId(inputId, hiddenId, datalistId, label) {
        let input = document.getElementById(inputId);
        let datalist = document.getElementById(datalistId);

        let selectedOption = Array.from(datalist.options).find(opt => opt.value === input.value);

        if (!selectedOption) {

            showToastRed(`Invalid ${label}, please select from list`);

            $('#' + inputId).val('');
            $('#' + hiddenId).val('');
            return;
        }

        $('#' + hiddenId).val(selectedOption.dataset.id);
        toast_red.style.display = "none";
    }

    // Cascading events
    $('#company').on('change', function() {
        saveSelectedId('company', 'company_id', 'companies_list', 'Company');
        let companyId = $('#company_id').val();
        updateDatalist('department', companyId, 'departments_list', 'department', 'department_id',
            'Department');

        // clear children
        $('#department, #department_id, #division, #division_id, #section, #section_id, #group, #group_id').val(
            '');
    });

    $('#department').on('change', function() {
        saveSelectedId('department', 'department_id', 'departments_list', 'Department');
        let departmentId = $('#department_id').val();
        updateDatalist('division', departmentId, 'divisions_list', 'division', 'division_id', 'Division');

        $('#division, #division_id, #section, #section_id, #group, #group_id').val('');
    });

    $('#division').on('change', function() {
        saveSelectedId('division', 'division_id', 'divisions_list', 'Division');
        let divisionId = $('#division_id').val();
        updateDatalist('section', divisionId, 'sections_list', 'section', 'section_id', 'Section');

        $('#section, #section_id, #group, #group_id').val('');
    });

    $('#section').on('change', function() {
        saveSelectedId('section', 'section_id', 'sections_list', 'Section');
        let sectionId = $('#section_id').val();
        updateDatalist('group', sectionId, 'groups_list', 'group', 'group_id', 'group');

        $('#group, #group_id').val('');
    });

    $('#group').on('change', function() {
        saveSelectedId('group', 'group_id', 'groups_list', 'Group');
    });
</script>
@endsection
