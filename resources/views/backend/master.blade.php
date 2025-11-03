    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/src/output.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Tailwind CSS (Vite) -->
        {{-- @vite('resources/css/app.css') --}}
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        {{-- FONT AWSOME  --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />


        <link rel="stylesheet" href="{{ URL('/assets/css/style_backend.css') }}">

        {{-- ICON Website  --}}
        <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/16925/16925957.png" type="image/x-icon">


        <title>@yield('header')</title>
    </head>

    <body id="body_backend">
        <div id="loading"
            class="fixed inset-0 flex items-center justify-center z-[9999] pointer-events-none opacity-100 transition-opacity duration-700">
            <div
                class="flex flex-col items-center justify-center p-6 rounded-2xl shadow-2xl bg-white/90 dark:bg-gray-800/90 w-64 sm:w-72 backdrop-blur animate-fade">

                <!-- Spinner with percentage -->
                <div class="relative mb-4 w-14 h-14">
                    <svg class="w-14 h-14 text-cyan-400 animate-spin-fast drop-shadow-lg" viewBox="0 0 50 50">
                        <circle class="opacity-20" cx="25" cy="25" r="22" stroke="currentColor"
                            stroke-width="4" fill="none"></circle>
                        <path class="opacity-80" fill="currentColor"
                            d="M25 5a20 20 0 1 0 20 20A20 20 0 0 0 25 5zm0 36a16 16 0 1 1 16-16 16 16 0 0 1-16 16z">
                        </path>
                    </svg>
                    <div id="percent_text"
                        class="absolute inset-0 flex items-center justify-center text-sm font-bold text-gray-800 dark:text-gray-100">
                        0%
                    </div>
                </div>

                <!-- Loading text with animated dots -->
                <h1 id="loading_text" class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 tracking-wide">
                    Loading
                </h1>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                    <div id="progress_bar"
                        class="progress-glow h-3 w-0 transition-all duration-300 ease-out rounded-full">
                    </div>
                </div>
            </div>
        </div>
        @if (Session::has('fail'))
            <div id="toast"
                class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
                role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 fill-red-800 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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
        @if (Session::has('error'))
            <div id="toast"
                class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
                role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 fill-red-800 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                            {{ Session::get('error') }}
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
                        <svg class="shrink-0 size-4 fill-lime-600 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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
            class="toast_delete w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-600 dark:text-gray-400"
            role="alert">
            <div class="flex">
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900">
                    <i class="fa-solid fa-arrow-right-from-bracket" style="color: #000000;"></i>

                    <span class="sr-only">Refresh icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">
                    <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">Are you want to Logout
                        ?</span>


                    <div class="grid grid-cols-2 gap-2 mt-5">

                        <div>
                            <a href="/logout">

                                <button
                                    class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">Yes</button>
                            </a>
                        </div>
                        <div>
                            <button onclick="cancel_toast('logout')" type="button"
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-rose-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
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
                                <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Toggle sidebar</span>
                            </button>
                            <a href="/" class="flex items-center justify-between mr-4">
                                <img src="/static_img/images.png" class="mr-3 h-8" alt="Flowbite Logo" />
                                <span
                                    class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white text-blue-900">
                                    Assets System</span> &ensp;&ensp;



                            </a>

                            @yield('style')
                        </div>
                        <div class="flex items-center lg:order-2">
                            <button type="button" data-drawer-toggle="drawer-navigation"
                                aria-controls="drawer-navigation"
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

            @if (!empty(Auth::user()))
                <aside
                    class="SideBar  fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
                    aria-label="Sidenav" id="drawer-navigation">
                    <div class="zindex99 overflow-y-auto   py-5 px-3 h-full bg-white dark:bg-gray-800">
                        <div
                            class="hide_destop flex items-center pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">

                            <img src="/static_img/images.png" class=" mr-3 h-8" alt="Flowbite Logo" />
                            <span>Assets System</span>
                        </div>

                        <form action="#" method="GET" class="md:hidden mb-2">
                            <label for="sidebar-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div id="search_icon_mobile"
                                    class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">

                                    <i class="fa-solid fa-magnifying-glass"></i>

                                </div>
                                <input autocomplete="off" onkeyup="search_mobile()" type="text" name="search"
                                    id="sidebar-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search Assets Code" />

                            </div>
                        </form>
                        <ul class="space-y-2">
                            {{-- @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') --}}
                                <li id="button_hover" class="flex justify-between">
                                    <a href="/"
                                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <i class="fa-solid fa-chart-pie"></i>
                                        <span class="ml-3">Dashboard</span>
                                    </a>
                                        <button id="sidebarToggle" onclick="toggleFullScreen()"
                                class="flex  items-center justify-center w-10 h-10 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200">
                                <i class="fa-solid fa-angles-right" ></i>
                            </button>

                                </li>
                            {{-- @endif --}}

                            @if (Auth::user()->Permission->assets_write == 1)
                                <li>
                                    <button type="button"
                                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                                        <i class="fa-solid fa-folder-plus"></i>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Add Asset</span>

                                        <i class="fa-solid fa-chevron-down ml-1"></i>
                                    </button>
                                    <ul id="dropdown-pages" class="hidden py-2 space-y-2" aria-expanded="true">


                                        <li>
                                            <a href="/admin/assets/add/1"
                                                class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                                <i class="fa-solid fa-file-invoice-dollar mx-2"></i>
                                                <span class="li-text">With Invoice</span></a>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/admin/assets/add/assets=NEW/invoice_no=NEW"
                                                class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><i
                                                    class="fa-solid fa-pen mx-2"></i>
                                                <span class="li-text">Manual</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/admin/import/assets"
                                                class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><i
                                                    class="mx-2 fa-solid fa-file-excel"></i>
                                                <span class="li-text">Import Excel</span></a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            @if (Auth::user()->Permission->assets_read == 1)
                                <li>
                                    <a href="/admin/assets/1">
                                        <button type="button"
                                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                            <i class="fa-solid fa-folder-open"></i>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap"> Manage Assets</span>

                                        </button>
                                    </a>

                                </li>
                                <li>
                                    <a href="/admin/assets/new/1">
                                        <button type="button"
                                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                            <i class="fa-solid fa-file"></i>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap"> New Assets
                                                List</span>

                                        </button>
                                    </a>

                                </li>
                            @endif
                            @if (Auth::user()->Permission->transfer_read == 1)
                                <li>
                                    <a href="/admin/assets/transaction/1">
                                        <button type="button"
                                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <i class="fa-solid fa-folder-tree"></i>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">Assets History</span>

                                        </button>
                                    </a>

                                </li>
                            @endif
                            @if (Auth::user()->Permission->user_write == 1 || Auth::user()->Permission->user_read == 1)
                                <li>
                                    <button type="button"
                                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="dropdown-pages-user"
                                        data-collapse-toggle="dropdown-pages-user">
                                        <i class="fa-solid fa-user"></i>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap">User Management</span>
                                        <i class="fa-solid fa-chevron-down ml-1"></i>
                                    </button>
                                    <ul id="dropdown-pages-user" class="hidden py-2 space-y-2">

                                        @if (Auth::user()->Permission->user_write == 1)
                                            <li>
                                                <a href="/admin/user/add"
                                                    class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><i
                                                        class="fa-solid fa-user-plus mx-2"></i>
                                                    <span class="li-text">Add
                                                        User</span></a>
                                                </a>
                                            </li>
                                        @endif
                                        @if (Auth::user()->Permission->user_read == 1)
                                            <li>
                                                <a href="/admin/user/list/1"
                                                    class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"><i
                                                        class="fa-solid fa-users-rectangle mx-2"></i><span
                                                        class="li-text">List Users</span></a>
                                            </li>
                                        @endif
                                        @if (Auth::user()->Permission->user_update == 1 &&
                                                Auth::user()->Permission->user_read == 1 &&
                                                Auth::user()->Permission->user_write == 1 &&
                                                Auth::user()->Permission->user_delete == 1)
                                            <li>
                                                <a href="/hierarchical"
                                                    class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                                    <i class="fa-solid fa-building-user mx-2"></i>
                                                    <span class="li-text text-sm">Company structure</span>
                                                </a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                            @if (Auth::user()->Permission->quick_read == 1)
                                <li>
                                    <button type="button"
                                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="dropdown-pages-data-setup"
                                        data-collapse-toggle="dropdown-pages-data-setup">
                                        <i class="fa-regular fa-newspaper"></i>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Data Setup</span>

                                        <i class="fa-solid fa-chevron-down ml-1"></i>
                                    </button>
                                    <ul id="dropdown-pages-data-setup" class="hidden py-2 space-y-2"
                                        aria-expanded="true">





                                        <li>
                                            <a href="/code_mamnual/setup"
                                                class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                                <i class="fa-regular fa-rectangle-list mx-2"></i>
                                                <span class="li-text text-sm">Asset Code Mamnual</span></a>
                                        </li>
                                        <li>
                                            <a href="/code/setup"
                                                class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                                <i class="fa-regular fa-file-code mx-2"></i>
                                                <span class="li-text text-sm">Organizational code</span></a>
                                        </li>
                                        <li>
                                            <a href="/reference/setup"
                                                class="toggle_li flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                                <i class="fa-regular fa-file-zipper mx-2"></i>
                                                <span class="li-text text-sm">Reference Doc</span></a>
                                        </li>

                                    </ul>
                                </li>
                            @endif
                            @if (Auth::user()->role == 'super_admin')
                                <li>
                                    <a href="/admin/change/log/1">
                                        <button type="button"
                                            class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                            <span class="flex-1 ml-3 text-left whitespace-nowrap">Audit trail</span>

                                        </button>
                                    </a>

                                </li>
                            @endif
                            <li>
                                <a href="/admin/assets-ownership/0">
                                    <button type="button"
                                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                        <i class="fa-solid fa-boxes-stacked"></i>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap">My Assets</span>

                                    </button>
                                </a>

                            </li>

                            <li>
                                <a href="/admin/profile">
                                    <button type="button"
                                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">

                                        <i class="fa-solid fa-user-tie"></i>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap">My Profile</span>

                                    </button>
                                </a>

                            </li>

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
            <main id="mainContent" class="pl-0 lg:pl-4  md:pl-4   md:ml-64 min-h-screen pt-20 bg-gray-200 dark:bg-gray-700 transition-all duration-300">
                @yield('content')


            </main>
            </div>

            <div id="show_list" class="bg-white border-b dark:text-slate-50 dark:bg-gray-600 dark:border-gray-300">

            </div>

            </div>
            <!-- Green Toast -->
            <div id="toast_green"
                class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
                role="alert" tabindex="-1">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 fill-green-600 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p id="toast_green_label" class="text-sm text-gray-700 dark:text-neutral-400">Success</p>
                    </div>
                </div>
            </div>

            <!-- Red Toast -->
            <div id="toast_red"
                class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
                role="alert" tabindex="-1">
                <div class="flex p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 fill-rose-600 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ms-3">
                        <p id="toast_red_label" class="text-sm text-gray-700 dark:text-neutral-400">Error</p>
                    </div>
                </div>
            </div>

            </div>
        </main>



        <!-- Flowbite JS -->
        @php
            $auth_toggle = App\Models\User_property::where('type', 'minimize')
                ->where('user_id', Auth::user()->id)
                ->first();
            $shouldMinimize = $auth_toggle->value ?? 0; // adjust "value" to your column
        @endphp
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <!-- Your custom chart/backend JS -->
        <script src="{{ URL('/assets/js/backend_script.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('static-modal');
                if (modal) {
                    const modalInstance = new Modal(modal);
                    modalInstance.show();
                }
            });



            let state_toggle = @json($shouldMinimize); // 1 = expanded, 0 = collapsed


            let sidebar = document.querySelector(".SideBar");
            let main = document.getElementById("mainContent");
            let lis = document.querySelectorAll(".toggle_li");
            let toggleBtn = document.getElementById("sidebarToggle"); // your button with icon
            document.addEventListener("DOMContentLoaded", async () => {
                try {


                    const data = await showLoader(async () => {
                        // simulate some initial async task
                        await new Promise(resolve => setTimeout(resolve, 10));
                        return {
                            message: "Page ready"
                        };
                    });



                    // Collapse sidebar visually
                    sidebar.classList.toggle("collapsed", state_toggle == 0);
                    sidebar.classList.toggle("collapsed", state_toggle == 0);
                    // Update menu items
                    lis.forEach(li => {
                        const textSpan = li.querySelector(".li-text");
                        if (textSpan) textSpan.style.display = state_toggle == 1 ? "inline" :"none" ;
                        li.style.paddingLeft = state_toggle == 1 ? "44px" : "10px";

                    });
                    toggleBtn.style.transform = state_toggle === 0 ? "rotate(0deg)" : "rotate(180deg)";
                    // Move main content according to sidebar width
                    if (main) main.style.marginLeft = state_toggle == 1 ? "16rem" : "70px";


                } catch (err) {
                    console.error(err);
                }
            });




            function toggleFullScreen() {
                state_toggle = state_toggle == 0 ? 1 : 0;

                // Collapse sidebar visually
                sidebar.classList.toggle("collapsed", state_toggle === 0);

                // Update menu items
                lis.forEach(li => {
                    const textSpan = li.querySelector(".li-text");
                    if (textSpan) textSpan.style.display = state_toggle == 1 ? "inline" : "none";
                    li.style.paddingLeft = state_toggle == 1 ? "44px" : "10px";
                });

                // Rotate icon
                if (toggleBtn) {
                    toggleBtn.style.transition = "transform 0.5s ease-in-out";
                    toggleBtn.style.transform = state_toggle === 0 ? "rotate(0deg)" : "rotate(180deg)";
                }
                // Move main content according to sidebar width
                if (main) main.style.marginLeft = state_toggle == 1 ? "16rem" : "70px";

                // Optional: save preference
                console.log(state_toggle);
                // Toggle the state first

                change_toggle(state_toggle);
            }









            const rows = document.querySelectorAll("#myTable tr");

            rows.forEach(tr => {
                tr.addEventListener("click", () => {
                    // Remove "active" class from all rows
                    rows.forEach(r => r.classList.remove("active"));
                    // Add "active" class to clicked row
                    tr.classList.add("active");
                });
            });

            let auth = @json(Auth::user());

            let toast_red = document.getElementById('toast_red');
        </script>

    </body>

    </html>
