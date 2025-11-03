@extends('backend.master')
@section('content')
@section('header')
  Invoice List
@endsection
@section('style')
   <span class="mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
                 class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Add Assets by Invoice ERP</span>
</span>

@endsection
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">

    <div class="search-bar bg-white border-b dark:bg-gray-800 dark:border-gray-700">


        {{-- <form action="/admin/assets/add/search" method="POST">
                @csrf --}}
        <div class="max-w-full min-h-full grid px-2 py-1 gap-2 grid-cols-3 lg:grid-cols-4">
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
                    from date (Posting Date)</label>

                        <input type="text" id="start_date" name="start_date"  name="start_date"    onchange="check_date()"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />



            </div>
            <div>
                <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                    date (Posting Date)</label>

                <input type="date" id="end_date" name="end_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

            </div>



            <div>
                <label for="state" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">State</label>
                <select id="state" name="state"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="All">All</option>
                    <option value="no_invoice">No Invoice</option>
                    <option value="invoice">Invoice</option>
                </select>
            </div>
        </div>
        <div class="max-w-full flex main_page justify-between items-center px-2">


            @if (!empty($total_page))
                @if ($total_page > 1)
                    <div class="flex main_page pagination_by_search">

                        @php
                            $left_limit = max(1, $page - 5); // Set the left boundary, but not below 1
                            $right_limit = min($total_page, $page + 5); // Set the right boundary, but not above the total pages
                        @endphp
                        <nav aria-label="Page navigation example">
                            <ul class="flex -space-x-px h-8 text-sm">


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
                                @php
                                    $state_i = 0;
                                @endphp
                                @for ($i = $left_limit; $i <= $right_limit; $i++)
                                    {{-- Loop from left to right in ascending order --}}
                                    @if ($i == $page)
                                        <li>
                                            <a href="{{ $i }}" aria-current="page"
                                                class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                                        </li>
                                        @php
                                            $state_i = $i;
                                        @endphp
                                    @else
                                        <li>
                                            <a href="{{ $i }}"
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                                        </li>
                                        @php
                                            $state_i = $i;
                                        @endphp
                                    @endif
                                @endfor
                                @if ($state_i != $total_page)
                                    <li>
                                        <a href="{{ $total_page }}"
                                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $total_page }}</a>
                                    </li>
                                @endif
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

                        <select onchange="set_page_raw()" id="select_page"
                            class="flex mx-0 lg:mx-2 md:mx-2 items-center justify-center px-3 h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
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
                            &ensp;Total Assets: {{ $total_record }} Records</span>
                    </div>
                @endif
            @endif
            <div class="flex fix_button">
                <a href="/admin/assets/add/assets=NEW/invoice_no=NEW">
                    <button type="button" data-popover-target="popover-default-new"
                        class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        New
                    </button>
                </a>
                <div data-popover id="popover-default-new" role="tooltip"
                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div
                        class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Info</h3>
                    </div>
                    <div class="px-3 py-2">
                        <p>Create New Asset on Mamnual</p>
                    </div>
                    <div data-popper-arrow></div>
                </div>


                <button type="button" onclick="raw_assets()" id="search_button"
                    class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                </button>
            </div>
        </div>
        {{-- </form> --}}

    </div>
    <div class="table-data  max-w-full mt-2">
        <table id="resultList" class="table_respond text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr   tabindex="0">

                    <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">
                        No
                    </th>
                    <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                        onclick="dynamic_sort('assets_date','date','raw_assets')">
                        Invoice Date &ensp;
                    </th>
                    <th scope="col"
                        onclick="dynamic_sort('assets','string','raw_assets')">
                        Assets Code&ensp;
                    </th>
                    <th scope="col"
                        onclick="dynamic_sort('fa','string','raw_assets')">
                        Fix Assets&ensp;
                    </th>
                    <th scope="col"
                        onclick="dynamic_sort('invoice_no','string','raw_assets')">
                        Invoice&ensp;
                    </th>
                    <th scope="col"
                        onclick="dynamic_sort('description','string','raw_assets')">
                        Description&ensp;
                    </th>

                    <th scope="col" >
                        Action
                    </th>

                </tr>
            </thead>
            <tbody id="table_raw_body">
                @if (!empty($data))
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $item)
                        <tr   tabindex="0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                            <td scope="row"
                                class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $no }}
                            </td>
                            <td scope="row"
                                class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ \Carbon\Carbon::parse($item->assets_date)->format('d-M-Y') }}

                            </td>
                            <td scope="row"
                                class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->assets }}
                            </td>
                            <td scope="row"
                                class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->fa }}
                            </td>

                            <td scope="row"
                                class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->invoice_no }}
                            </td>
                            <td scope="row"
                                class=" font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->description }}
                            </td>



                            <td >
                                {{-- /admin/assets/add/assets=P-F-AMM-0577/invoice_no=FAF24/0103 --}}

                                @php

                                    $modifiedString = str_replace('/', '-', $item->fa);
                                    if ($modifiedString == '') {
                                        $modifiedString = 'NA';
                                    }
                                @endphp
                                {{-- {{$invoice}} --}}
                                    @if ($item->is_registered == true)

                                      <span
                                        class="inline-flex items-center  text-green-800 text-xs font-medium px-2.5 py-2 rounded-full dark:bg-green-900 dark:text-green-300">
                                       <i class="fa-solid fa-circle-check mx-2" style="color: #369900;"></i>
                                       Registerd
                                    </span>
                                    @else


                                      <a
                                        href="/admin/assets/add/assets={{ $item->assets }}/invoice_no={{ $modifiedString }}">
                                        <button data-popover-target="popover-default{{$no}}" type="button"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><i
                                                class="fa-solid fa-square-plus" style="font-size:25px"></i></button>

                                    </a>
                                <div data-popover id="popover-default{{ $no }}" role="tooltip"
                                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div
                                        class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Info</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Select This Invoice to Create New Assets</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>


                                    @endif


                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                @endif



            </tbody>
        </table>
    </div>







</div>
<script>
    let array = @json($data);
    let sort_state = 0;

    const button = document.querySelector('#search_button');

    // id="search_button"
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            button.click();
        }
    });


    flatpickr("#start_date", {
        dateFormat: "d-M-Y",
        defaultDate: null,

    });
     flatpickr("#end_date", {
        dateFormat: "d-M-Y",
        defaultDate: null,

    });
</script>

@endsection
