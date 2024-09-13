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

                    <input type="date" id="start_date" name="start_date" value="" name="end_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To
                        date</label>

                    <input type="date" id="end_date" value="{{ today() }}" name="end_date"
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
            <div class="max-w-full flex justify-end px-5  ">

                <button type="button" onclick="(alert('Under Development !'))"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                </button>
            </div>
            {{-- </form> --}}

        </div>
        <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">

            <table id="list_assets"
                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-4">ID</th>
                        <th scope="col" class="px-6 py-4">Asset Date</th>
                        <th scope="col" class="px-6 py-4">Reference</th>
                        <th scope="col" class="px-6 py-4">
                            Assets Code
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Fix Assets
                        </th>



                        <th scope="col" class="px-6 py-4">
                            Invoice
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Item Description
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Invoice Description
                        </th>
                        <th scope="col" class="px-6 py-3"
                            style="  position: sticky; right: 0;   background-color: rgb(230, 230, 230);">
                            Action
                        </th>
                        </th>

                    </tr>
                </thead>
                <tbody id="table_raw_body">
                    @if (!empty($data))
                        @foreach ($data as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->id }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}

                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->document }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->assets1 . $item->assets2 }}
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
                                    {{ $item->item_description }}
                                </td>

                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->invoice_description }}
                                </td>


                                <td class="px-6 py-4 dark:bg-slate-900"
                                style="  position: sticky; right: 0;   background-color: white; ">

                                    <a href="/admin/transfer/add/assets_id={{ $item->id }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Select</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif



                </tbody>
            </table>
        </div>







    </div>


@endsection
