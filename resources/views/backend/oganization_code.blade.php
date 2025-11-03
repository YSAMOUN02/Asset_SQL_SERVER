@extends('backend.master')
@section('content')
@section('header')
    Asset Code
@endsection

@section('style')
    <span class="mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">
            Asset Code Management
        </span>
    </span>
@endsection


<div class="bg-white p-4 rounded-lg shadow-md dark:bg-gray-800">
        @if (Auth::user()->Permission->quick_write == 1)
    <form method="POST" action="/code/add/submit" class="mb-4">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                <input type="text" oninput="validateInputField(this,5)" id="first_name" name="code"
                    class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                    required />
                <button type="submit"
                    class="text-white mt-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </div>
            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="last_name" oninput="validateInputField(this,50)" name="name"
                    class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required />

            </div>

        </div>
    </form>
    @endif
    <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
        <div class="scroll-container">
            <table id="list_assets"
                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr   tabindex="0">

                        <th scope="col" class="text-black  dark:text-white ">
                            ID &ensp;
                        </th>

                        <th scope="col" class="text-black  dark:text-white ">
                            Code
                        </th>
                        <th scope="col" class="text-black  dark:text-white ">
                            Name
                        </th>
                        <th scope="col" class="text-black  dark:text-white ">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="assets_body">
                    @foreach ($Asset_code as $code)
                        <tr   tabindex="0"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="text-black  dark:text-white ">
                                {{ $code->id }}
                            </td>

                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 text-black  dark:text-white ">
                                {{ $code->code }}
                            </td>
                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 text-black  dark:text-white ">
                                {{ $code->name }}
                            </td>
                            <td class="flex px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 text-black  dark:text-white ">
                                <!-- Modal toggle -->
                                @if (Auth::user()->Permission->quick_update == 1)
                                    <button data-modal-target="static-modal{{ $code->id }}"
                                        data-modal-toggle="static-modal{{ $code->id }}"
                                        class="block text-white bg-blue-700 hover:bg-blue-800 mx-2 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-1 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        Update
                                    </button>
                                @endif
                                @if (Auth::user()->Permission->quick_delete == 1)
                                    <button data-modal-target="popup-modal-delete{{ $code->id }}"
                                        data-modal-toggle="popup-modal-delete{{ $code->id }}"
                                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-1 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                        type="button">
                                        Delete
                                    </button>
                                @endif
                            </td>
                            @if (Auth::user()->Permission->quick_update == 1)
                                <!-- Main modal -->
                                <div id="static-modal{{ $code->id }}" data-modal-backdrop="static" tabindex="-1"
                                    aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <form method="POST" action="/code/update/submit">
                                                @csrf
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Update Asset Code
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="static-modal{{ $code->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5 space-y-4">

                                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                                        <div>
                                                            <input type="text" class="hidden"
                                                                value="{{ $code->id }}" name="id" />
                                                            <label for="code{{ $code->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                                                            <input type="text" oninput="validateInputField(this,5)"
                                                                id="code{{ $code->id }}"
                                                                value="{{ $code->code }}" name="code"
                                                                 class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                required />

                                                        </div>
                                                        <div>
                                                            <label for="name{{ $code->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                            <input type="text" id="name{{ $code->id }}"
                                                                value="{{ $code->name }}" name="name"
                                                                class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                required oninput="validateInputField(this,50)" />

                                                        </div>

                                                    </div>

                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                    <button type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
                                                    <button data-modal-hide="static-modal{{ $code->id }}"
                                                        type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                                                </div>
                                            </form>






                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (Auth::user()->Permission->quick_delete == 1)
                                <div id="popup-modal-delete{{ $code->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="popup-modal-delete{{ $code->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Are you sure you want to delete this Code?</h3>
                                                <form action="/code/delete/submit" method="POST">
                                                    @csrf
                                                    <input type="text" class="hidden" value="{{ $code->id }}"
                                                        name="id" />

                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Confirm
                                                    </button>
                                                </form>

                                                <button data-modal-hide="popup-modal-delete{{ $code->id }}"
                                                    type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                                    cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>















@endsection
