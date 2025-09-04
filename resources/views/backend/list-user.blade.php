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





<div class="relative overflow-x-auto min-h-96 bg-white">
    <table id="table_user" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr id="user_th">
                <th scope="col"
                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    onclick="dynamic_sort('id','int','users')">
                    ID &ensp;
                </th>
                <th scope="col"
                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    onclick="dynamic_sort('name','string','users')">
                    User Name &ensp;
                </th>
                <th scope="col"
                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    onclick="dynamic_sort('email','string','users')">
                    Email &ensp;
                </th>
                <th scope="col"
                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    onclick="dynamic_sort('role','string','users')">
                    Role &ensp;
                </th>
                <th scope="col"
                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    onclick="dynamic_sort('status','int','users')">
                    Status &ensp;
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
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                {{ $item->email }}
                            </td>
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                {{ $item->role }}
                            </td>
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
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

                            <td class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

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
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                {{ $item->email }}
                            </td>
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                {{ $item->role }}
                            </td>
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
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
                            <td class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">

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
<script>
    //   let array = @json($user);
    //   let sort_state = 0;
</script>


@endsection
