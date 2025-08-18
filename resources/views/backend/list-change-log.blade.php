@extends('backend.master')
@section('content')


    <div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
        <div id="search_bar" class="search-bar sm:grid-cols-2 bg-white border-b dark:bg-gray-800 dark:border-gray-700">

            <form action="/admin/change/log/search" method="POST">
                @csrf
                <div class="max-w-full min-h-full grid px-5 py-3 gap-4 grid-cols-2 lg:grid-cols-4 md:grid-cols-2">
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
                            @foreach ($section as $item)
                                <option value="{{$item->section}}">{{$item->section}}</option>
                            @endforeach
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
                            date</label>

                        <input type="date" id="start_date" name="start_date" name="end_date" onchange="check_date()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="......." />

                    </div>
                    <div>
                        <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To date
                           </label>

                        <input type="date" id="end_date" name="end_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>




                </div>
                <div class="max-w-full flex items-center px-5 lg:px-0">

                    <div class="pagination_by_search px-5 flex main_page w-full defualt ">

                        @if (!empty($total_page))
                            @php
                                $left_limit = max(1, $page - 5); // Set the left boundary, but not below 1
                                $right_limit = min($total_page, $page + 5); // Set the right boundary, but not above the total pages
                            @endphp
                            <nav aria-label="Page navigation example">
                                <ul class="flex items-center -space-x-px h-8 text-sm ">

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
                                    @if ($total_page > 6 && $page != $total_page)
                                        <li>
                                            <a href="{{ $total_page }}"
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                {{ $total_page }}
                                            </a>
                                        </li>
                                    @endif
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
                        <select onchange="set_page_changeLog()" id="select_page"
                            class="flex mx-0 lg:mx-2 items-center justify-center px-3 h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
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
                        <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Page
                            :{{ $total_page }} Pages
                            &ensp;Total Changes: {{ $total_record }} Records</span>



                    </div>
                    <div class="flex fix_button">
                    <button type="button" onclick="search_change_log(0)"
                        class="text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                            class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                    </button>

                            <select name="" id="change_limit" onchange="chang_viewpoint(0,'changelog')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if ($limit)
                                    <!-- Selected/current limit option at the top -->
                                    <option value="{{ $limit }}" selected>{{ $limit }} Row</option>

                                    <!-- Other options excluding the current limit -->
                                    @foreach ([25, 50, 75, 100, 125, 150, 175, 200, 300, 500] as $option)
                                        @if ($limit != $option)
                                            <option value="{{ $option }}">{{ $option }} Row</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                    </div>
                </div>




        </div>
        </form>

    </div>

    <div class="table-data relative mt-2 overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
        <table id="table_change_log" class=" w-full mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>

                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('id','int','changelog')">
                        Entry &ensp;
                    </th>
                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('key','int','changelog')">
                        Key ID &ensp;
                    </th>
                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('varaint','int','changelog')">
                        Varaint &ensp;
                    </th>
                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('change','string','changelog')">
                        Change Detail &ensp;
                    </th>
                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('section','string','changelog')">
                        Section &ensp;
                    </th>
                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('change_by','string','changelog')">
                        Change By &ensp;
                    </th>

                    <th scope="col" class="px-6 py-3" onclick="dynamic_sort('created_at','date','changelog')">
                        Date &ensp;
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
                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                            {{ $item->id }}
                        </td>
                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">{{ $item->key }}
                        </td>
                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">{{ $item->varaint }}
                        </td>
                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">{{ $item->change }}
                        </td>
                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">{{ $item->section }}
                        </td>
                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">{{ $item->change_by }}
                        </td>

                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}
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
