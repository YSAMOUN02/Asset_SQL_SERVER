@extends('backend.master')
@section('content')
    <div id="search_bar" class="search-bar sm:grid-cols-2 bg-white border-b dark:bg-gray-800 dark:border-gray-700">

        <form action="/admin/change/log/search" method="POST">
            @csrf
            <div class="max-w-full min-h-full grid px-5 py-3 gap-4 grid-cols-4">
                <div>
                    <label for="key" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Key ID
                    </label>
                    <input type="text" id="key" name="key"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="varaint" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Varaint
                    </label>

                    <input type="text" id="varaint" name="varaint"
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
                        <option value="user">User Section</option>
                        <option value="assets">Assets Section</option>
                    </select>
                </div>
                <div>
                    <label for="chang_by" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        Change By
                    </label>
                    <select name="chang_by" id="chang_by"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        <option value="admin">admin</option>
                        <option value="admin">user</option>
                    </select>
                </div>
                <div>
                    <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Start
                        from
                        date (Change Date)</label>

                    <input type="date" id="start_date" value="" name="start_date" name="end_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="......." />

                </div>
                <div>
                    <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">To date
                        (Change Date)</label>

                    <input type="date" id="end_date" value="" name="end_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                </div>




            </div>
            <div class="max-w-full flex justify-end px-5"> <button type="submit"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                        class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button></div>
        </form>

    </div>

    <div class="relative overflow-x-auto whitespace-nowrap shadow-md sm:rounded-lg">
        <table id="table_change_log" class="w-full mt-5 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                    <th scope="col" class="px-6 py-3"  onclick="dynamic_sort('role','string','changelog')">
                        Role  &ensp; <i class="fa-solid fa-sort"></i>
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
            <tbody  id="table_body_change">
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
                        <td class="px-6 py-4">{{ $item->users->name }}
                        </td>
                        <td class="px-6 py-4">{{ $item->users->role }}
                        </td>
                        <td class="px-6 py-4"> {{ \Carbon\Carbon::parse($item->created_at)->format('M d Y') }}
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        let array = @json($changeLog);

        let sort_state = 0;


    </script>
@endsection
