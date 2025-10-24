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

    <title>Assets System (Printing)</title>

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
                @if(!empty($item->assets1) ||!empty($item->assets2 )  )
                    @if ($item->assets1 == '')
                        <div onclick="remove_QR('#qr_{{ $item->id }}')" id="qr_{{ $item->id }}" class="box_qr flex">
                            Asset Code Null,<br> Can't generate. Click to Remove
                        </div>
                    @else
                        <div onclick="remove_QR('#qr_{{ $item->id }}')" id="qr_{{ $item->id }}" class="box_qr flex">
                            {!! QrCode::size(150)->generate($item->assets1 . $item->assets2) !!} &ensp; <span>{{ $item->assets1 . $item->assets2 }}</span>
                        </div>
                    @endif
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

    @php
        if (empty($array_qr)) {
            $array_qr = null;
        }
    @endphp
</body>

<script src="{{ URL('/assets/js/print_qr.js') }}"></script>
{{-- @if (!empty($array_qr))
<script>

        let array = @json($array_qr);


</script>
@endif --}}
</html>
