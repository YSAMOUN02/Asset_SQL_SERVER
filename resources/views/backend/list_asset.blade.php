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
                <form action="/admin/assets/admin/delete/submit" method="POST">
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
                        <label for="id_asset"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID</label>

                        <input type="number" id="id_asset" name="assets"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="assets" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Assets
                            Code</label>

                        <input type="text" id="assets" name="assets"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="fa" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">FIX
                            Asset</label>

                        <input type="text" id="fa" name="fa"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="invoice"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Invoice</label>

                        <input type="text" id="invoice" name="invoice"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="description"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Description</label>

                        <input type="text" id="description" name="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start
                            (issue Date)</label>

                        <input type="date" id="start_date" name="start_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                            date (issue Date)</label>

                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>



                    <div>
                        <label for="state"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        <select id="state" name="state"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="All">All</option>
                            <option value="0">Active</option>
                            <option value="2">Sold</option>
                            @if (Auth::user()->role == 'admin')
                                <option value="1">Deleted</option>
                            @endif


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
                                <option value="document">Refference</option>
                                <option value="item">Item</option>
                                <option value="initial_condition">Initail Condition</option>
                                <option value="specification">Specification</option>
                                <option value="item_description">Item Description</option>
                                <option value="asset_group">Asset Group</option>
                                <option value="remark_assets">Remark Assets</option>


                                <option value="asset_holder">Assets Holder ID</option>
                                <option value="holder_name">Holder Name</option>
                                <option value="position">Position</option>
                                <option value="location">Location</option>
                                <option value="department">Department</option>
                                <option value="company">Company</option>
                                <option value="remark_holder">Remark Holder</option>


                                <option value="grn">GRN</option>
                                <option value="pr">PR</option>
                                <option value="po">PO</option>
                                <option value="dr">DR</option>
                                <option value="dr_requested_by">DR Request by</option>
                                <option value="remark_internal_doc">Remark Document</option>

                                <option value="fa_class">Fix Asset Class</option>
                                <option value="fa_subclass">Fix Asset Sub Class</option>
                                <option value="depreciation">Depreciation</option>
                                <option value="fa_type">Fix Asset Type</option>
                                <option value="fa_location">Fix Assets Location</option>
                                <option value="invoice_description">Invoice Description</option>


                                <option value="vendor">Vendor</option>
                                <option value="vendor_name">Vendor Name</option>
                                <option value="address">Address</option>
                                <option value="address2">Address 2</option>
                                <option value="contact">Contact</option>
                                <option value="phone">Phone </option>
                                <option value="email">Email</option>
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
                                <select onchange="set_page()" id="select_page"
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
                                    &ensp;Total Assets: {{ $total_assets }} Records</span>
                            </div>

                        </div>
                        <div class="flex fix_button">
                            <button type="button" id="print" onclick="print_group()"
                                class="text-white  hidden update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                Print
                            </button>

                            <button type="button" id="export_excel" onclick="export_group()"
                                class="text-white  hidden update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                Export
                            </button>



                            <button type="button" onclick="search_asset(0)" id="search_item"
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
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            <input onchange="select_all()" type="checkbox" id="select_all"
                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('assets_id','int','assets')">
                            ID &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('issue_date','date','assets')">
                            Issue Date&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('document','string','assets')">
                            Refference&ensp; <i class="fa-solid fa-sort"></i>
                        </th>

                        <th scope="col"
                            class="table_float_left_th px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-white dark:bg-gray-700 dark:border-gray-700"
                            onclick="dynamic_sort('assets1','string','assets')">
                            Asset Code&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('item','string','assets')">
                            Item&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('specification','string','assets')">
                            Specification&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('initial_condition','string','assets')">
                            Initial Condition&ensp; <i class="fa-solid fa-sort"></i>
                        </th>


                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('fa','string','assets')">
                            Fix Asset No&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('fa_type','string','assets')">
                            Fix Asset Type&ensp; <i class="fa-solid fa-sort"></i>
                        </th>

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('status','string','assets')">

                            Status &ensp; <i class="fa-solid fa-sort"></i>
                        </th>



                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('fa_class','string','assets')">
                            Fix Asset class&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('fa_subclass','string','assets')">
                            Fix Asset Subclass&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('depreciation','string','assets')">
                            Deoreciation Code&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('dr','string','assets')">
                            DR&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('pr','string','assets')">
                            PR&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('invoice_no','string','assets')">
                            Invoice No&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('description','string','assets')">
                            Description&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                            onclick="dynamic_sort('created_at','date','assets')">
                            Created Date&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                            style="  position: sticky; right: 0;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="assets_body">
                    @if (!empty($asset))
                        @foreach ($asset as $item)
                            <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    <input onchange="printable()" data-id="{{ $item->assets_id }}" id="green-checkbox"
                                        type="checkbox" value=""
                                        class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">

                                    {{ $item->assets_id }}


                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ \Carbon\Carbon::parse($item->issue_date)->format('M d Y') }}

                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->document }}
                                </td>

                                <td
                                    class="table_float_left_td  px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   bg-white dark:bg-gray-700 dark:border-gray-700">
                                    {{ $item->assets1 . $item->assets2 ?? '' }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->item }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->specification }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->initial_condition }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->fa }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->fa_type }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    @if ($item->status == 0)
                                        <span
                                            class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>
                                    @elseif($item->status == 1)
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Deleted
                                        </span>
                                    @elseif($item->status == 2)
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Sold
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->fa_class }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->fa_subclass }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->depreciation }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->dr }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->pr }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->invoice_no }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->description }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}

                                </td>
                                <td class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                    <div class="option">
                                        <button id="dropdownMenuIconHorizontalButton{{ $item->id }}"
                                            data-dropdown-toggle="dropdownDotsHorizontal{{ $item->id }}"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 16 3">
                                                <path
                                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div id="dropdownDotsHorizontal{{ $item->id }}"
                                            class=" hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">

                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton{{ $item->id }}">
                                                @if (Auth::user()->Permission->transfer_write == 1)
                                                    <li>
                                                        <a href="/admin/movement/add/detail/id={{ $item->assets_id }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Movement</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->Permission->assets_read == 1 && Auth::user()->Permission->assets_update == 0)
                                                    <li>
                                                        <a href="/admin/assets/view/id={{ $item->assets_id }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detail</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->Permission->assets_update == 1)
                                                    <li>
                                                        <a href="/admin/assets/edit/id={{ $item->assets_id }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Update</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->Permission->assets_delete == 1)
                                                    <li
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-id="{{ $item->assets_id }}"  id="btn_delete_asset{{ $item->assets_id }}"  onclick="delete_value('btn_delete_asset'+{{ $item->assets_id }},'delete_asset_admin','delete_value_asset')">

                                                        Delete

                                                    </li>
                                                @endif
                                            </ul>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    @endif



                </tbody>
            </table>

        </div>
    </div>
    <div class="hidden">
        <form id="form_print" action="/admin/qr/code/print/assets" method="post">
            @csrf
            <input type="text" name="id" id="id_printer">
            <button type="submit">submit</button>
        </form>
        <form id="form_export" action="/admin/export/excel/assets" method="post">
            @csrf
            <input type="text" name="id_export" id="id_export">
            <button type="submit">submit</button>
        </form>
    </div>
    <script>
        let array = @json($asset);


        let sort_state = 0;


        const button = document.querySelector('#search_item');

        // id="search_button"
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                button.click();
            }
        });
    </script>
@endsection
