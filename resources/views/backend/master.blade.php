<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/src/output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Tail Wind  --}}
    {{-- @vite('resources/css/app.css') --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    {{-- FONT AWSOME  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL('/assets/css/style_backend.css') }}">

    {{-- ICON Website  --}}
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/16925/16925957.png" type="image/x-icon">

    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript"
        src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

    <title>Assets MIS</title>
</head>

<body>
    <header></header>


    @if (Session::has('fail'))
        <div id="toast"
            class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 fill-red-800 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        {{ Session::get('fail') }}
                    </p>
                </div>
            </div>
        </div>
        </div>
    @endif
    @if (Session::has('success'))
        <div id="toast"
            class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 fill-lime-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        {{ Session::get('success') }}
                    </p>
                </div>
            </div>
        </div>
        </div>
    @endif


    <div id="logout"
        class="toast_delete w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
        role="alert">
        <div class="flex">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #000000;"></i>

                <span class="sr-only">Refresh icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">Are you want to Logout ?</span>


                <div class="grid grid-cols-2 gap-2 mt-5">

                    <div>
                        <a href="/logout">

                            <button
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">Yes</button>
                        </a>
                    </div>
                    <div>
                        <button onclick="cancel_toast('logout')" type="button"
                            class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <main>
        <div class="antialiased bg-gray-50 dark:bg-gray-900">
            <nav
                class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex justify-start items-center">
                        <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                            aria-controls="drawer-navigation"
                            class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <i class="fa-solid fa-bars"></i>
                            <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Toggle sidebar</span>
                        </button>
                        <a href="/" class="flex items-center justify-between mr-4">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR73_4f1_nNP2pC7eLjpmYsDGvJJJXfQ2btLg&s"
                                class="mr-3 h-8" alt="Flowbite Logo" />
                            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">PPM ASSET
                                MIS</span>
                        </a>

                    </div>
                    <div class="flex items-center lg:order-2">
                        <button type="button" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation"
                            class="p-2 mr-1 text-gray-500 rounded-lg md:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                            <span class="sr-only">Toggle search</span>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                        <button class="dark:text-white" id="dark-mode-toggle"><i
                                class="fa-solid fa-circle-half-stroke"></i></button>
                    </div>
                </div>
        </div>
        </nav>

        <!-- Sidebar -->

        @if(!empty(Auth::user()))
        <aside
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidenav" id="drawer-navigation">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
                <form action="#" method="GET" class="md:hidden mb-2">
                    <label for="sidebar-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input type="text" name="search" id="sidebar-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search" />
                    </div>
                </form>
                <ul class="space-y-2">
                    <li>
                        <a href="/"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span class="ml-3">Overview</span>
                        </a>
                    </li>
                    @if (Auth::user()->Permission->assets_write == 1 || Auth::user()->Permission->assets_read == 1)
                        <li>
                            <button type="button"
                                class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                                <i class="fa-solid fa-folder-open"></i>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Assets Record</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                                @php
                                    $state_asset = 0;
                                @endphp
                                @if (Auth::user()->Permission->assets_write == 1)
                                    <li>
                                        <a href="/admin/assets/add"
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Create
                                            Assets</a>
                                    </li>

                                    @php
                                        $state_asset = 1;
                                    @endphp
                                @endif
                                @if (Auth::user()->Permission->assets_read == 1)
                                    <li>
                                        <a href="/admin/assets/list"
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">List
                                            Assets</a>
                                    </li>

                                    @php
                                        $state_asset = 1;
                                    @endphp
                                @endif

                                @if ($state_asset == 0)
                                    <li>
                                        <span
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">No
                                            Permission</span>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->Permission->transfer_write == 1 || Auth::user()->Permission->transfer_read == 1)
                        <li>
                            <button type="button"
                                class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                aria-controls="dropdown-pages-user" data-collapse-toggle="dropdown-pages-transfer">
                                <i class="fa-solid fa-shuffle"></i>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Transfer</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <ul id="dropdown-pages-transfer" class="hidden py-2 space-y-2">

                                @if (Auth::user()->Permission->transfer_write == 1)
                                    <li>
                                        <a href="/admin/transfer/add"
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Create
                                            Transfer</a>
                                    </li>
                                @endif
                                @if (Auth::user()->Permission->transfer_read == 1)
                                    <li>
                                        <a onclick="(alert('Under Development'))"
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">List
                                            Transfer</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->Permission->user_write == 1 || Auth::user()->Permission->user_read == 1)
                        <li>
                            <button type="button"
                                class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                aria-controls="dropdown-pages-user" data-collapse-toggle="dropdown-pages-user">
                                <i class="fa-solid fa-user"></i>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">User Management</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <ul id="dropdown-pages-user" class="hidden py-2 space-y-2">
                                @php
                                    $state_user = 0;
                                @endphp
                                @if (Auth::user()->Permission->user_write == 1)
                                    <li>
                                        <a href="/admin/user/add"
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Add
                                            User</a>
                                    </li>
                                    @php
                                        $state_user = 1;
                                    @endphp
                                @endif
                                @if (Auth::user()->Permission->user_read == 1)
                                    <li>
                                        <a href="/admin/user/list"
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">List
                                            Users</a>
                                    </li>
                                    @php
                                        $state_user = 1;
                                    @endphp
                                @endif

                                @if ($state_user == 0)
                                    <li>
                                        <span
                                            class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">No
                                            Permission</span>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ( Auth::user()->Permission->quick_read == 1)
                    <li>
                                         <a  href="/quick/data">
                        {{-- <a href="/admin/user/list"> --}}
                            <button type="button"
                                class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                <i class="fa-solid fa-book"></i>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Quick Data</span>

                            </button>
                        </a>

                    </li>
                    @endif
                    @if(Auth::user()->role=="admin")
                    <li>
                        <a href="/admin/assets/change/log">
                            <button type="button"
                                class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap"> Change History</span>

                            </button>
                        </a>

                    </li>

                    @endif


                    <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                        <li onclick="logout()"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">


                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="ml-3">Log Out</span>

                        </li>


                    </ul>
            </div>



            </div>
        </aside>
        @endif
        <main class="pl-5   md:ml-64 min-h-screen pt-20 dark:bg-gray-600">
            @yield('content')


        </main>
        </div>
    </main>

    <script src="{{ URL('/assets/js/backend_script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fusioncharts@3.12.2/fusioncharts.js" charset="utf-8"></script>



</body>

</html>
