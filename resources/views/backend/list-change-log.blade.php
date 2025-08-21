@extends('backend.master')
@section('content')
@section('header')
    (Audit Trail Data)
@endsection
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
                        {{-- @foreach ($section as $item)
                            <option value="{{ $item->section }}">{{ $item->section }}</option>
                        @endforeach --}}
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
                            {{-- @foreach ($change_by as $item)
                                    <option value="{{ $item->change_by }}">{{ $item->change_by }}</option>
                                @endforeach --}}
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
                </div>
            </div>




    </div>
    </form>

</div>

<div class="table-data relative mt-2 overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
    <table id="table_change_log" class="w-full mt-5 text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

            <!-- Table Headers -->
            <tr class="bg-gray-100 dark:bg-gray-700">
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
                <tr
                    class=" items-start text-left bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top text-left">
                        {{ $item->id }}</td>
                    <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-white align-top text-left">
                        {{ $item->record_id }}
                    </td>
                    <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-white align-top text-left">
                        {{ $item->record_no }}
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top text-left">
                        {{ $item->action }}</td>

                    <!-- Old Values JSON -->
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 max-w-[250px] truncate align-top text-left"
                        title="{{ json_encode($item->old_values) }}">
                        {{ json_encode($item->old_values) }}
                    </td>

                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top text-left">
                        @if ($item->action == 'Create' || $item->action == 'Import')
                            <span data-popover-target="popover-default{{ $item->id }}" type="button"
                                class="cursor-pointer text-blue-600 hover:underline">
                                Detail Data
                            </span>

                            <div data-popover id="popover-default{{ $item->id }}" role="tooltip"
                                class="absolute z-10 invisible inline-block w-96 max-w-full text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">

                                <div
                                    class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Detail Data</h3>
                                </div>

                                <div class="px-3 py-2 max-h-96 overflow-y-auto">
                                    @php
                                        $newValues = json_decode($item->new_values, true);
                                    @endphp

                                    @if ($newValues)
                                        <ul class="list-disc list-inside text-xs">
                                            @foreach ($newValues as $key => $value)
                                                @php
                                                    // Format dates if value is a date
                                                    if (
                                                        in_array($key, [
                                                            'transaction_date',
                                                            'dr_date',
                                                            'invoice_date',
                                                            'created_at',
                                                            'updated_at',
                                                        ])
                                                    ) {
                                                        try {
                                                            $value = \Carbon\Carbon::parse($value)->format('M d, Y');
                                                        } catch (\Exception $e) {
                                                            // keep original if not valid date
                                                        }
                                                    }
                                                @endphp
                                                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        @endif
                    </td>

                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 align-top text-left">
                        {{ $item->section }}</td>
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">
                        {{ $item->change_by ?? ($item->user_id ? $item->users->name : 'System') }}
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $item->reason ?? '-' }}</td>
                    <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ $item->created_at ? $item->created_at->format('M d, Y H:i') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="px-3 py-4 text-center text-gray-500 dark:text-gray-400">No change logs
                        found.</td>
                </tr>
            @endforelse


        </tbody>
    </table>
</div>
</div>
<script>
    let array = @json($changeLog);

    let sort_state = 0;
</script>
@endsection
