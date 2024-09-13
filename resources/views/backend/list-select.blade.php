@extends('backend.master')
@section('content')

    <div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">

        <div class="search-bar bg-white border-b dark:bg-gray-800 dark:border-gray-700">


            {{-- <form action="/admin/assets/add/search" method="POST">
                @csrf --}}
                <div class="max-w-full min-h-full grid px-2 py-1 gap-2 grid-cols-4">
                    <div>
                        <label for="assets" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Assets
                            Code</label>


                        @if (!empty($search))
                            <input type="text" id="assets" value="{{ $search['assets'] }}" name="assets"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <input type="text" id="assets" name="assets"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="fa" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">FIX
                            Asset</label>
                        @if (!empty($search))
                            <input type="text" id="fa" value="{{ $search['fa'] }}" name="fa"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <input type="text" id="fa" name="fa"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="invoice"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Invoice</label>
                        @if (!empty($search))
                            <input type="text" id="invoice" value="{{ $search['invoice'] }}" name="invoice"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <input type="text" id="invoice" name="invoice"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="description"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        @if (!empty($search))
                            <input type="text" id="description" value="{{ $search['description'] }}" name="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <input type="text" id="description" name="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start
                            from date</label>
                        @if (!empty($search))
                            <input type="date" id="start_date" name="start_date" value="{{ $search['start_date'] }}"
                                name="end_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <input type="date" id="start_date" name="start_date" value="{{ $start_date }}"
                                name="end_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                            date</label>
                        @if (!empty($search))
                            <input type="date" id="end_date" value="{{ $search['end_date'] }}" name="end_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @else
                            <input type="date" id="end_date" value="{{ $end_date }}" name="end_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif
                    </div>



                    <div>
                        <label for="state"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        <select id="state" name="state"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (!empty($search))
                                @if ($search['state'] == 'invoice')
                                    <option value="invoice">Invoice</option>
                                    <option value="no_invoice">No Invoice</option>
                                    <option value="All">All</option>
                                @elseif($search['state'] == 'All')
                                    <option value="All">All</option>
                                    <option value="no_invoice">No Invoice</option>
                                    <option value="invoice">Invoice</option>
                                @else
                                    <option value="no_invoice">No Invoice</option>
                                    <option value="invoice">Invoice</option>
                                    <option value="All">All</option>
                                @endif
                            @else
                                <option value="All">All</option>
                                <option value="no_invoice">No Invoice</option>
                                <option value="invoice">Invoice</option>
                            @endif

                        </select>
                    </div>
                </div>
                <div class="max-w-full flex justify-end px-5">
                    <button type="button" onclick="(console.log(array))"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Test Array 
                </button>
                    <a href="/admin/assets/add/assets=NEW/invoice_no=NEW">
                        <button type="button"
                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            New
                        </button>
                    </a>

                    <button type="button" onclick="raw_assets()"
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                    </button>
                </div>
            {{-- </form> --}}

        </div>
        <div class="table-data  max-w-full">
            <table id="resultList"
                class="table_respond text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-4">
                            No  
                        </th>
                        <th scope="col" class="px-6 py-4" onclick="dynamic_sort('assets_date','date','raw_assets')">
                            Invoice Date &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-4" onclick="dynamic_sort('assets','string','raw_assets')">
                            Assets Code&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-4" onclick="dynamic_sort('fa','string','raw_assets')">
                            Fix Assets&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-4" onclick="dynamic_sort('invoice_no','string','raw_assets')">
                            Invoice&ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-4" onclick="dynamic_sort('description','string','raw_assets')">
                            Description&ensp; <i class="fa-solid fa-sort"></i>
                        </th>

                        <th scope="col" class="px-6 py-4">
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
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $no }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($item->assets_date)->format('M d Y') }}

                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->assets }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->fa }}
                                </td>

                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->invoice_no }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->description }}
                                </td>



                                <td class="px-6 py-4">
                                    {{-- /admin/assets/add/assets=P-F-AMM-0577/invoice_no=FAF24/0103 --}}

                                    @php

                                        $modifiedString = str_replace('/', '-', $item->fa);
                                    @endphp
                                    {{-- {{$invoice}} --}}
                                    <a href="/admin/assets/add/assets={{ $item->assets }}/invoice_no={{ $modifiedString }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Select</a>
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
        let array  = @json($data);
        let sort_state = 0;


    </script>

@endsection
