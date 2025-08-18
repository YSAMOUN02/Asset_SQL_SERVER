@extends('backend.master')
@section('content')


    <div id="delete_data"
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
                <form action="/admin/quick/data/delete/submit" method="POST">
                    @csrf
                    <input type="text" name="id" id="delete_data_value" class="hidden">
                    <div class="grid grid-cols-2 gap-2">

                        <div>

                            <button
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-lime-600 rounded-lg hover:bg-lime-950 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800"
                                type="submit">Yes</button>
                        </div>
                        <div>
                            <button onclick="cancel_toast('delete_data')" type="button"
                                class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-rose-600 border border-gray-300 rounded-lg hover:bg-rose-950 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800 ">
        <form class="p-4 py-4 bg-white  dark:bg-gray-900" action="/quick/data/add" method="POST">
            @csrf
            <h1 class="title_base text-black  dark:text-blue-100">Data Setup</h1>
            <div class="grid gap-2  grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
                <div>
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company<span
                            class="text-rose-500">*</span></label>
                    <input type="content" id="content"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="content" required />
                </div>

                <div></div>
                <div class="flex items-center">
                    <select id="type_search"
                        class= "w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="id">ID</option>
                        <option value="content">Content</option>
                        <option value="type">Type</option>
                    </select>
                    <input placeholder="Search.." type="text" id="content_search"
                        class= "w-44 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <button type="button" onclick="search_quick_data({{ $page }})"
                        class="mx-2 text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                    </button>
                </div>

                @if (!empty($total_page))
                    @if ($total_page > 1)
                        <div class="flex pagination_by_search">

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
                                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                                                    class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $i }}"
                                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    {{-- Next Button --}}
                                    @if ($page != $total_page)
                                        <li>
                                            <a href="{{ $page + 1 }}"
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </nav>

                            <select onchange="set_page_quick_data()" id="select_page"
                                class="flex mx-2 items-center justify-center px-3 h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                name="" id="">
                                @if ($page != 1)
                                    <option value="{{ $page }}">{{ $page }}</option>
                                @else
                                    <option value="">More</option>
                                @endif
                                {{-- Page Numbers in Ascending Order --}}
                                @for ($i = 1; $i <= $total_page; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor

                            </select>
                        </div>
                    @else
                        <div></div>
                    @endif
                @endif
                <div id="total_state">
                    <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Page
                        :{{ $total_page }} Pages
                        &ensp;Total Data: {{ $total_record }} Records</span>
                </div>
            </div>
            <div class="btn_float_right z-50">
                <button type="submit"
                    class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>

        </form>
        <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
            <div class="grid  mb-6 md:grid-cols-1">
                <table id="table_quick_data"
                    class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr id="quick_tr_header">
                            <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                                onclick="dynamic_sort('id','int','quick')">
                                ID &ensp;
                            </th>
                            <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                                onclick="dynamic_sort('content','string','quick')">
                                Company&ensp;
                            </th>
                            <th scope="col" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2"
                                onclick="dynamic_sort('content','string','quick')">
                                Department&ensp;
                            </th>

                        </tr>
                    </thead>
                    <tbody id="body_quick_data">
                        @foreach ($data as $company)
                            @php
                                $count_department = count($company->Departments);

                            @endphp

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row"
                                    @if ($count_department > 1) rowspan="{{ $count_department + 1 }}" @endif
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $company->id }}
                                </td>
                                <td scope="row"
                                    @if ($count_department > 1) rowspan="{{ $count_department + 1 }}" @endif
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">


                                    <!-- Modal toggle -->
                                    <button data-modal-target="crud-modal{{ $company->id }}"
                                        data-modal-toggle="crud-modal{{ $company->id }}"
                                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        {{ $company->name }}
                                    </button>

                                    <!-- Main modal -->
                                    <div id="crud-modal{{ $company->id }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-2 md:p-2 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                          Department in {{ $company->name }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-toggle="crud-modal{{ $company->id }}">
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
                                                <form>
                                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                                        <div class="col-span-2 p-2">

                                                            <table
                                                                class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <span class="flex items-center">
                                                                                ID
                                                                            </span>
                                                                        </th>
                                                                        <th>
                                                                            <span class="flex items-center">
                                                                                Department
                                                                            </span>
                                                                        </th>
                                                                        <th>
                                                                            <span class="flex items-center">
                                                                                Action
                                                                            </span>
                                                                        </th>
                                                                    </tr>

                                                                </thead>
                                                                <tbody id="body_department{{ $company->id }}">
                                                                    @php
                                                                        $ic = 0;
                                                                    @endphp
                                                                    @foreach ($company->Departments as $department)
                                                                        <tr class="mt-2 border-gray-600">
                                                                            <td
                                                                                class="font-medium text-gray-900 whitespace-nowrap dark:text-white p-1">
                                                                                {{ $department->id }}
                                                                            </td>
                                                                            <td
                                                                                class="font-medium text-gray-900 whitespace-nowrap dark:text-white p-1">
                                                                                {{ $department->name }}
                                                                            </td>
                                                                            <td class="p-1">
                                                                                <button type="button"
                                                                                    onclick="delete_department({{ $department->id }})"><i
                                                                                        class="fa-solid fa-trash"
                                                                                        style="color: #ff0000;"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="p-2">
                                                        <input type="text" id="name_department{{ $company->id }}"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                            class="px-5 py-2.5">
                                                        <button type="button"
                                                            onclick="add_department({{ $company->id }})"
                                                            class=" text-white  w-full flex items-center justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            Add New

                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($count_department == 1)
                                <td
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   text-gray-900 whitespace-nowrap dark:text-white">
                                    <span class="badge badge-primary">{{ $company->Departments[0]->name }}</span>


                                </td>
                        @endif
                        </td>

                        </tr>
                        @if ($count_department > 1)
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($company->Departments as $department)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   text-gray-900 whitespace-nowrap dark:text-white">

                                        <!-- Modal toggle -->
                                        <button data-modal-target="default-modal-department{{ $department->id }}"
                                            data-modal-toggle="default-modal-department{{ $department->id }}"
                                            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button">
                                            {{ $department->name }}
                                        </button>

                                    </td>
                                </tr>




                                <!-- Main modal -->
                                <div id="default-modal-department{{ $department->id }}" tabindex="-1"
                                    aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Locations in {{ $department->name }}
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="default-modal-department{{ $department->id }}">
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
                                                <form>
                                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                                        <div class="col-span-2 p-2">

                                                            <ul
                                                                class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                                                                <li class="pb-3 sm:pb-4">
                                                                    <div
                                                                        class="flex items-center space-x-4 rtl:space-x-reverse">

                                                                        <div class="flex-1 min-w-0">
                                                                            <p
                                                                                class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                                                Neil Sims
                                                                            </p>
                                                                            <p
                                                                                class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                                                email@flowbite.com
                                                                            </p>
                                                                        </div>
                                                                        <div
                                                                            class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                                            $320
                                                                        </div>
                                                                    </div>
                                                                </li>

                                                            </ul>


                                                        </div>
                                                    </div>
                                                    <div class="p-2">
                                                        <input type="text" id="name_location{{ $company->id }}"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                            class="px-5 py-2.5">
                                                        <button type="button"
                                                            onclick="add_location({{ $company->id }})"
                                                            class=" text-white  w-full flex items-center justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            Add New

                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            </form>
        </div>








        <script>
            let array = @json($data);

            let sort_state = 0;
        </script>
    @endsection
