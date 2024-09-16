@extends('backend.master')
@section('content')

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
    




    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr id="user_th">
                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('id','int','quick')">
                        User Name  &ensp; <i class="fa-solid fa-sort"></i>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email &ensp; <i class="fa-solid fa-sort"></i>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role &ensp; <i class="fa-solid fa-sort"></i>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status &ensp; <i class="fa-solid fa-sort"></i>
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>

                </tr>
            </thead>
            <tbody>

                @if (!empty($user))
                    @foreach ($user as $item)
                        @if (Auth::user()->id == $item->id)
                            <tr class="bg-green-300 border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->fname . ' ' . $item->lname }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->email }}
                                </td>
                                <td class="px-6 py-4">
                                    Admin
                                </td>
                                <td class="px-6 py-4">
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

                                <td class="px-6 py-4">
                                    @if (Auth::user()->Permission->user_update == 1)
                                        <a href="/admin/user/update/id={{ $item->id }}">
                                            <button type="button"
                                                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                    class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
                                        </a>
                                    @endif
                                    @if (
                                        (Auth::user()->Permission->user_write == 0 && Auth::user()->Permission->user_update == 0) ||
                                            (Auth::user()->Permission->user_write == 1 && Auth::user()->Permission->user_update == 0))
                                        <button type="button"
                                            class="text-white bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                        </button>
                                    @endif
                                    @if (Auth::user()->Permission->user_delete == 1)
                                        <button type="button" data-id="{{ $item->id }}"
                                            onclick="delete_value('btn_delete'+{{ $item->id }},'delete_user','delete_value')"
                                            id="btn_delete{{ $item->id }}"
                                            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-trash" style="color: #ffffff;"></i>

                                        </button>
                                    @endif


                                </td>

                            </tr>
                        @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->fname . ' ' . $item->lname }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->email }}
                                </td>
                                <td class="px-6 py-4">
                                    Admin
                                </td>
                                <td class="px-6 py-4">
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

                                <td class="px-6 py-4">
                                    @if (Auth::user()->Permission->user_update == 1)
                                        <a href="/admin/user/update/id={{ $item->id }}">
                                            <button type="button"
                                                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                    class="fa-solid fa-pen-to-square"
                                                    style="color: #ffffff;"></i></button>
                                        </a>
                                    @endif
                                    @if (
                                        (Auth::user()->Permission->user_write == 0 && Auth::user()->Permission->user_update == 0) ||
                                            (Auth::user()->Permission->user_delete == 1 && Auth::user()->Permission->user_update == 0))
                                        <button type="button"
                                            class="text-white bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                        </button>
                                    @endif
                                    @if (Auth::user()->Permission->user_delete == 1)
                                        <button type="button" data-id="{{ $item->id }}"
                                            onclick="delete_value('btn_delete'+{{ $item->id }},'delete_user','delete_value')"
                                            id="btn_delete{{ $item->id }}"
                                            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-trash" style="color: #ffffff;"></i>

                                        </button>
                                    @endif


                                </td>

                            </tr>
                        @endif
                    @endforeach
                @endif


            </tbody>
        </table>
    </div>



@endsection
