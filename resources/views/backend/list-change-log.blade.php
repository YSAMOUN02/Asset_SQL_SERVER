@extends('backend.master')
@section('content')


    <div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
        <div id="search_bar" class="search-bar sm:grid-cols-2 bg-white border-b dark:bg-gray-800 dark:border-gray-700">

            <form action="/admin/change/log/search" method="POST">
                @csrf
                <div class="max-w-full min-h-full grid px-5 py-3 gap-4 grid-cols-4">
                    <div>
                        <label for="key" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                            Key ID
                        </label>
                        <input type="number" id="key" name="key"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="varaint" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                            Varaint
                        </label>

                        <input type="number" id="varaint" name="varaint"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="change" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Change
                            Detail</label>

                        <input type="text" id="change" name="change"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="section"
                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Section</label>

                        <select name="section" id="section"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=""></option>
                            <option value="User Record">User Section</option>
                            <option value="	Asset Record">Assets Section</option>
                        </select>
                    </div>
                    <div>
                        <label for="chang_by" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                            Change By
                        </label>
                        <select name="chang_by" id="chang_by"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=""></option>
                            @if (!empty($change_by))
                                @foreach ($change_by as $item)
                                    <option value="{{ $item->change_by }}">{{ $item->change_by }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start
                            from
                            date (Change Date)</label>

                        <input type="date" id="start_date" value="{{ $start_date }}" name="start_date" name="end_date"
                            onchange="check_date()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="......." />

                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To date
                            (Change Date)</label>

                        <input type="date" id="end_date" value="{{ $end_date }}" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>




                </div>
                <div class="max-w-full flex justify-between px-5">
                    <div class="pagination_by_search defualt">
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
                                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </a>
                                    </li>
                                @endif
                    
                                {{-- Page Numbers in Ascending Order --}}
                                @for ($i = $left_limit; $i <= $right_limit; $i++) {{-- Loop from left to right in ascending order --}}
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
                        
                    @endif
                    
                    </div>
               
                 
                   
                    <button type="button" onclick="search_change_log(0)"
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                            class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                    </button>
                </div>
            </form>

        </div>

        <div class="table-data relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
            <table id="table_change_log"
                class=" w-full mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('id','int','changelog')">
                            Entry &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('key','int','changelog')">
                            Key ID &ensp;<i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('varaint','int','changelog')">
                            Varaint &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('change','string','changelog')">
                            Change Detail &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('section','string','changelog')">
                            Section &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('change_by','string','changelog')">
                            Change By &ensp; <i class="fa-solid fa-sort"></i>
                        </th>

                        <th scope="col" class="px-6 py-3" onclick="dynamic_sort('created_at','date','changelog')">
                            Date &ensp; <i class="fa-solid fa-sort"></i>
                        </th>
                        {{-- <th scope="col" class="px-6 py-3"
                        style="  position: sticky; right: 0;   background-color: rgb(230, 230, 230);">
                        Action
                    </th> --}}
                    </tr>
                </thead>
                <tbody id="table_body_change">
                    @foreach ($changeLog as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ $item->id }}
                            </td>
                            <td class="px-6 py-4">{{ $item->key }}
                            </td>
                            <td class="px-6 py-4">{{ $item->varaint }}
                            </td>
                            <td class="px-6 py-4">{{ $item->change }}
                            </td>
                            <td class="px-6 py-4">{{ $item->section }}
                            </td>
                            <td class="px-6 py-4">{{ $item->change_by }}
                            </td>

                            <td class="px-6 py-4"> {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        let array = @json($changeLog);

        let sort_state = 0;
    </script>
@endsection
