@extends('backend.master')
@section('content')



    <!-- Small Modal -->
    <div id="small-modal" tabindex="-1"
        class="fixed  hidden w-80 p-4 overflow-x-hidden overflow-y-auto  h-[calc(100%-1rem)]  max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Edit Data
                    </h3>
                
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form action="/admin/quick/data/update/submit" method="post">
                        @csrf
                        <span
                        class="block mb-5 text-sm font-medium text-gray-900 dark:text-white">Content</span>
                 
                                <input type="text" id="id_update"
                                    class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="id" required />
                                <input type="text" id="content_update"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="content" required />
                                <br>
                                <span
                                    class="block mb-5 text-sm font-medium text-gray-900 dark:text-white">Type </span>
                                        <select id="type_update" name="type" onchange="change_department()"
                                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value=""></option>
                                            <option value="Department">Department</option>
                                            <option value="Company">Company</option>
                                            <option value="Employee">Employee</option>
                                        </select>
                                <br>
                                <span id="span_reference"
                                class="block mb-5 text-sm font-medium text-gray-900 dark:text-white">References</span>
                                
                                <select name="reference_update" id="reference_update" 
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>
                                @if(!empty($department))
                                    @foreach($department as $item)
                                        <option value="{{$item->content}}">{{$item->content}}</option>
                                    @endforeach
                                @endif
                            </select>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-5  border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="text-white  mr-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>

                    <button type="button" data-modal-hide="small-modal" onclick="close_modal()"
                        class="text-white   bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Cancel</button>

                </div>
                </form>
            </div>
        </div>
    </div>

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











    <div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
        <form class="p-4 py-4 dark:bg-gray-900" action="/quick/data/add" method="POST">
            @csrf
            <h1 class="title_base dark:text-blue-100">Quick Data</h1>
            <div class="grid gap-2  grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
                <div>
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content <span
                            class="text-rose-500">*</span></label>
                    <input type="content" id="content"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="content" required />
                </div>

                <div>
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type <span
                            class="text-rose-500">*</span></label>
                    <select id="type" name="type" required onchange="change_type()"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        <option value="Department">Department</option>
                        <option value="Company">Company</option>
                        <option value="Employee">Employee</option>
                    </select>
                    <div id="dep_user">
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee Department <span
                                class="text-rose-500">*</span></label>
                                <select id="type" name="department_employee" 
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>
                                @if(!empty($department))
                                    @foreach($department as $item)
                                        <option value="{{$item->content}}">{{$item->content}}</option>
                                    @endforeach
                                @endif
                            </select>
                    </div>
                </div>
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
                        class="mx-2 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                    </button>
                </div>
              
                @if (!empty($total_page))
                    @if($total_page > 1)
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
                    <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Page :{{ $total_page }} Pages
                        &ensp;Total Assets: {{ $total_record}} Records</span>
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
                            <th scope="col"  class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2" onclick="dynamic_sort('id','int','quick')">
                                ID &ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col"  class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2" onclick="dynamic_sort('content','string','quick')">
                                Content&ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col"  class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2" onclick="dynamic_sort('type','string','quick')">
                                Type&ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col"  class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2" onclick="dynamic_sort('reference','string','quick')">
                                Reference&ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col" class="last_th px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 text-gray-900 whitespace-nowrap dark:text-white"
                                style="position: sticky; right: 0;  z-index:1;">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body_quick_data">
                        @if (!empty($data))
                            @foreach ($data as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->id }}
                                    </td>
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->content }}
                                    </td>
                                    <td scope="row"
                                        class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->type }}
                                    </td>
                                    <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
             
                                        {{ $item->reference }}
                                </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   text-gray-900 whitespace-nowrap dark:text-white"
                                    style="  position: sticky; right: 0;">


                                  
                                        <button type="button" 
                                            onclick="update_quick_data({{ $item }})"
                                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                        <!-- Modal toggle -->


                                        <button type="button" data-id="{{ $item->id }}"
                                            id="btn_delete{{ $item->id }}"
                                            onclick="delete_value('btn_delete'+{{ $item->id }},'delete_data','delete_data_value')"
                                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


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
