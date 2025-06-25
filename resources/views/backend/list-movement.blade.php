@extends('backend.master')
@section('content')


    <div id="delete_asset_admin"
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
                <div class="mb-2 text-sm font-normal">This Record will be delete Permanent.</div>
                <form action="/admin/movement/admin/delete/submit" method="POST">
                    @csrf
                    <input type="text" name="id" id="delete_value_asset" class="hidden">
                    <div class="grid grid-cols-2 gap-2">

                        <div>

                            <button
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                                type="submit">Yes</button>
                        </div>
                        <div>
                            <button onclick="cancel_toast('delete_asset_admin')" type="button"
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="delete_asset_staff"
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
                <div class="mb-2 text-sm font-normal">This Record will be delete.</div>
                <form action="/admin/assets/staff/delete/submit" method="POST">
                    @csrf
                    <input type="text" name="id" id="delete_value_asset_staff" class="hidden">
                    <div class="grid grid-cols-2 gap-2">

                        <div>

                            <button
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                                type="submit">Yes</button>
                        </div>
                        <div>
                            <button onclick="cancel_toast('delete_asset_staff')" type="button"
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
        <div class="search-bar bg-white border-b dark:bg-gray-800 dark:border-gray-700">


            <form action="/admin/assets/add/search" method="POST">
                @csrf
                <div class="max-w-full min-h-full grid px-2 py-1 gap-1 lg:gap-2  grid-cols-3 lg:grid-cols-4 md:grid-cols-2">
                    <div>
                        <label for="id_movement"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID</label>

                        <input type="number" id="id_movement" name="assets"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="movement_no"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Movement
                            No</label>

                        <input type="text" id="movement_no" name="movement_no"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="assets" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Assets
                            Code</label>

                        <input type="text" id="assets" name="assets"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>


                    <div>
                        <label for="from_department"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">From
                            Department</label>


                        @if (!empty($department))
                            <select id="from_department" name="from_department"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>
                                @foreach ($department as $item)
                                    <option value="{{ $item->content }}">{{ $item->content }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" id="from_department" name="from_department"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="to_department" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                            Department</label>


                        @if (!empty($department))
                            <select id="to_department" name="to_department"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>
                                @foreach ($department as $item)
                                    <option value="{{ $item->content }}">{{ $item->content }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" id="to_department" name="to_department"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="from_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">From
                            Date</label>

                        <input type="date" id="from_date" name="from_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                            date</label>

                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="from_department"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Status</label>

                        <select id="status" name="status"
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="All">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>


                        </select>
                    </div>
                </div>
                <div
                    class="max-w-full items-center flex  justify-between px-2 mt-1 lg:mt-2 py-1 lg:py-2 sm:grid sm:grid-cols-1">
                    <div class="flex main_page justify-between items-center">
                        <div class="flex">
                            <select name="" onchange="otherSearch()" id="other_search"
                                class= " w-36 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1 lg:p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Other Search</option>

                                <option value="reference">Reference </option>
                                <option value="from_name">From Name</option>
                                <option value="from_company">From Company</option>
                                <option value="from_location">From Location</option>
                                <option value="given_by">Given by</option>
                                <option value="from_remark">Remark</option>
                                <option value="to_name">To Name</option>
                                <option value="to_company">To Company</option>
                                <option value="received_by">Received by</option>
                                <option value="condition">Conditions</option>
                                <option value="purpose">Purpose</option>
                                <option value="verify_by">Verify By</option>
                                <option value="authorized_by">Authorized by</option>
                                <option value="assets_id">Assets ID</option>

                            </select>
                            <input type="text" id="other_value"
                                class= " w-32  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block mx-2 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
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
                                @endif
                                <select onchange="set_page_movement_search()" id="select_page"
                                    class="flex  items-center justify-center px-1 h-8   lg:px-3 lg:h-8  md:px-1 md:h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    name="" id="">
                                    @if ($page != 1)
                                        <option value="{{ $page }}">{{ $page }}</option>
                                    @else
                                        <option value="">More</option>
                                    @endif
                                    {{-- Page Numbers in Ascending Order --}}
                                    @for ($i = 1; $i <= $total_page; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor

                                </select>
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Page
                                    :{{ $total_page }} Pages
                                    &ensp;Total Movements: {{ $total_record }} Records</span>
                            </div>

                        </div>
                        <div class="flex fix_button">

                            <button type="button" onclick="search_movement(1)" id="search_button"
                                class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </form>

        </div>
        <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">

            <table id="list_assets"
                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('id','int','movement')">
                            ID &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('created_at','date','movement')">
                            Date&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('movement_no','string','movement')">
                            Movement No &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('assets_no','string','movement')">
                            Assets &ensp; <i class="fa-solid fa-sort"></i>
                        </th>

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('reference','string','movement')">
                            Reference &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('from_department','string','movement')">
                            From Department &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('to_department','string','movement')">
                            To Department &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('from_name','string','movement')">
                            Movement From &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('to_name','string','movement')">
                            Movement To &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('status','int','movement')">
                            Status &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                            style="  position: sticky; right: 0;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="movement_body">
                    @if (!empty($movement))
                        @foreach ($movement as $item)
                            <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->id }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ \Carbon\Carbon::parse($item->movement_date)->format('M d Y') }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->movement_no }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->assets_no }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->reference }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->from_department }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->to_department }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->from_name }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->to_name }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">

                                    @if ($item->status == 0)
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Inactive
                                        </span>
                                    @elseif($item->status == 3)
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Deleted
                                        </span>
                                    @elseif($item->status == 1)
                                        <span
                                            class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>
                                    @endif

                                </td>

                                <td class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                    <div class="option">
                                        <button id="dropdownMenuIconHorizontalButton{{ $item->id }}"
                                            data-dropdown-toggle="dropdownDotsHorizontal{{ $item->id }}"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                           <i class="fa-solid fa-gear"></i>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div id="dropdownDotsHorizontal{{ $item->id }}"
                                            class="option_dark hidden  bg-white border-b dark:bg-gray-800 dark:border-gray-700   rounded-lg shadow-sm w-44 ">

                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                @if ($item->status == 1)
                                                    @if (Auth::user()->permission->transfer_update == 1 )
                                                        <li>
                                                            <a href="/admin/movement/add/detail/id={{ $item->assets_id }}"
                                                                class="block px-4 py-2 hover:bg-gray-900 dark:hover:bg-gray-100 dark:hover:text-white">Update</a>
                                                        </li>
                                                    @endif
                                                    @if (Auth::user()->Permission->transfer_delete == 1)
                                                        <li
                                                        type="button" data-id="{{ $item->id }}"
                                                        id="btn_delete_asset{{ $item->id }}"
                                                        onclick="delete_value('btn_delete_asset'+{{ $item->id }},'delete_asset_admin','delete_value_asset')">

                                                                <div class="cursor block px-4 py-2 hover:bg-gray-900 dark:hover:bg-gray-100 dark:hover:text-white">Delete</div>

                                                        </li>
                                                    @endif
                                                @elseif($item->status == 0)
                                                        <li>
                                                            <a href="/admin/movement/view/id={{ $item->id }}/assets_id={{ $item->assets_id }}/varaint={{ $item->varaint }}"
                                                                class="block px-4 py-2 hover:bg-gray-900 dark:hover:bg-gray-100 dark:hover:text-white">View</a>
                                                        </li>
                                                @endif
                                            </ul>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif



                </tbody>
            </table>

        </div>
    </div>

    <script>
        let array = @json($movement);


        let sort_state = 0;



        const button = document.querySelector('#search_button');

        // id="search_button"
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                button.click();
            }
        });
    </script>
@endsection
