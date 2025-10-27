@extends('backend.master')
@section('content')
    <section class="bg-white dark:bg-gray-900 px-1 py-1">
        <div id="profile" class="grid w-full grid-cols-1 md:grid-cols-2  border-2">
            <div class="border-e text-black  dark:text-white  px-16 py-8 lg:py-16  ">
                <div class="flex items-center  mb-8">
                    <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">

                        <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </div>
                    &ensp; &ensp;
                    <span
                        class="text-xl  font-bold text-gray-900 dark:text-white">{{ $user->fname . ' ' . $user->lname }}</span>
                </div>

                <div class="grid gap-4 mb-4   grid-cols-1    sm:gap-6 sm:mb-5 ">

                    <div class="flex items-center text-black  dark:text-white">
                        <i class="fa-solid fa-toolbox" style="font-size: 30px;"></i> &ensp; &ensp;
                        <span>Role : &ensp;&ensp;&ensp;{{ $user->role }}</span>
                    </div>
                    <hr class="mb-5 text-black  dark:text-white">
                    <div class="flex items-center text-black  dark:text-white">
                        <i class="fa-solid fa-user" style="font-size: 30px;"></i> &ensp; &ensp;
                        <span>Login : &ensp;&ensp;&ensp;{{ $user->name }}</span>
                    </div>

                    <hr class="mb-5 text-black  dark:text-white">
                    <div class="flex items-center text-black  dark:text-white">
                        <i class="fa-solid fa-id-card"style="font-size: 30px;"></i></i>&ensp; &ensp;
                        <span>ID :&ensp;&ensp;&ensp;&ensp;&ensp; {{ $user->id_card }}</span>
                    </div>
                    <hr class="mb-5 text-black  dark:text-white">
                    <div class="flex items-center text-black  dark:text-white">
                        <i class="fa-solid fa-briefcase"style="font-size: 30px;"></i> &ensp; &ensp;

                        <span>Position : {{ $user->position }}</span>
                    </div>
                    <hr class="mb-5 text-black  dark:text-white">
                    <div class="flex items-center text-black  dark:text-white">
                        <i class="fa-solid fa-envelope" style="font-size: 30px;"></i> &ensp; &ensp;

                        <span>Email : &ensp; &ensp; {{ $user->email }}</span>
                    </div>
                    <hr class="mb-5 text-black  dark:text-white">
                    <div class="flex items-center text-black  dark:text-white">
                        <i class="fa-solid fa-building-user" style="font-size: 30px;"></i> &ensp; &ensp;
                        @php
                            $structure = collect([
                                $user->company?->name,
                                $user->department?->name,
                                $user->division?->name,
                                $user->section?->name,
                                $user->group?->name,
                            ])
                                ->filter()
                                ->join(' / ');
                        @endphp
                        <span>
                            Company structure : &ensp; &ensp;
                            <b >{{ $structure }}</b>
                        </span>
                    </div>
                </div>

            </div>
            <div class="border-e  text-black  dark:text-white    px-16 py-8 lg:py-16  ">
                <span class="text-xl  font-bold text-gray-900 dark:text-white"><i class="fa-solid fa-key"
                        style="font-size: 30px;"></i> &ensp;&ensp;Permission</span>
                <div class="grid grid-cols-1 md:grid-cols-1 mt-5 gap-4">

                    <div>
                        <label class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300"
                            for="">User Section</label>
                        <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownSearchButton">
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->user_read == 1)
                                        <input id="user_read" checked type="checkbox" disabled name="user_read"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="user_read" type="checkbox" disabled name="user_read"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif
                                    &ensp;<label for="user_read"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->user_write == 1)
                                        <input id="user_write" checked type="checkbox" disabled name="user_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="user_write" type="checkbox" disabled name="user_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="user_write"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                                </div>
                            </li>

                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->user_update == 1)
                                        <input id="user_update" checked name="user_update" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="user_update" name="user_update" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="user_update"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->user_delete == 1)
                                        <input id="user_delete" checked name="user_delete" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="user_delete" name="user_delete" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="user_delete"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div>
                        <label
                            class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Assets
                            Section</label>
                        <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownSearchButton">
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->assets_read == 1)
                                        <input id="assets_read" name="assets_read" type="checkbox" disabled checked
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="assets_read" name="assets_read" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="assets_read"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->assets_write == 1)
                                        <input id="assets_write" type="checkbox" disabled checked name="assets_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="assets_write" type="checkbox" disabled name="assets_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="assets_write"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->assets_update == 1)
                                        <input id="assets_update" type="checkbox" disabled checked name="assets_update"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="assets_update" type="checkbox" disabled name="assets_update"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="assets_update"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->assets_delete == 1)
                                        <input id="assets_delete" type="checkbox" disabled checked name="assets_delete"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="assets_delete" type="checkbox" disabled name="assets_delete"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif

                                    &ensp;<label for="assets_delete"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                                </div>
                            </li>

                        </ul>
                    </div>


                    <div>
                        <label
                            class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Movement
                            Section</label>
                        <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownSearchButton">
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->transfer_read == 1)
                                        <input id="transfer_read" checked name="transfer_read" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="transfer_read" name="transfer_read" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif
                                    &ensp;<label for="transfer_read"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->transfer_write == 1)
                                        <input id="transfer_write" checked type="checkbox" disabled name="transfer_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="transfer_write" type="checkbox" disabled name="transfer_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif
                                    &ensp;<label for="transfer_write"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->transfer_update == 1)
                                        <input id="transfer_update" checked type="checkbox" disabled
                                            name="transfer_update"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="transfer_update" type="checkbox" disabled name="transfer_update"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif
                                    &ensp;<label for="transfer_update"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->transfer_delete == 1)
                                        <input id="transfer_delete" checked type="checkbox" disabled
                                            name="transfer_delete"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @else
                                        <input id="transfer_delete" type="checkbox" disabled name="transfer_delete"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    @endif
                                    &ensp;<label for="transfer_delete"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div>
                        <label
                            class="label_user ml-5 bg-white dark:bg-gray-700 text-gray-900 rounded dark:text-gray-300">Data
                            Setup
                            Section</label>
                        <ul class="h-56 px-2 py-2 ml-5 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownSearchButton">
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->quick_read == 1)
                                        <input id="quick_read" name="quick_read" type="checkbox" disabled checked
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        &ensp;<label for="quick_read"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                                    @else
                                        <input id="quick_read" name="quick_read" type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        &ensp;<label for="quick_read"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Read</label>
                                    @endif

                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->quick_write == 1)
                                        <input id="quick_write" type="checkbox" disabled name="quick_write" checked
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        &ensp;<label for="quick_write"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                                    @else
                                        <input id="quick_write" type="checkbox" disabled name="quick_write"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        &ensp;<label for="quick_write"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Write</label>
                                    @endif

                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->quick_update == 1)
                                        <input id="quick_update" type="checkbox" disabled name="quick_update" checked
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        &ensp;<label for="quick_update"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                                    @else
                                        <input id="quick_update" type="checkbox" disabled name="quick_update"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        &ensp;<label for="quick_update"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Update</label>
                                    @endif

                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    @if ($user->permission->quick_delete == 1)
                                        <input id="quick_delete" type="checkbox" disabled name="quick_delete" checked
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

                                        &ensp;<label for="quick_delete"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                                    @else
                                        <input id="quick_delete" type="checkbox" disabled name="quick_delete"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

                                        &ensp;<label for="quick_delete"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Delete</label>
                                    @endif


                                </div>
                            </li>

                        </ul>
                    </div>
                    <div>

                    </div>
                </div>



            </div>
        </div>

        </div>
    </section>
@endsection
