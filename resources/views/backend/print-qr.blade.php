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
        body{
            width: 100%;
            padding: 20px;
            position: relative;
        }
        #btn_print{
            position: fixed;
            right: 50px;
            bottom: 50px

        }
       
        .box_qr 
        {   
            width:fit-content;
            
            white-space: nowrap;
            border: 1px solid black;
            padding: 5px;
            font-size: 32px;
            font-weight: bold;
        }
        .size_adjust{
            width: 300px;
            
            background-color: rgb(0, 0, 0);
            display: flex;
            grid-template-columns: repeat(1fr,3fr);
        }
            @media print {
                        button {
                            display: none;
                        }
                    }
    </style>

    <title>Print QR Code</title>
    
</head>
<body>
    <div class="container">
        <div class="box_qr flex">
            {!! $qr_code !!} &ensp; <span >{{$raw}}</span>
        </div>
    </div>
    <div class="size_adjust">
        <button><i class="fa-solid fa-magnifying-glass-plus" style="color: #ff0000;"></i></button>
        <span>1</span>
        <button><i class="fa-solid fa-magnifying-glass-minus" style="color: #ff0000;"></i></button>
    </div>

    <div id="btn_print">


        <button type="button" onclick="window.print()"  class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Print </button>

    </div>
    
</body>
</html>