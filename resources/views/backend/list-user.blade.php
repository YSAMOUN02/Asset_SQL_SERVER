@extends('backend.master')
@section('content')


@section('header')
    List User Data
@endsection
@section('style')
    <span class="ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Users List</span>
    </span>
@endsection
<div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
    <div class="search-bar bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <form action="/admin/assets/add/search" method="POST">
            @csrf
            <div class="max-w-full min-h-full grid px-2 py-1 gap-1 lg:gap-2  grid-cols-3 lg:grid-cols-4 md:grid-cols-2">
                <div>
                    <label for="id_asset" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID</label>

                    <input type="number" id="id_asset" name="assets"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="assets" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">User
                        Name</label>

                    <input type="text" id="assets" name="assets"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="fa" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">ID
                        Card</label>

                    <input type="text" id="fa" name="fa"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="invoice"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Position</label>

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
                    <label for="state"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                    <select id="state" name="state"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="All">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>
                <div>
                    <label for="state"
                        class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="state" name="state"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 lg:p-2.5 md:p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="All">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>
            </div>
            <div
                class="max-w-full items-center flex  justify-between px-2 mt-1 lg:mt-2 py-1 lg:py-2 sm:grid sm:grid-cols-1">
                <div class="flex main_page justify-between items-center">

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
                       
                            <span class="font-bold flex justify-center items-center dark:text-slate-50">Page
                                :{{ $total_page }} Pages
                                &ensp;Total Transaction: {{ $total_record }} Records</span>
                        </div>

                    </div>

                    <div class="flex fix_button">




                        <button type="button"
                        {{-- onclick="search_asset(0)" --}}
                         id="search_item" onclick="{alert('New Feature Under Development')}"
                            class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                        </button>




                    </div>
                </div>


            </div>

        </form>




    </div>

    <div id="delete_user"
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
                <div class="mb-2 text-sm font-normal">This user will be delete.</div>
                <form action="/admin/user/delete/submit" method="POST">
                    @csrf
                    <input type="text" name="id" id="delete_value" class="hidden">
                    <div class="grid grid-cols-2 gap-2">

                        <div>

                            <button
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                                type="submit">Yes</button>
                        </div>
                        <div>
                            <button onclick="cancel_toast('delete_user')" type="button"
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <div class="table-data mt-3  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
        <div class="scroll-container">
            <table id="table_user" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr id="user_th">
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ID
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            User Name
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Company
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Department
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Division
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Section
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Group
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Email
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Role
                        </th>
                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Status
                        </th>

                        <th scope="col"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody id="user_tb">

                    @if (!empty($user))
                        @foreach ($user as $item)
                            @if (Auth::user()->id == $item->id)
                                <tr class="bg-green-300 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->id }}
                                    </td>
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->fname . ' ' . $item->lname }}
                                    </td>
                                    <td>
                                        {{ $item->company->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->department->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->division->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->section->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->group->name ?? '' }}
                                    </td>

                                    <td>
                                        {{ $item->email }}
                                    </td>

                                    <td>
                                        {{ $item->role }}
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Inactive
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Active
                                            </span>
                                        @endif

                                    </td>

                                    <td
                                        class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                        <div class="option">
                                            <button id="dropdownMenuIconHorizontalButton{{ $item->id }}"
                                                data-dropdown-toggle="dropdownDotsHorizontal{{ $item->id }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-center   bg-white text-black rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <i class="fa-solid fa-gear"></i>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsHorizontal{{ $item->id }}"
                                                class="option_dark hidden  bg-white border-b dark:bg-gray-800 dark:border-gray-700   rounded-lg shadow-sm w-44 ">

                                                <ul class="py-2 text-sm  bg-white text-black   dark:text-gray-200">
                                                    @if (Auth::user()->Permission->user_update == 1)
                                                        <li>
                                                            <a href="/admin/user/update/id={{ $item->id }}"
                                                                class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:hover:bg-gray-100 dark:hover:text-white">Update</a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="/admin/user/view/id={{ $item->id }}"
                                                            class="block px-4 py-2 hover:bg-gray-200 bg-white text-black dark:hover:bg-gray-100 dark:hover:text-white">View</a>
                                                    </li>


                                                </ul>
                                            </div>
                                    </td>

                                </tr>
                            @else
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->id }}
                                    </td>
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->fname . ' ' . $item->lname }}
                                    </td>
                                    <td>
                                        {{ $item->company->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->department->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->division->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->section->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->group->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                    <td>
                                        {{ $item->role }}
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Inactive
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class=" w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Active
                                            </span>
                                        @endif

                                    </td>
                                    <td
                                        class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

                                        <div class="option">
                                            <button id="dropdownMenuIconHorizontalButton{{ $item->id }}"
                                                data-dropdown-toggle="dropdownDotsHorizontal{{ $item->id }}"
                                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                type="button">
                                                <i class="fa-solid fa-gear"></i>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div id="dropdownDotsHorizontal{{ $item->id }}"
                                                class="option_dark hidden bg-white border dark:bg-gray-800 dark:border-gray-700 rounded-lg shadow-lg min-w-[11rem]">

                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 ">
                                                    @if (Auth::user()->Permission->user_update == 1)
                                                        <li>
                                                            <a href="/admin/user/update/id={{ $item->id }}"
                                                                class="block px-4 py-2 hover:bg-gray-300 dark:hover:bg-gray-100  bg-white text-black ">
                                                                Update
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="/admin/user/view/id={{ $item->id }}"
                                                            class="block px-4 py-2 hover:bg-gray-300 dark:hover:bg-gray-100  bg-white text-black">
                                                            View
                                                        </a>
                                                    </li>

                                                    @if (Auth::user()->Permission->user_delete == 1)
                                                        <li type="button" data-id="{{ $item->id }}"
                                                            onclick="delete_value('btn_delete'+{{ $item->id }},'delete_user','delete_value')"
                                                            id="btn_delete{{ $item->id }}">
                                                            <div
                                                                class="cursor-pointer block px-4 py-2 hover:bg-gray-200  bg-white text-black ">
                                                                Delete
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif


                </tbody>
            </table>
        </div>
    </div>
    <script>
        //   let array = @json($user);
        //   let sort_state = 0;
    </script>


@endsection
