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
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="small-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form action="/admin/quick/data/update/submit" method="post">
                        @csrf
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content
                            <span>
                                <input type="text" id="id_update"
                                class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="id" required />
                                <input type="text" id="content_update"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="content" required />
                                <br>
                                <label for="type_update"
                                    class="block mb-5 text-sm font-medium text-gray-900 dark:text-white">Type <span>
                                        <select id="type_update" name="type" required
                                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value=""></option>
                                            <option value="Department">Department</option>
                                            <option value="Company">Company</option>

                                        </select>
                    
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-5  border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button  type="submit"
                        class="text-white  mr-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>

                    <button type="button" data-modal-hide="small-modal"
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
        <form class="p-10 py-10 dark:bg-gray-900" action="/quick/data/add" method="POST">
            @csrf
            <h1 class="title_base dark:text-blue-100">Asset Info</h1>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
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
                    <select id="type" name="type" required
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        <option value="Department">Department</option>
                        <option value="Company">Company</option>

                    </select>
                </div>

            </div>
            <div class="btn_float_right">
                <button type="submit"
                    class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>

        </form>
        <div class="table-data  max-w-full relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
            <div class="grid  mb-6 md:grid-cols-1">
                <table
                    class="table_respond max-w-full  mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr id="quick_tr_header" >
                            <th scope="col" class="px-6 py-3" onclick="dynamic_sort('id','int','quick')">
                                ID &ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col" class="px-6 py-3" onclick="dynamic_sort('content','string','quick')">
                                Content&ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col" class="px-6 py-3" onclick="dynamic_sort('type','string','quick')">
                                Type&ensp; <i class="fa-solid fa-sort"></i>
                            </th>
                            <th scope="col" class="px-6 py-3"
                                style="  position: sticky; right: 0;   background-color: rgb(230, 230, 230);">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="body_quick_data">
                        @if (!empty($data))
                            @foreach ($data as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->id }}
                                    </td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->content }}
                                    </td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->type }}
                                    </td>
                                    <td scope="row"
                                        class=" px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">


                                        <button type="button" data-modal-target="small-modal"
                                            data-modal-toggle="small-modal"
                                            onclick="update_quick_data({{ $item }})"
                                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                        <!-- Modal toggle -->


                                        <button type="button" data-id="{{  $item->id  }}"
                                            id="btn_delete{{  $item->id  }}"
                                            onclick="delete_value('btn_delete'+{{  $item->id  }},'delete_data','delete_data_value')"
                                            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
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
             let array  = @json($data);
            let sort_state = 0;


        </script>
    @endsection
