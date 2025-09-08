@extends('backend.master')
@section('content')
@section('header')
    (User Detail)
@endsection
<div class="border-b border-gray-200 dark:border-gray-700">
    <ul class="user_tab bg-white flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
        <li class="me-2  active_tab">

            <div
                class=" inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                <i class="fa-solid fa-user"></i> &ensp;Profile
            </div>
        </li>
        <li class="  md:mx-9  lg:mx-36 normal_tab hover:cursor-pointer" onclick="change_permission()"
            onclick="change_permission()" data-dropdown-toggle="dropdownSearch">
            <div
                class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                <i class="fa-solid fa-list-check"></i> &ensp;Permission
            </div>

        </li>

    </ul>
</div>



<form id="user_form" action="/admin/user/update/submit" method="POST">
    @csrf
    <div class="bg-white p-5 h-max grid grid-cols-2 px-2 gap-6  md:grid-cols-2">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                name</label>
            <input type="text" name="id" value="{{ $user->id }}" class="hidden">
            <input value="{{ $user->fname }}" type="text" id="first_name" name="fname"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                name</label>
            <input type="text" value="{{ $user->lname }}" id="last_name" name="lname"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                Role</label>
            <select name="role"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="" id="">
                @if (!empty($user->role))
                    <option value="{{ $user->role }}">{{ $user->role }}</option>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                @endif


            </select>
        </div>
        <div>
            <label for="user_login" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                Login</label>
            <input type="text" value="{{ $user->name }}" id="user_login" name="login_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>
            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
            <input type="text" id="company" value="{{ $user->company }}" name="company"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </div>
        <div>

            <label for="department"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
            <input type="text" list="departments_list" id="department" name="department"
                value="{{ $user->department }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

            @php
                $departments = array_unique([
                    'Accounting & Finance',
                    'Administration & HR',
                    'Management',
                    'Maintenance',
                    'Planning',
                    'Purchase',
                    'Regulatory Affairs',
                    'External Project & Special Project',
                    'Warehouse',
                    'Logistic',
                    'MIS',
                    'Consultant',
                    'Research & Development',
                    'Commercial',
                    'Production',
                    'Quality Control',
                    'Quality Assurance',
                    'Pizza Project',
                    'Kitchen Center',
                    'Export and Marketing',
                    'Quality Production',
                    'Order',
                ]);
            @endphp

            <datalist id="departments_list">
                @foreach ($departments as $department)
                    <option value="{{ $department }}"></option>
                @endforeach
            </datalist>

        </div>
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                number</label>
            <input type="tel" id="phone" name="phone" value="{{ $user->phone }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>


    </div>
    <div class=" bg-white p-3">
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                address</label>
            <input type="email" name="email" value="{{ $user->email }}" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="john.doe@company.com" />
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div class="mb-6 flex">
            <div>
                <label for="">Preview Password</label>&ensp;
                <input type="checkbox" id="show_pass" onchange="show_password()">
            </div>
            &ensp; &ensp;
            <div>
                <label for="">Active</label>&ensp;
                @if ($user->status == 0)
                    <input type="checkbox" name="status">
                @else
                    <input type="checkbox" checked name="status">
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
                            <input id="user_read" checked type="checkbox" name="user_read"
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
            <label class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Quick
                Data
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departmentInput = document.getElementById('department');
        const validDepartments = @json($departments);

        // When the input loses focus, validate
        departmentInput.addEventListener('blur', function() {
            const value = this.value.trim();
            const isValid = validDepartments.some(dep => dep.toLowerCase() === value.toLowerCase());

            if (!isValid && value !== '') {
                alert("Please select a department from the list!");
                this.value = '';
            } else if (isValid) {
                otherSearch(); // ✅ only trigger when valid
            }
        });
    });
</script>
@endsection
