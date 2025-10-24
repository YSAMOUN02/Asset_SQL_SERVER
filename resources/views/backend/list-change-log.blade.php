@extends('backend.master')
@section('content')
@section('header')
   Change History Data
@endsection
@section('style')
   <span class=" mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
                 class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Change History</span>
</span>
@endsection
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>


<div class="container-height   shadow-md sm:rounded-lg dark:bg-gray-800">
    <div id="search_bar" class="search-bar sm:grid-cols-2 bg-white border-b dark:bg-gray-800 dark:border-gray-700">

        <form action="/admin/change/log/search" method="POST">
            @csrf
            <div class="max-w-full min-h-full grid px-5 py-3 gap-4 grid-cols-2 lg:grid-cols-4 md:grid-cols-2">
                <!-- Record ID -->
                <div>
                    <label for="record_id" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Record ID
                    </label>
                    <input type="number" id="record_id" name="record_id" value="{{ $filters['record_id'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <!-- Record No -->
                <div>
                    <label for="record_no" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Record No
                    </label>
                    <input type="text" id="record_no" name="record_no" value="{{ $filters['record_no'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <!-- Change By -->
                <div>
                    <label for="change_by" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Change By
                    </label>
                    <select name="change_by" id="change_by"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        @foreach ($change_by as $item)
                            <option value="{{ $item }}"
                                {{ ($filters['change_by'] ?? '') == $item ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Section -->
                <div>
                    <label for="section" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Section
                    </label>
                    <select name="section" id="section"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        @foreach ($sections as $item)
                            <option value="{{ $item }}"
                                {{ ($filters['section'] ?? '') == $item ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Old Values -->
                <div>
                    <label for="old_values" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Old Values
                    </label>
                    <input type="text" id="old_values" name="old_values" value="{{ $filters['old_values'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <!-- New Values -->
                <div>
                    <label for="new_values" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        New Values
                    </label>
                    <input type="text" id="new_values" name="new_values" value="{{ $filters['new_values'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <!-- Reason -->
                <div>
                    <label for="reason" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Reason
                    </label>
                    <input type="text" id="reason" name="reason" value="{{ $filters['reason'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <!-- Action -->
                <div>
                    <label for="action" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Action
                    </label>
                    <select name="action" id="action"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        <option value="Insert" {{ ($filters['action'] ?? '') == 'Insert' ? 'selected' : '' }}>Insert
                        </option>
                        <option value="Update" {{ ($filters['action'] ?? '') == 'Update' ? 'selected' : '' }}>Update
                        </option>
                        <option value="Delete" {{ ($filters['action'] ?? '') == 'Delete' ? 'selected' : '' }}>Delete
                        </option>
                    </select>
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Start Date
                    </label>
                    <input type="date" id="from_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        End Date
                    </label>
                    <input type="date" id="to_date" name="end_date" value="{{ $filters['end_date'] ?? '' }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

            </div>




    </div>
         @if(!empty($page))
    <div class="max-w-full flex items-center px-5 lg:px-0">

        <div class="pagination_by_search px-5 flex main_page w-full defualt ">

            @if (!empty($total_page))
                @php
                    $left_limit = max(1, $page - 5); // Set the left boundary, but not below 1
                    $right_limit = min($total_page, $page + 5); // Set the right boundary, but not above the total pages
                @endphp
                <nav aria-label="Page navigation example">
                    <ul class="flex items-center -space-x-px h-8 text-sm  me-2">

                        {{-- Previous Button --}}
                        @if ($page != 1)
                            <li>
                                <a href="{{ $page - 1 }}"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                            </li>
                        @endif
                        @if ($page > 10)
                            <li>
                                <a href="1"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
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
                        @if ($page < $total_page - 8)
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
             @if($page!=1)
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
            @endif
            <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Page
                :{{ $total_page }} Pages
                &ensp;Total Changes: {{ $total_record }} Records</span>



        </div>

        <div class="flex fix_button">
            <button type="submit"
                class="text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                    class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
            </button>

            <select name="" id="change_limit" onchange="chang_viewpoint(0,'changelog')"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
        =
        </div>
    </div>
       @endif



</div>
</form>

</div>

<div class="table-data relative mt-2 overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
    <table id="table_change_log" class="w-full mt-5 text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

            <!-- Table Headers -->
            <tr   tabindex="0" class="bg-gray-100 dark:bg-gray-700">
                <th class="px-3 py-2 text-left">ID</th>
                <th class="px-3 py-2 text-left">Record ID</th>
                <th class="px-3 py-2 text-left">Record NO.</th>
                <th class="px-3 py-2 text-left">Action</th>
                <th class="px-3 py-2 text-left">Old Values</th>
                <th class="px-3 py-2 text-left">New Values</th>
                <th class="px-3 py-2 text-left">Section</th>
                <th class="px-3 py-2 text-left">Changed By</th>
                <th class="px-3 py-2 text-left">Reason</th>
                <th class="px-3 py-2 text-left">Created At</th>
            </tr>


            {{-- <th scope="col" class="px-6 py-3"
                        style="  position: sticky; right: 0;   background-color: rgb(230, 230, 230);">
                        Action
                    </th> --}}
            </tr>
        </thead>
        <tbody id="table_body_change">
            @forelse($changeLog as $item)
                <tr   tabindex="0"
                    class="items-start text-left bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">

                    <!-- ID -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top">{{ $item->id }}</td>

                    <!-- Record ID -->
                    <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-white align-top">
                        {{ $item->record_id }}</td>

                    <!-- Record No -->
                    <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-white align-top">
                        {{ $item->record_no }}</td>

                    <!-- Action -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top">{{ $item->action }}</td>

                    <!-- Old Values -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top">
                        {{ $item->old_values}}
                    </td>

                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top">
                        {{$item->new_values}}
                    </td>

                    <!-- Section -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top">{{ $item->section }}
                    </td>

                    <!-- Changed By -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">
                        {{ $item->change_by }}
                    </td>

                    <!-- Reason -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $item->reason ?? '-' }}</td>

                    <!-- Created At -->
                    <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y H:i') : '-' }}
                    </td>

                </tr>
            @empty
                <tr   tabindex="0">
                    <td colspan="10" class="text-center py-4">No logs found</td>
                </tr>
            @endforelse



        </tbody>
    </table>
</div>
</div>
<script>
    // let array = @json($changeLog);

    let sort_state = 0;

    flatpickr("#from_date", {
        dateFormat: "d-M-Y",
        defaultDate: null
    });
    flatpickr("#to_date", {
        dateFormat: "d-M-Y",
        defaultDate: null
    });
</script>
@endsection
