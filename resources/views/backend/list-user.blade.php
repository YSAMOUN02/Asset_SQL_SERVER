@extends('backend.master')
@section('content')


@section('header')
    List User Data
@endsection
@section('style')
    <span class="mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Users List</span>
    </span>
@endsection
<div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
    <div class="search-bar bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <form action="/admin/user/search" method="POST">
            @csrf
            <div class="max-w-full min-h-full grid px-2 py-1 gap-1 lg:gap-2  grid-cols-3 lg:grid-cols-6 md:grid-cols-4">
                <!-- ID -->
                <div>
                    <label for="id" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID</label>
                    <input type="number" id="id" name="id" value="{{ old('id', $request->id ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">User
                        Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $request->name ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <!-- ID Card -->
                <div>
                    <label for="id_card" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID
                        Card</label>
                    <input type="text" id="id_card" name="id_card"
                        value="{{ old('id_card', $request->id_card ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <!-- Position -->
                <div>
                    <label for="position"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Position</label>
                    <input type="text" id="position" name="position"
                        value="{{ old('position', $request->position ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="text" id="email" name="email"
                        value="{{ old('email', $request->email ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <!-- Role -->
                <div>
                    <label for="role"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                    <select id="role" name="role"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="All" {{ ($request->role ?? '') == 'All' ? 'selected' : '' }}>All</option>
                        <option value="super_admin" {{ ($request->role ?? '') == 'super_admin' ? 'selected' : '' }}>
                            Super Admin</option>
                        <option value="admin" {{ ($request->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_normal" {{ ($request->role ?? '') == 'super_normal' ? 'selected' : '' }}>
                            Super Normal</option>
                        <option value="user" {{ ($request->role ?? '') == 'user' ? 'selected' : '' }}>User Normal
                        </option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="status" name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="All" {{ ($request->status ?? '') == 'All' ? 'selected' : '' }}>All</option>
                        <option value="1" {{ ($request->status ?? '') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($request->status ?? '') == '0' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

                <!-- Company -->
                <div>
                    <label for="company"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                    <input list="companies_list" id="company" name="company_name" autocomplete="off"
                        value="{{ old('company_name', $request->company_name ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <input type="hidden" id="company_id" name="company_id"
                        value="{{ old('company_id', $request->company_id ?? '') }}">
                    <datalist id="companies_list">
                        @foreach ($companies as $item)
                            <option value="{{ $item->code }}" data-id="{{ $item->id }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Department -->
                <div>
                    <label for="department"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                    <input list="departments_list" id="department" name="department_name" autocomplete="off"
                        value="{{ old('department_name', $request->department_name ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
                dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <input type="hidden" id="department_id" name="department_id"
                        value="{{ old('department_id', $request->department_id ?? '') }}">
                    <datalist id="departments_list"></datalist>
                </div>

                <!-- Division -->
                <div>
                    <label for="division"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Division</label>
                    <input list="divisions_list" id="division" name="division_name" autocomplete="off"
                        value="{{ old('division_name', $request->division_name ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
        focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
        dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <input type="hidden" id="division_id" name="division_id"
                        value="{{ old('division_id', $request->division_id ?? '') }}">
                    <datalist id="divisions_list"></datalist>
                </div>

                <!-- Section -->
                <div>
                    <label for="section"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Section</label>
                    <input list="sections_list" id="section" name="section_name" autocomplete="off"
                        value="{{ old('section_name', $request->section_name ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
        focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
        dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <input type="hidden" id="section_id" name="section_id"
                        value="{{ old('section_id', $request->section_id ?? '') }}">
                    <datalist id="sections_list"></datalist>
                </div>

                <!-- Group -->
                <div>
                    <label for="group"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Group</label>
                    <input list="groups_list" id="group" name="group_name" autocomplete="off"
                        value="{{ old('group_name', $request->group_name ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
        focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2
        dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <input type="hidden" id="group_id" name="group_id"
                        value="{{ old('group_id', $request->group_id ?? '') }}">
                    <datalist id="groups_list"></datalist>
                </div>

            </div>
            <div
                class="max-w-full items-center flex  justify-between px-2 mt-1 lg:mt-2 py-1 lg:py-2 sm:grid sm:grid-cols-1">
                <div class="flex main_page justify-between items-center">

                    <div class="flex main_page items-center">
                        <div class="pagination_by_search defualt main_page items-center flex gap-2">
                            @if (!empty($total_page))
                                @php
                                    $left_limit = max(1, $page - 5); // Set the left boundary, but not below 1
                                    $right_limit = min($total_page, $page + 5); // Set the right boundary, but not above the total pages
                                @endphp
                                <nav aria-label="Page navigation example">
                                    <ul class="flex items-center -space-x-px h-8 text-sm">

                                        {{-- Previous Button --}}
                                        @if ($page != 1)
                                            <li>
                                                <a href="{{ $page - 1 }}"
                                                    class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <i class="fa-solid fa-angle-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Page Numbers in Ascending Order --}}
                                        @for ($i = $left_limit; $i <= $right_limit; $i++)
                                            {{-- Loop from left to right in ascending order --}}
                                            @if ($i == $page)
                                                <li>
                                                    <a href="{{ $i }}" aria-current="page"
                                                        class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ $i }}"
                                                        class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Button --}}
                                        @if ($page != $total_page)
                                            <li>
                                                <a href="{{ $page + 1 }}"
                                                    class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @endif

                                    </ul>
                                </nav>
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Page
                                    :{{ $total_page }} Pages
                                    &ensp;Total Users: {{ $total_record }} Records</span>
                            @else
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">
                                    Total Users: {{ $total_record }} Records</span>
                            @endif


                        </div>

                    </div>

                    <div class="flex fix_button">




                        <button type="submit" id="search_item"
                            class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                        </button>




                    </div>
                </div>


            </div>

        </form>




    </div>

    <div id="delete_user"
        class="toast_delete w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
        role="alert">
        <div class="flex">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900">
                <i class="fa-solid fa-trash" style="color: #000000;"></i>

                <span class="sr-only">Refresh icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">Are you sure ?</span>
                <div class="mb-2 text-sm font-normal">This user will be delete.</div>
                <form action="/admin/user/delete/submit" method="POST">
                    @csrf
                    <input type="text" name="id" id="delete_value" class="hidden">
                    <div class="grid grid-cols-2 gap-2">

                        <div>

                            <button
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                                type="submit">Yes</button>
                        </div>
                        <div>
                            <button onclick="cancel_toast('delete_user')" type="button"
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <div class="table-data mt-3  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
        <div class="scroll-container">
            <table id="table_user" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr tabindex="0" id="user_th">
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ID
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            User Name
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Company
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Department
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Division
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Section
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Group
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Email
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Role
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Nofiy
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Last Notify Date
                        </th>
                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Status
                        </th>

                        <th scope="col"
                            class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody id="user_tb">

                    @if (!empty($user))
                        @foreach ($user as $item)
                            @if (Auth::user()->id == $item->id)
                                <tr tabindex="0"
                                    class="bg-green-300 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->id }}
                                    </td>
                                    <td scope="row"
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->fname . ' ' . $item->lname }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->company->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->department->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->division->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->section->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->group->name ?? '' }}
                                    </td>

                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->email }}
                                    </td>

                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->role }}
                                    </td>
                                       <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if (!empty($item->notification) && $item->notification->status == 1)
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Yes
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-red-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-amber-900 dark:text-amber-300">
                                                <span class="w-2 h-2 me-1 bg-amber-500 rounded-full"></span>
                                                Not Yet
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      @if (!empty($item->notification->updated_at))
                                            {{ \Carbon\Carbon::parse($item->notification->updated_at)->format('d-M-Y') }}
                                        @else

                                        @endif
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($item->status == 0)
                                            <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Inactive
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Active
                                            </span>
                                        @endif

                                    </td>

                                    <td
                                        class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                        <div class="option">
                                            <button id="dropdownMenuIconHorizontalButton{{ $item->id }}"
                                                data-dropdown-toggle="dropdownDotsHorizontal{{ $item->id }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-center   bg-white text-black rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <i class="fa-solid fa-gear"></i>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsHorizontal{{ $item->id }}"
                                                class="option_dark hidden  bg-white border-b dark:bg-gray-800 dark:border-gray-700   rounded-lg shadow-sm w-44 ">

                                                <ul class="py-2 text-sm  bg-white text-black   dark:text-gray-200">
                                                    @if (Auth::user()->Permission->user_update == 1)
                                                        <li>
                                                            <a href="/admin/user/update/id={{ $item->id }}"
                                                                class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:hover:bg-gray-100 dark:hover:text-white">Update</a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="/admin/user/view/id={{ $item->id }}"
                                                            class="block px-4 py-2 hover:bg-gray-200 bg-white text-black dark:hover:bg-gray-100 dark:hover:text-white">View</a>
                                                    </li>


                                                </ul>
                                            </div>
                                    </td>

                                </tr>
                            @else
                                <tr tabindex="0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->id }}
                                    </td>
                                    <td scope="row"
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->fname . ' ' . $item->lname }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->company->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->department->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->division->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->section->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->group->name ?? '' }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->email }}
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->role }}
                                    </td>
                                      <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if (!empty($item->notification) && $item->notification->status == 1)
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Yes
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-red-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-amber-900 dark:text-amber-300">
                                                <span class="w-2 h-2 me-1 bg-amber-500 rounded-full"></span>
                                                Not Yet
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if (!empty($item->notification->updated_at))
                                            {{ \Carbon\Carbon::parse($item->notification->updated_at)->format('d-M-Y') }}
                                        @else

                                        @endif

                                    </td>
                                    <td
                                        class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($item->status == 0)
                                            <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Inactive
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class=" w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Active
                                            </span>
                                        @endif

                                    </td>
                                    <td
                                        class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                        <div class="option">
                                            <button id="dropdownMenuIconHorizontalButton{{ $item->id }}"
                                                data-dropdown-toggle="dropdownDotsHorizontal{{ $item->id }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <i class="fa-solid fa-gear"></i>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsHorizontal{{ $item->id }}"
                                                class="option_dark hidden bg-white border dark:bg-gray-800 dark:border-gray-700 rounded-lg shadow-lg min-w-[11rem]">

                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 ">
                                                    @if (Auth::user()->Permission->user_update == 1)
                                                        <li>
                                                            <a href="/admin/user/update/id={{ $item->id }}"
                                                                class="block px-4 py-2 hover:bg-gray-300 dark:hover:bg-gray-100  bg-white text-black ">
                                                                Update
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="/admin/user/view/id={{ $item->id }}"
                                                            class="block px-4 py-2 hover:bg-gray-300 dark:hover:bg-gray-100  bg-white text-black">
                                                            View
                                                        </a>
                                                    </li>

                                                    @if (Auth::user()->Permission->user_delete == 1)
                                                        <li type="button" data-id="{{ $item->id }}"
                                                            onclick="delete_value('btn_delete'+{{ $item->id }},'delete_user','delete_value')"
                                                            id="btn_delete{{ $item->id }}">
                                                            <div
                                                                class="cursor-pointer block px-4 py-2 hover:bg-gray-200  bg-white text-black ">
                                                                Delete
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (!empty($item->email))
                                                        <li>
                                                            <button type="button" data-email="{{ $item->email }}"
                                                                data-name="{{ $item->name }}"
                                                                class="notify-btn w-full text-left block px-4 py-2 bg-white text-black hover:bg-gray-200">
                                                                Notify
                                                            </button>
                                                        </li>
                                                    @endif


                                                </ul>
                                            </div>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif


                </tbody>
            </table>
            <!-- Confirm Modal -->
            <div id="notifyModal"
                class="hidden modal_z_hight_index    fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Send Notification</h2>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to Reset Password <br> Random & notify
                        <span id="notifyUserName" class="font-bold text-gray-900"></span>?
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancelNotify"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg text-gray-800">
                            Cancel
                        </button>
                        <button id="confirmNotify"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let selectedEmail = null;
            let selectedName = null;

            const modal = document.getElementById("notifyModal");
            const confirmBtn = document.getElementById("confirmNotify");
            const cancelBtn = document.getElementById("cancelNotify");
            const nameLabel = document.getElementById("notifyUserName");

            // Show modal when "Notify" is clicked
            document.querySelectorAll(".notify-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    selectedEmail = btn.getAttribute("data-email");
                    selectedName = btn.getAttribute("data-name");
                    nameLabel.textContent = selectedName || selectedEmail;
                    modal.classList.remove("hidden");
                });
            });

            // Hide modal when cancel clicked
            cancelBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
                selectedEmail = null;
            });

            // Confirm notification
            confirmBtn.addEventListener("click", async () => {
                if (!selectedEmail) return;

                confirmBtn.disabled = true;
                confirmBtn.textContent = "Sending...";

                try {
                    const response = await fetch("/api/notify-user", {
                        method: "POST",
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "application/json",
                            "Cache-Control": "no-cache",
                            Pragma: "no-cache",
                        },
                        body: JSON.stringify({
                            email: selectedEmail
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.status) {
                        showSuccessToast(result.message || "Notification sent successfully");
                    } else {
                        showErrorToast(result.message || "Failed to notify user");
                    }
                } catch (error) {
                    console.error(error);
                    showErrorToast("Something went wrong while sending notification");
                } finally {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = "Confirm";
                    modal.classList.add("hidden");
                }
            });

            // Close modal when clicking outside box
            modal.addEventListener("click", e => {
                if (e.target === modal) {
                    modal.classList.add("hidden");
                }
            });
        });

        // Update datalist dynamically
        function updateDatalist(type, parentId, datalistId, inputId, hiddenId, label) {
            if (!parentId) {
                $('#' + datalistId).empty();
                $('#' + inputId).val('');
                $('#' + hiddenId).val('');
                return;
            }

            $.get('/units/' + type + '/' + parentId, function(data) {
                console.log('Data for', type, parentId, data); // 👀 debug line

                if (!data || data.length === 0) {
                    $('#' + datalistId).empty();
                    $('#' + inputId).val('');
                    $('#' + hiddenId).val('');
                    return;
                }

                let options = '';
                $.each(data, function(i, unit) {
                    const label = unit.code || unit.name || unit.title || 'Unnamed';
                    options += `<option value="${label}" data-id="${unit.id}"></option>`;
                });

                $('#' + datalistId).html(options);
            });
        }

        // Validate input & store ID in hidden field
        function saveSelectedId(inputId, hiddenId, datalistId) {
            let input = document.getElementById(inputId);
            let datalist = document.getElementById(datalistId);
            let selectedOption = Array.from(datalist.options).find(opt => opt.value === input.value);

            if (!selectedOption) {
                $('#' + inputId).val('');
                $('#' + hiddenId).val('');
                return;
            }

            $('#' + hiddenId).val(selectedOption.dataset.id);
        }

        // Cascading events
        $('#company').on('change', function() {
            saveSelectedId('company', 'company_id', 'companies_list');
            let companyId = $('#company_id').val();
            updateDatalist('department', companyId, 'departments_list', 'department', 'department_id', 'Company');

            $('#department, #department_id, #division, #division_id, #section, #section_id, #group, #group_id').val(
                '');
        });

        $('#department').on('change', function() {
            saveSelectedId('department', 'department_id', 'departments_list');
            let departmentId = $('#department_id').val();
            updateDatalist('division', departmentId, 'divisions_list', 'division', 'division_id', 'Department');

            $('#division, #division_id, #section, #section_id, #group, #group_id').val('');
        });

        $('#division').on('change', function() {
            saveSelectedId('division', 'division_id', 'divisions_list');
            let divisionId = $('#division_id').val();
            updateDatalist('section', divisionId, 'sections_list', 'section', 'section_id', 'Division');

            $('#section, #section_id, #group, #group_id').val('');
        });

        $('#section').on('change', function() {
            saveSelectedId('section', 'section_id', 'sections_list');
            let sectionId = $('#section_id').val();
            updateDatalist('group', sectionId, 'groups_list', 'group', 'group_id', 'Section');

            $('#group, #group_id').val('');
        });

        $('#group').on('change', function() {
            saveSelectedId('group', 'group_id', 'groups_list');
        });
    </script>

@endsection
