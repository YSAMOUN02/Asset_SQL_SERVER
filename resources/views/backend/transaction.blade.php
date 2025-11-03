@extends('backend.master')
@section('content')
@section('header')
    Assets History
@endsection
@section('style')
    <span class="mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Assets History List</span>
    </span>
@endsection



<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/flatpickrdark.min.css') }}">

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
            <div class="mb-2 text-sm font-normal">This Record will be delete.</div>
            <form action="/admin/assets/admin/delete/submit" method="POST">
                @csrf
                <input type="text" name="reason" id="reason" placeholder="Reason"
                    class="m-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
            <div class="max-w-full min-h-full grid px-2 py-1 gap-1 lg:gap-2  grid-cols-2 lg:grid-cols-5 md:grid-cols-2">

                <div>
                    <label for="assets" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Assets
                        Code</label>

                    <input type="text" id="assets" name="assets"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>


                <div>
                    <label for="company" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Company
                    </label>
                    <input type="text" id="company" name="company" list="companyList" autocomplete="off"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <datalist id="companyList">
                        @foreach ($companies as $company)
                            <option value="{{ $company }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="relative " id="departmentDropdown">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Department</label>

                    <!-- Dropdown toggle -->
                    <div id="dropdownToggleDept"
                        class="border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 p-2 cursor-pointer max-h-10 overflow-hidden select-none text-black dark:text-white">
                        Departments
                    </div>

                    <!-- Dropdown menu -->
                    <div id="dropdownMenuDept"
                        class="absolute mt-1 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg hidden z-50">
                        <!-- Search box -->
                        <div class="p-2 border-b border-gray-200 dark:border-gray-600">
                            <input type="text" id="searchDept" placeholder="Search department..."
                                class="w-full p-1 text-sm border border-gray-300 dark:border-gray-600 rounded focus:outline-none focus:ring  focus:ring-blue-300 dark:bg-gray-800 dark:text-white">
                        </div>

                        <!-- Options list -->
                        <div id="optionsDept" class="max-h-96 overflow-auto p-1">
                            @foreach ($departments as $department)
                                <label
                                    class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded text-black dark:text-white">
                                    <input type="checkbox" value="{{ $department }}" class="mr-2">
                                    <span>{{ $department }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hidden input to store selected values -->
                    <input type="hidden" name="department" id="selectedDepartments">
                </div>
                <div>
                    <label for="user" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Holder
                        Name
                        Name</label>

                    <input type="text" id="user" name="user" list="userList" autocomplete="off"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <datalist id="userList"></datalist>
                </div>
                <div>
                    <label for="description"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Item</label>

                    <input type="text" id="description" name="description"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start
                        (Transaction Date)</label>

                    <input type="text" id="start_date" name="start_date"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                        date (Transaction Date)</label>

                    <input type="text" id="end_date" name="end_date"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>



                <div class="relative ">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Initial
                        Condition</label>
                    <div class="border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 p-2 cursor-pointer max-h-10 overflow-hidden   text-black dark:text-white"
                        id="dropdownToggle">
                        Select conditions...
                    </div>
                    <div class="absolute  mt-1 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600  rounded-lg shadow-lg hidden max-h-96 overflow-auto z-10"
                        id="dropdownMenu">
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="New" class="mr-2"> New
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Good" class="mr-2"> Good
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Very good" class="mr-2"> Very good
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Low" class="mr-2"> Low
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Second hand" class="mr-2"> Second hand
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Medium" class="mr-2"> Medium
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Old" class="mr-2"> Old
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Very old" class="mr-2"> Very old
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Broken" class="mr-2"> Broken
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Donation" class="mr-2"> Donation
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Disposal" class="mr-2"> Disposal
                        </label>
                        <label
                            class="flex items-center px-2 py-1 hover:bg-gray-200 dark:hover:bg-gray-600 text-black dark:text-white">
                            <input type="checkbox" value="Sold Out" class="mr-2"> Sold Out
                        </label>
                    </div>
                </div>

                <div>
                    <label for="state"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="state" name="state"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="All">Show All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>
                @if (Auth::user()->role == 'super_admin')
                    <div>
                        <label for="deleted" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                            Delete Status
                        </label>
                        <select id="deleted" name="deleted"
                            class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="All">Show All</option>
                            <option value="1">Deleted</option>
                            <option value="0">Active</option>
                        </select>

                    </div>
                @else
                    <input type="text" name="deleted" value="All" class="hidden">
                @endif
            </div>
            <div
                class="max-w-full items-center flex  justify-between px-2 mt-1 lg:mt-2 py-1 lg:py-2 sm:grid sm:grid-cols-1">
                <div class="flex main_page justify-between items-center">
                    <div class="flex">
                        <select name="" onchange="otherSearch()" id="other_search"
                            class="w-36 bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Other Search</option>
                            <!-- ASSET INFO -->
                            <option value="reference">Refference</option>
                            <option value="assets1">Asset Code 1</option>
                            <option value="assets2">Asset Code 2</option>
                            <option value="fa_no">Fix Asset No</option>
                            <option value="item">Item</option>
                            <option value="specification">Specification</option>
                            <option value="item_description">Item Description</option>
                            <option value="asset_group">Asset Group</option>
                            <option value="remark_assets">Remark Assets</option>
                            <!-- HOLDER INFO -->
                            <option value="asset_holder">Assets Holder ID</option>
                            <option value="position">Position</option>
                            <option value="location">Location</option>
                            <option value="remark_holder">Remark Holder</option>

                            <!-- INTERNAL DOC INFO -->
                            <option value="grn">GRN</option>
                            <option value="po">PO</option>
                            <option value="pr">PR</option>
                            <option value="dr">DR</option>
                            <option value="dr_requested_by">DR Requested By</option>
                            <option value="remark_internal_doc">Remark Document</option>

                            <!-- ERP DATA -->
                            <option value="asset_code_account">Asset Code Account</option>
                            <option value="description">Description</option>
                            <option value="invoice_no">Invoice No</option>
                            <option value="fa">FA</option>
                            <option value="fa_class">Fix Asset Class</option>
                            <option value="fa_subclass">Fix Asset Subclass</option>
                            <option value="depreciation">Depreciation</option>
                            <option value="fa_type">Fix Asset Type</option>
                            <option value="fa_location">Fix Asset Location</option>
                            <option value="cost">Cost</option>
                            <option value="vat">VAT</option>
                            <option value="currency">Currency</option>
                            <option value="description">Description</option>
                            <option value="invoice_description">Invoice Description</option>
                            <option value="vendor">Vendor</option>
                            <option value="vendor_name">Vendor Name</option>
                            <option value="address">Address</option>
                            <option value="address2">Address 2</option>
                            <option value="contact">Contact</option>
                            <option value="phone">Phone</option>
                            <option value="email">Email</option>

                            <!-- MOVEMENT INFO -->
                            <option value="ref_movement">Movement Reference</option>
                            <option value="purpose">Purpose</option>
                            <option value="status_recieved">Status Received</option>
                            <option value="to_ref">To Reference</option>
                            <option value="old_code">Old Code</option>


                        </select>
                        <input type="text" id="other_value"
                            class="w-32 bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                                &ensp;Total Transaction: {{ $total_assets }} Records </span>
                        </div>

                    </div>
                    <div class="flex fix_button">

                        <button type="button" id="print" onclick="print_group()"
                            class="text-white  hidden update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Print
                        </button>

                        <button type="button" id="export_excel" onclick="export_group()"
                            class="text-white  hidden update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <i class="fa-solid fa-download"></i>
                        </button>

                        <button type="button" onclick="search_movement(0)" id="search_item"
                            class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                        </button>


                    </div>
                </div>


            </div>

        </form>

    </div>
    <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
        <div class="scroll-container">
            <table id="list_assets"
                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr tabindex="0">
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            <input onchange="select_all()" type="checkbox" id="select_all"
                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                        </th>

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            ID &ensp;
                        </th>

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Transaction Date&ensp;
                        </th>
                        </th>

                        <th scope="col"
                            class="table_float_left_th px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-white dark:bg-gray-700 dark:border-gray-700">
                            Asset Code&ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">

                            Status &ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Initial Condition&ensp;
                        </th>


                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Item&ensp;
                        </th>

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Specification&ensp;
                        </th>


                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Holder Name&ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Department&ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Company&ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Old Code&ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Refference&ensp;
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Purpose&ensp;
                        </th>
                        <th>
                            status when recieved
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                            Issue Date&ensp;
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                            style="  position: sticky; right: 0;">

                            <button id="sidebarToggle" onclick="adjustLayout()"
                                class="flex items-center justify-center p-1 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200">
                                <i id="toggleIcon" class="fa-solid fa-maximize"></i></button>
                        </th>
                    </tr>
                </thead>

                <tbody id="assets_body">
                    @if (!empty($asset))
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($asset as $item)
                            @if ($item->deleted == 0)
                                <tr tabindex="0"
                                    class="  bg-white text-black  border-b dark:bg-gray-800 dark:text-white dark:border-gray-700">
                                    <td class="print_val ">
                                        <input onchange="printable()" data-id="{{ $item->assets_id }}"
                                            id="green-checkbox{{ $item->id }}" type="checkbox" value=""
                                            class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">



                                    </td>
                                @else
                                <tr tabindex="0"
                                    class="deleted_record bg-rose-100 border-b dark:bg-rose-800 dark:border-gray-700">

                                    <td class="print_val ">
                                        <input onchange="printable()" data-id="{{ $item->assets_id }}"
                                            id="green-checkbox{{ $item->id }}" type="checkbox" value=""
                                            class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        Deleted
                                    </td>
                            @endif
                            <td>

                                {{ $item->assets_id }}


                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-M-Y') }}

                            </td>


                            <td class="table_float_left_td   bg-white dark:bg-gray-900 dark:border-gray-700">
                                {{ $item->assets1 . $item->assets2 ?? '' }}
                            </td>
                            <td>
                                @if ($item->status == 0)
                                    <span
                                        class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        Inactive
                                    </span>
                                @elseif($item->status == 1)
                                    <span
                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $item->initial_condition }}
                            </td>
                            <td>
                                {{ $item->item }}
                            </td>

                            <td>
                                {{ $item->specification }}
                            </td>

                            <td>
                                {{ $item->holder_name ?? '' }}
                            </td>
                            <td>
                                {{ $item->department ?? '' }}
                            </td>
                            <td>
                                {{ $item->company ?? '' }}
                            </td>

                            <td>
                                {{ $item->old_code ?? '' }}
                            </td>
                            <td>
                                {{ $item->reference ?? '' }}
                            </td>
                            <td>
                                {{ $item->purpose ?? '' }}
                            </td>
                            <td>
                                {{ $item->status_recieved }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}

                            </td>
                            <td class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                @if ($item->status == 0)
                                    <a
                                        href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}">
                                        <button data-popover-target="popover-default{{ $no }}"
                                            type="button"
                                            class="text-black mx-2 bg-grey-100 hover:bg-grey-200 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-2.5 py-2 text-center dark:bg-gray-900 dark:hover:bg-gray-200 dark:focus:ring-gray-300 dark:text-white">

                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </a>
                                @else
                                    <div class="option">
                                        <button id="dropdownMenuIconHorizontalButton{{ $item->assets_id }}"
                                            data-dropdown-toggle="dropdownDotsHorizontal{{ $item->assets_id }}"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div id="dropdownDotsHorizontal{{ $item->assets_id }}"
                                            class="option_dark hidden  bg-white border-b dark:bg-gray-800 dark:border-gray-700   rounded-lg shadow-sm w-44 ">

                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton{{ $item->assets_id }}">

                                                @if (Auth::user()->Permission->transfer_write == 1 && $item->deleted == 0)
                                                    <li class="movement">
                                                        <a href="/admin/movement/add/detail/id={{ $item->assets_id }}"
                                                            class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">Movement</a>
                                                    </li>
                                                @endif


                                                @if (Auth::user()->Permission->assets_read == 1)
                                                    <li>
                                                        <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                                                            class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">View</a>
                                                    </li>
                                                @endif

                                                @if (Auth::user()->Permission->assets_update == 1 && $item->status == 1)
                                                    <li>
                                                        <a href="/admin/assets/data/update/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                                                            class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">Update</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->Permission->assets_delete == 1 && $item->deleted == 0)
                                                    <li class="cursor block px-4 py-2 hover:bg-gray-200 bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black"
                                                        data-id="{{ $item->assets_id }}"
                                                        id="btn_delete_asset{{ $item->assets_id }}"
                                                        onclick="openDeleteModal('btn_delete_asset{{ $item->assets_id }}')">
                                                        Delete
                                                    </li>
                                                @endif
                                            </ul>

                                        </div>
                                    </div>
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    @endif



                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="hidden">
    <form id="form_print" action="/admin/qr/code/print/assets" method="post">
        @csrf
        <input type="text" name="id" id="id_printer">
        <button type="submit">submit</button>
    </form>
    <form id="form_export" action="/admin/export/excel/movement" method="post">
        @csrf
        <input type="text" name="id_export" id="id_export">
        <button type="submit">submit</button>
    </form>
</div>


<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="background-color: #3a3a3aab;" class="fixed inset-0  bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Confirm Deletion</h3>
        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">Please provide a reason for deletion:</p>
        <input type="text" id="deleteReason" placeholder="Reason..."
            class="w-full p-2 border border-gray-300 rounded-lg mb-4 dark:bg-gray-700 dark:text-white dark:border-gray-600">
        <div class="flex justify-end gap-2">
            <button id="cancelDelete"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">Cancel</button>
            <button id="confirmDelete"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>



<script>


    let authRole = @json(Auth::user()->role);
    let currentBtn = null; // store the button clicked
    let currentAssetId = null;
    function openDeleteModal(btnId) {
        currentBtn = document.getElementById(btnId);
        currentAssetId = currentBtn.dataset.id;
        document.getElementById('deleteReason').value = '';
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    // Close modal
    document.getElementById('cancelDelete').addEventListener('click', () => {
        document.getElementById('deleteModal').classList.add('hidden');
    });
    document.getElementById('confirmDelete').addEventListener('click', async () => {
        const reason = document.getElementById('deleteReason').value.trim();
        if (!reason) {
            showErrorToast('Please provide a reason.');
            return;
        }
        document.getElementById('deleteModal').classList.add('hidden');

        try {
            const response = await fetch(`/api/delete_admin_asset`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                    "Cache-Control": "no-cache",
                    Pragma: "no-cache",
                },
                body: JSON.stringify({
                    id: currentAssetId,
                    reason: reason
                }),
            });

            const result = await response.json();
            const row = currentBtn.closest("tr");

            if (result.success) {
                // remove delete button
                currentBtn.remove();

                // ✅ Remove .movement class immediately
                if (row) {
                    // remove .movement class element inside the row
                    const movementEl = row.querySelector('.movement');
                    if (movementEl) movementEl.remove();
                }

                if (authRole === "admin") {
                    // Admin → remove row with fade
                    if (row) {
                        row.style.transition = "opacity 0.5s ease";
                        row.style.opacity = "0";
                        setTimeout(() => row.remove(), 500);
                    }
                } else if (authRole === "super_admin") {
                    // Super admin → mark row as deleted
                    if (row) {
                        row.classList.add("deleted_record");
                        row.style.opacity = "0.5";
                        row.style.textDecoration = "line-through";

                        // Optional: add Deleted badge
                        const badge = document.createElement("span");
                        badge.textContent = "Deleted";
                        badge.className = "ml-2 px-2 py-0.5 text-xs bg-red-200 text-red-800 rounded";
                        row.querySelector("td").appendChild(badge);
                    }
                }

                showSuccessToast(result.message || 'Deleted successfully');
            } else {
                showErrorToast(result.message || 'Failed to delete');
            }

        } catch (error) {
            console.error("Delete error:", error);
            showErrorToast('Something went wrong while deleting.');
        }
    });













    let page_view = @json($page);
    const button = document.querySelector('#search_item');
    // id="search_button"
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            button.click();
        }
    });

    flatpickr("#start_date", {
        dateFormat: "d-M-Y",
        defaultDate: null
    });
    flatpickr("#end_date", {
        dateFormat: "d-M-Y",
        defaultDate: null
    });


    // ✅ Get valid lists from backend (passed as JSON)

    const validCompanies = @json($companies);

    // ✅ Helper to validate input
    function validateInputList(inputId, validList, label) {
        const input = document.getElementById(inputId);

        input.addEventListener("blur", () => {
            const value = input.value.trim();

            if (value !== "" && !validList.includes(value)) {
                input.value = ""; // clear input

                // Show red toast
                const toast_red = document.getElementById("toast_red");
                toast_red.querySelector("p").innerHTML = `${label} not found.`;

                toast_red.style.display = "block";
                toast_red.style.animation = "none"; // reset animation
                toast_red.offsetHeight; // trigger reflow
                toast_red.style.animation = "fadeOut2 4s forwards"; // start fade animation

                // Optional: Reset pagination or body
                if (typeof pagination_search !== "undefined") {
                    pagination_search.innerHTML = `
                    <li class="mx-2" style="margin-left:10px;">
                        <a href="0" aria-current="page"
                            class="z-10 flex items-center justify-center px-1 h-4 lg:px-3 lg:h-8 md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                            <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                        </a>
                    </li>`;
                }
            }
        });
    }

    // ✅ Apply validation to both fields

    validateInputList("company", validCompanies, "Company");


    document.addEventListener("DOMContentLoaded", () => {
        const userInput = document.getElementById("user");
        const userList = document.getElementById("userList");
        const toast_red = document.getElementById("toast_red");


        let fetching = false;

        async function fetchUsers(query = "") {
            if (fetching) return;
            fetching = true;

            try {
                const response = await fetch(`/api/fetch-users?q=${encodeURIComponent(query)}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                        "Cache-Control": "no-cache",
                        Pragma: "no-cache",
                    },
                });

                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const users = await response.json();

                // populate datalist
                userList.innerHTML = "";
                users.forEach(user => {
                    const option = document.createElement("option");
                    option.value = user.full_name;
                    userList.appendChild(option);
                });
            } catch (error) {
                console.warn("Could not fetch users:", error);
            } finally {
                fetching = false;
            }
        }

        // fetch server-side as user types
        userInput.addEventListener("input", () => {
            const query = userInput.value.trim();
            fetchUsers(query);
        });

        // ✅ Validate input on blur
        userInput.addEventListener("blur", async () => {
            const query = userInput.value.trim();
            if (!query) return;

            // Fetch filtered results to validate
            try {
                const response = await fetch(`/api/fetch-users?q=${encodeURIComponent(query)}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                        "Cache-Control": "no-cache",
                        Pragma: "no-cache",
                    },
                });
                const users = await response.json();
                const validNames = users.map(u => u.full_name);
                if (!validNames.includes(query)) {
                    userInput.value = "";
                    toast_red.querySelector("p").innerHTML = "User not found.";
                    toast_red.style.display = "block";
                    toast_red.style.animation = "none";
                    toast_red.offsetHeight;
                    toast_red.style.animation = "fadeOut2 4s forwards";
                }
            } catch (error) {
                console.warn("Validation failed:", error);
            }
        });

        // fetch initial list on focus
        userInput.addEventListener("focus", () => fetchUsers());



    });




    const toggle = document.getElementById('dropdownToggle');
    const menu = document.getElementById('dropdownMenu');
    let isOpen = false;

    toggle.addEventListener('click', () => {
        if (!isOpen) {
            // Move dropdown to body
            document.body.appendChild(menu);

            // Position it right below the toggle
            const rect = toggle.getBoundingClientRect();
            menu.style.position = 'absolute';
            menu.style.top = `${rect.bottom + window.scrollY}px`;
            menu.style.left = `${rect.left + window.scrollX}px`;
            menu.style.width = `${rect.width}px`;
            menu.style.zIndex = 9999;
            menu.classList.remove('hidden');
            isOpen = true;
        } else {
            menu.classList.add('hidden');
            isOpen = false;
        }
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
            isOpen = false;
        }
    });
    let selected = [];
    // Update the label to show selected items
    const checkboxes = menu.querySelectorAll('input[type="checkbox"]');
    toggle.textContent = "Select conditions...";
    checkboxes.forEach(box => {
        box.addEventListener('change', () => {
            selected = Array.from(checkboxes)
                .filter(i => i.checked)
                .map(i => i.value);
            toggle.textContent = selected.length ? selected.join(', ') : "Select conditions...";

        });
    });

    let selected_dep = [];
    document.addEventListener("DOMContentLoaded", () => {
        const toggle = document.getElementById("dropdownToggleDept");
        const menu = document.getElementById("dropdownMenuDept");
        const checkboxes = menu.querySelectorAll("input[type='checkbox']");
        const hiddenInput = document.getElementById("selectedDepartments");
        const searchInput = document.getElementById("searchDept");
        const optionsContainer = document.getElementById("optionsDept");
        let isOpen = false;

        // Toggle dropdown
        toggle.addEventListener("click", () => {
            menu.classList.toggle("hidden");
            isOpen = !isOpen;
            if (isOpen) {
                // Move dropdown to body to fix z-index issues
                document.body.appendChild(menu);
                const rect = toggle.getBoundingClientRect();
                menu.style.position = "absolute";
                menu.style.top = `${rect.bottom + window.scrollY}px`;
                menu.style.left = `${rect.left + window.scrollX}px`;
                menu.style.width = `${rect.width}px`;
                menu.style.zIndex = 9999;
            }
        });

        // Click outside closes menu
        document.addEventListener("click", (e) => {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
                isOpen = false;
            }
        });
        // Array for department

        // Update label and hidden input
        checkboxes.forEach(box => {
            box.addEventListener("change", () => {
                selected_dep = Array.from(checkboxes)
                    .filter(i => i.checked)
                    .map(i => i.value);

                toggle.textContent = selected_dep.length ? selected_dep.join(", ") :
                    "Select departments...";
                hiddenInput.value = selected_dep.join(",");

            });
        });

        // Search filter
        searchInput.addEventListener("input", () => {
            const term = searchInput.value.toLowerCase();
            Array.from(optionsContainer.querySelectorAll("label")).forEach(label => {
                const text = label.textContent.toLowerCase();
                label.style.display = text.includes(term) ? "" : "none";
            });
        });
    });
</script>
@endsection
