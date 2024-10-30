@extends('backend.master')
@section('content')

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
                        <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start</label>

                        <input type="date" id="start_date" name="start_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                            date</label>

                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>



                    {{-- <div>
                        <label for="state"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        <select id="state" name="state"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="All">All</option>
                            <option value="0">Active</option>
                            <option value="2">Sold</option>



                        </select>
                    </div> --}}
                </div>
                <div class="max-w-full items-center flex  justify-between px-2 mt-1 lg:mt-2 py-1 lg:py-2 sm:grid sm:grid-cols-1">
                    <div class="flex main_page justify-between items-center" >
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
                                    <select onchange="set_page_movement()" id="select_page"
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
                                    <span class="font-bold flex justify-center items-center dark:text-slate-50">Page :{{ $total_page }} Pages
                                        &ensp;Total Assets: {{ $total_record }} Records</span>
                                </div>

                        </div>
                        <div class="flex fix_button">
                            <button type="button" onclick="search_asset_for_movement(0)" id="search_button"
                                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
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

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            ID</th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Asset Date</th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Reference</th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Assets Code
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Fix Assets
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Invoice
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Status
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Item Description
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Invoice Description
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                            Movement
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                        style="  position: sticky; right: 0;">
                            Action
                        </th>
                        </th>

                    </tr>
                </thead>
                <tbody id="table_select_movement_body">
                    @if (!empty($data))
                        @foreach ($data as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->assets_id }}
                                </td>
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}

                                </td>
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->document }}
                                </td>
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->assets1 . $item->assets2 }}
                                </td>
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->fa }}
                                </td>

                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->invoice_no }}
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
                                            status
                                        </span>
                                    @elseif($item->status == 2)
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Sold
                                        </span>
                                    @endif
                                </td>
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->item_description }}
                                </td>

                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->invoice_description }}
                                </td>
                                <td scope="row"
                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->total_movement}}
                                </td>
                                <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                                style="  position: sticky; right: 0; ">

                                    <a href="/admin/movement/add/detail/id={{ $item->assets_id }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Create Movement</a>
                                </td>
                            </tr>
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


        document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            button.click();
        }
        });
    </script>
@endsection
