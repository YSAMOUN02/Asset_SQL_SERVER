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


            <form id="form_search" action="/admin/assets/add/search" method="POST">
                @csrf
                <div class="max-w-full min-h-full grid  px-2 py-1 gap-2 grid-cols-3 lg:grid-cols-4 md:grid-cols-2">
                    <div>
                        <label for="id_asset"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID</label>

                        <input type="number" id="id_asset" name="assets"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="assets" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Assets
                            Code</label>

                        <input type="text" id="assets" name="assets"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="fa" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">FIX
                            Asset</label>

                        <input type="text" id="fa" name="fa"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="invoice"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Invoice</label>

                        <input type="text" id="invoice" name="invoice"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="description"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Description</label>

                        <input type="text" id="description" name="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start
                            from date</label>

                        <input type="date" id="start_date" name="start_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                            date</label>

                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>



                    <div>
                        <label for="state"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        <select id="state" name="state"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="All">All</option>
                            <option value="0">Available</option>
                            <option value="2">Sold</option>

                        </select>
                    </div>
                </div>
                <div class="flex justify-between px-2">
                    <div class="flex items-center">
                        <select name="" onchange="otherSearch()" id="other_search"
                            class= " w-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <div class="max-w-full flex  px-5 ">
                            <div class="max-w-full flex justify-between ">
                                {{-- Override when search  --}}
                                <div class="pagination_by_search defualt item-center flex ">
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
                                                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                                                                class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ $i }}"
                                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                                                        </li>
                                                    @endif
                                                @endfor

                                                {{-- Next Button --}}
                                                @if ($page != $total_page)
                                                    <li>
                                                        <a href="{{ $page + 1 }}"
                                                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                            <i class="fa-solid fa-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </nav>
                                    @endif
                                    <select onchange="set_page()" id="select_page"
                                        class="flex mx-2 items-center justify-center px-3 h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
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
                                </div>

                            </div>





                        </div>


                    </div>
                    <div class="flex">
                        <button type="button" id="print" onclick="print_group()"
                            class="text-white  hidden bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Print
                        </button>

                        <button type="button" id="export_excel" onclick="export_group()"
                            class="text-white  hidden bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Export
                        </button>


                        <button type="button" onclick="search_asset_staff(0)"
                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">

            <table id="list_assets"
                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <input onchange="select_all()" type="checkbox" id="select_all"
                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('id','int','asset_staff')">
                            ID &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('created_at','date','asset_staff')">
                            Create Date&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('document','string','asset_staff')">
                            Code&ensp; <i class="fa-solid fa-sort"></i>
                        </th>

                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('assets1','string','asset_staff')">
                            Asset Code&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('fa_no','string','asset_staff')">
                            Fix Asset No&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('fa_type','string','asset_staff')">
                            Fix Asset Type&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('deleted','string','asset_staff')">

                            Status &ensp; <i class="fa-solid fa-sort"></i>
                            </td>


                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('fa_class','string','asset_staff')">
                            Fix Asset class&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3"
                            onclick="dynamic_sort('fa_subclass','string','asset_staff')">
                            Fix Asset Subclass&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3"
                            onclick="dynamic_sort('depreciation','string','asset_staff')">
                            Deoreciation Code&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('dr','string','asset_staff')">
                            DR&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('pr','string','asset_staff')">
                            PR&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('invoice_no','string','asset_staff')">
                            Invoice No&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3"
                            onclick="dynamic_sort('description','string','asset_staff')">
                            Description&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="last_td px-6 py-3"
                            style="  position: sticky; right: 0;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="asset_staff_body">
                    @if (!empty($asset))
                        @foreach ($asset as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    <input onchange="printable()" data-id="{{ $item->id }}" id="green-checkbox"
                                        type="checkbox" value=""
                                        class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">

                                    {{ $item->id }}

                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}

                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->document }}
                                </td>

                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->assets1 . $item->assets2 }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->fa }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    {{ $item->fa_type }}
                                </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                    @if ($item->deleted == 0)
                                        <span
                                            class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Available
                                        </span>
                                    @elseif($item->deleted == 1)
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Deleted
                                        </span>
                                    @elseif($item->deleted == 2)
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
                                <td  class="last_td px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   dark:bg-slate-900"
                                    style="  position: sticky; right: 0; ">
                                    @if (Auth::user()->Permission->assets_read == 1 && Auth::user()->Permission->assets_update == 0)
                                        <button type="button"
                                            class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                        </button>
                                    @endif

                                    @if (Auth::user()->Permission->assets_update == 1)
                                        <a href="/admin/assets/edit/id={{ $item->id }}">
                                            <button type="button"
                                                class="text-white  scale-50 lg:scale-100 bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                    class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if (Auth::user()->Permission->assets_delete == 1)
                                        {{-- BTN Delete  --}}

                                        <button type="button" data-id="{{ $item->id }}"
                                            id="btn_delete_asset_for_staff{{ $item->id }}"
                                            onclick="delete_value('btn_delete_asset_for_staff'+{{ $item->id }},'delete_asset_staff','delete_value_asset_staff')"
                                            class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                    @endif
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
    </script>
@endsection
