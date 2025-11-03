@extends('backend.master')
@section('content')
@section('header')
    Mamnual Assets Code
@endsection

@section('style')
    <span class="mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">
            Mamnual Assets Code
        </span>
    </span>
@endsection
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/flatpickrdark.min.css') }}">
<div class="bg-white p-4 rounded-lg shadow-md dark:bg-gray-800">

    @if (Auth::user()->Permission->quick_write == 1)
        <form method="POST" action="/code_mamnual/add/submit" class="mb-4">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-6">
                <div>
                    <label for="code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                    <input type="text" oninput="validateInputField(this,20)" id="code" name="code"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                    <button type="submit"
                        class="text-white mt-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
                <div>
                    <label for="no"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No</label>
                    <input type="number" id="no" name="no" min="1" max="10000" step="1"
                        oninput="validateInputFieldNum(this)"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"


                        required />
                </div>
                <div>
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">For</label>
                    <input type="text" id="name" oninput="validateInputField(this,100)" name="name"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />

                </div>

                <div>
                    <label for="start"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start</label>
                    <input type="text" id="start" name="start"
                       class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>
                <div>
                    <label for="end"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End</label>
                    <input type="text" id="end" name="end"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>

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
                            For
                        </th>

                        <th scope="col" class="text-black  dark:text-white ">
                            Start Date
                        </th>
                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 text-black  dark:text-white ">
                            End Date
                        </th>

                        <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 text-black  dark:text-white ">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="assets_body">
                    @foreach ($mamnual_code as $item)
                        <tr   tabindex="0"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="text-black  dark:text-white ">
                                {{ $item->id }}
                            </td>

                            <td class="text-black  dark:text-white ">
                                {{ $item->code . str_pad($item->no, 3, '0', STR_PAD_LEFT) }}
                            </td>


                            <td class="text-black  dark:text-white ">
                                {{ $item->name }}
                            </td>

                            <td class="text-black  dark:text-white ">

                                {{ \Carbon\Carbon::parse($item->start)->format('d-M-Y') ?? '' }}
                            </td>
                            <td class="text-black  dark:text-white ">

                                {{ \Carbon\Carbon::parse($item->end)->format('d-M-Y') ?? '' }}
                            </td>
                            <td class="flex text-black  dark:text-white ">
                                @if (Auth::user()->Permission->quick_update == 1)
                                    <!-- Modal toggle -->
                                    <button data-modal-target="static-modal{{ $item->id }}"
                                        data-modal-toggle="static-modal{{ $item->id }}"
                                        class="block text-white bg-blue-700 hover:bg-blue-800 mx-2 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-1 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        Update
                                    </button>
                                @endif
                                @if (Auth::user()->Permission->quick_delete == 1)
                                    <button data-modal-target="popup-modal-delete{{ $item->id }}"
                                        data-modal-toggle="popup-modal-delete{{ $item->id }}"
                                        class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-1 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                        type="button">
                                        Delete
                                    </button>
                                @endif
                            </td>
                            @if (Auth::user()->Permission->quick_update == 1)
                                <!-- Main modal -->
                                <div id="static-modal{{ $item->id }}" data-modal-backdrop="static" tabindex="-1"
                                    aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <form method="POST" action="/code_mamnual/update/submit">
                                                @csrf
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Update Code
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="static-modal{{ $item->id }}">
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
                                                                value="{{ $item->id }}" name="id" />
                                                            <label for="code{{ $item->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                                                            <input type="text"
                                                                oninput="validateInputField(this,20)"
                                                                id="code{{ $item->id }}"
                                                                value="{{ $item->code }}" name="code"
                                                                 class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                required />

                                                        </div>
                                                        <div>
                                                            <label for="name{{ $item->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No</label>
                                                            <input type="text" id="name{{ $item->id }}"
                                                                value="{{ $item->no }}" name="no"
                                                                 class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                required type="number" id="no" name="no"
                                                                min="1" max="10000" step="1"
                                                                oninput="validateInputFieldNum(this)" />

                                                        </div>
                                                        <div>
                                                            <label for="name{{ $item->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">For</label>
                                                            <input type="text" id="name{{ $item->id }}"
                                                                value="{{ $item->name }}" name="name"
                                                                 class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                required oninput="validateInputField(this,100)" />

                                                        </div>

                                                        <div>
                                                            <label for="start{{ $item->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End</label>
                                                            <input type="text" id="start{{ $item->id }}"
                                                                name="start" value="{{ $item->start }}"
                                                                 class="date bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>

                                                        </div>
                                                        <div>
                                                            <label for="end{{ $item->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End</label>
                                                            <input type="text" id="end{{ $item->id }}"
                                                                name="end" value="{{ $item->end }}"
                                                                 class="date bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                                                        </div>

                                                    </div>

                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                    <button type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
                                                    <button data-modal-hide="static-modal{{ $item->id }}"
                                                        type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                                                </div>
                                            </form>






                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (Auth::user()->Permission->quick_delete == 1)
                                <div id="popup-modal-delete{{ $item->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="popup-modal-delete{{ $item->id }}">
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
                                                <form action="/code_mamnual/delete/submit" method="POST">
                                                    @csrf
                                                    <input type="text" class="hidden" value="{{ $item->id }}"
                                                        name="id" />

                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Confirm
                                                    </button>
                                                </form>

                                                <button data-modal-hide="popup-modal-delete{{ $item->id }}"
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






@php
    $first_day = \Carbon\Carbon::parse(today()->startOfYear())->format('Y-m-d');
    $end_day = \Carbon\Carbon::parse(today()->endOfYear())->format('Y-m-d');
@endphp

<script>
    let date = new Date("{{ $first_day }}");

    flatpickr("#start", {
        altInput: true, // show pretty date
        altFormat: "d-M-Y", // display format
        dateFormat: "Y-m-d", // value submitted to backend
        defaultDate: "{{ $first_day }}"
    });
    flatpickr("#end", {
        altInput: true, // show pretty date
        altFormat: "d-M-Y", // display format
        dateFormat: "Y-m-d", // value submitted to backend
        defaultDate: "{{ $end_day }}"
    });
    flatpickr(".date", {
        altInput: true, // show pretty date
        altFormat: "d-M-Y", // display format
        dateFormat: "Y-m-d", // value submitted to backend

    });

    function validateInputFieldNum(input) {
        let value = input.value;

        // Remove decimals
        value = value.replace(/\D/g, ""); // keep only digits

        // Remove leading zeros
        value = value.replace(/^0+/, "");

        // Limit to max 10000
        if (value !== "" && parseInt(value) > 10000) {
            value = "10000";
        }

        input.value = value;
    }
</script>
@endsection
