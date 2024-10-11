<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- ICON Website  --}}
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/16925/16925957.png" type="image/x-icon">

    {{-- FONT AWSOME  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html {
            position: relative;
            width: 100%;
            height: 100vh;
        }

        body {
            width: 100%;
            min-height: 100vh;
            padding: 20px;

        }

        #btn_print {
            position: fixed;
            right: 50px;
            bottom: 50px
        }

        #btn_print_list {
            position: fixed;
            right: 50px;
            bottom: 50px
        }

        #btn-zoom {
            background-color: white;
            border: 1px solid black;
            padding: 10px;
            position: fixed;
            left: 0px;

            bottom: 0px;
            width: 100%;
            height: 30vh;
        }

        .customize_panel {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px
        }

        .panel {
            background-color: rgb(0, 0, 0);
            border: 1px solid black;
            padding: 10px;
            position: fixed;
            left: 0px;

            bottom: 0px;
            width: 100%;
            height: 10%;
        }

        .customize_panel_list {
            width: 100%;
            display: flex;
            overflow: auto;
            white-space: nowrap;
        }

        .customize_panel_list input {
            min-height: 15px;
        }

        .box_qr {
            width: 219px;
            height: 60px;
            white-space: nowrap;
            border: 1px solid black;
            padding: 3px 5px;
            font-size: 15px;
            font-weight: bold;
            justify-content: space-between;
        }

        .box_qr svg {
            width: fit-content;
            height: 100%;
            display: flex;

        }

        .box_qr span {
            display: flex;
            align-items: center;
        }

        .container {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;

        }

        #list {
            /* display: none; */
            width: 100%;
            height: 100vh;
            position: fixed;
            top: 0px;
            left: 0px;
            background-color: white;

        }

        .inner_list {
            position: relative;
            width: 100%;
            height: 100%;
        }

        @media print {

            #btn-zoom,
            #btn_print,
            .panel,
            #btn_print_list {
                display: none;
            }

        }

        @media (max-width: 1000px) {
            #btn-zoom {
                height: 40vh;
                overflow: auto;
            }

            .customize_panel {

                grid-template-columns: repeat(2, 1fr);

            }
        }
    </style>

    <title>Assets MIS Print QR Code</title>

</head>

<body>
    <div class="container">
        @if (!empty($qr_code))
            <div class="box_qr flex">
                {!! $qr_code !!} &ensp; <span>{{ $raw }}</span>
            </div>
        @endif
        @if (!empty($array_qr))
            @foreach ($array_qr as $item)
                @if ($item->assets1 . $item->assets2 == '')
                    <div onclick="remove_QR('#qr_{{ $item->id }}')" id="qr_{{ $item->id }}" class="box_qr flex">
                        Asset Code Null,<br> Can't generate. Click to Remove
                    </div>
                @else
                    <div onclick="remove_QR('#qr_{{ $item->id }}')" id="qr_{{ $item->id }}" class="box_qr flex">
                        {!! QrCode::size(150)->generate($item->assets1 . $item->assets2) !!} &ensp; <span>{{ $item->assets1 . $item->assets2 }}</span>
                    </div>
                @endif
            @endforeach


        @endif
    </div>

    <div id="btn-zoom">
        <div class="customize_panel">
            <div>
                <label for="">Height <span id="size_change">100px</span></label>
                <div class="relative mb-6">
                    <input id="size" type="range" value="100" min="20" max="1000"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>

            <div>
                <label for="">width <span id="width_change">250px</span></label>
                <div class="relative mb-6">
                    <input id="width" type="range" value="250" min="0" max="1000"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">padding X :<span id="padding_change">5px</span></label>
                <div class="relative mb-6">
                    <input id="padding" type="range" value="5" min="0" max="50"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">padding Y :<span id="paddingY_change">0px</span></label>
                <div class="relative mb-6">
                    <input id="paddingY" type="range" value="0" min="0" max="50"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Border :<span id="border_change">1px</span></label>
                <div class="relative mb-6">
                    <input id="border" type="range" value="1" min="0" max="50"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Font Size <span id="size_change">20 px</span></label>
                <div class="relative mb-6">
                    <input id="font-size" type="range" value="20" min="0" max="100"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>

            </div>

            <div>
                <label for="">Font Bold <span id="weight_change">200</span></label>
                <div class="relative mb-6">
                    <input id="weight" type="range" value="250" min="0" max="700"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Columns Show <span id="grid_change">4 Columns</span></label>
                <div class="relative mb-6">
                    <input id="range_grid" type="range" value="4" min="0" max="10"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Gap<span id="gap_change">10 px</span></label>
                <div class="relative mb-6">
                    <input id="range_gap" type="range" value="10" min="0" max="50"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Background Color</label>
                <div class="relative mb-6">
                    <input id="color" type="color"
                        class="w-full h-5 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Content Color</label>
                <div class="relative mb-6">
                    <input id="c_color" type="color"
                        class="w-full h-5 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
            <div>
                <label for="">Border Color</label>
                <div class="relative mb-6">
                    <input id="b_color" type="color"
                        class="w-full h-5 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                </div>
            </div>
        </div>
    </div>
    <div id="btn_print">
        <button type="button" onclick="show_list_asset_print()"
            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 mx-2">List
            Data
        </button>
        <button type="button" onclick="window.print()"
            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 mx-2">Print
        </button>
        <a href="/">
            <button type="button"
                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 mx-2">Main
                Menu
            </button>
        </a>
    </div>
    @if (!empty($array_qr))
        <div id="list">



            <span class=" text-2xl font-bold">Assets List </span>
            <table id="list_assets"
                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr id="th">

                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Create Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Refference
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Asset Code
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fix Asset No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fix Asset Type
                        </th>

                        <th scope="col" class="px-6 py-3">

                            Status
                            </td>



                        <th scope="col" class="px-6 py-3">
                            Fix Asset class
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fix Asset Subclass
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Deoreciation Code
                        </th>
                        <th scope="col" class="px-6 py-3">
                            DR
                        </th>
                        <th scope="col" class="px-6 py-3">
                            PR
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Invoice No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @if (!empty($array_qr))
                        @foreach ($array_qr as $item)
                            <tr id="td" class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">


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
                                    @else
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Deleted
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

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="panel">
                <div class="customize_panel_list">
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="id">ID</label>
                        <input onchange="remove_child_table(1)" id="id" checked type="checkbox"
                            value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="date">Created
                            Date</label> <input onchange="remove_child_table(2)" checked id="date"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="ref">Refference</label>
                        <input onchange="remove_child_table(3)" checked id="ref" type="checkbox"
                            value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="ac">Asset
                            Code</label> <input onchange="remove_child_table(4)" checked id="ac"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>

                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="ano">Fix Asset No</label> <input onchange="remove_child_table(5)" checked
                            id="ano" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="at">Fix
                            Asset Type</label> <input onchange="remove_child_table(6)" checked id="at"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="st">Status</label> <input onchange="remove_child_table(7)" checked
                            id="st" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="acc">Fix
                            Asset Class</label> <input onchange="remove_child_table(8)" checked id="acc"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="as">Fix
                            Asset Subclass</label> <input onchange="remove_child_table(9)" checked id="as"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="dc">Depreciation
                            Code</label> <input onchange="remove_child_table(10)" checked id="dc"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="dr">DR</label>
                        <input onchange="remove_child_table(11)" checked id="dr" type="checkbox"
                            value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="pr">PR</label>
                        <input onchange="remove_child_table(12)" checked id="pr" type="checkbox"
                            value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="in">Invoice
                            No</label> <input onchange="remove_child_table(13)" checked id="in"
                            type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>
                    <kbd
                        class="mx-2 px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><label
                            for="d">Description</label>
                        <input onchange="remove_child_table(14)" checked id="d" type="checkbox"
                            value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></kbd>

                </div>
            </div>






            <div id="btn_print_list">


                <button onclick="window.print()"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 mx-2">Print</button>
                <button onclick="close_list_print()"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 mx-2">Close</button>

            </div>


        </div>
    @endif
    @php
        if (empty($array_qr)) {
            $array_qr = null;
        }
    @endphp
</body>

<script src="{{ URL('/assets/js/print_qr.js') }}"></script>
<script>
    if ($array_qr != null) {
        let array = @json($array_qr);
    }
</script>

</html>
