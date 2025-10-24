@extends('backend.master')
@section('content')
    <div class="w-full  bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between">
            <span class=" text-1xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-4xl"><span class="text-transparent bg-clip-text bg-gradient-to-r to-amber-600 from-orange-400">My Last Active Assets </span></span>
            @if ($broken == 1)

             <a href="/admin/assets-ownership/0">
                <div>Hide Broken</div>
            </a>
            @else
             <a href="/admin/assets-ownership/1">
                <div>Show Broken</div>
            </a>
            @endif

        </div>


<hr class="mb-4 mt-4">
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 z">


        @foreach ($assets as $item)
            <div
                class="flex flex-col justify-between bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 h-full">

                {{-- 🔹 Image section --}}
                <div class="flex justify-center items-center bg-gray-100 h-48 overflow-hidden rounded-t-lg">
                    @if ($item->images && $item->images->isNotEmpty())
                        @php
                            $image = $item->images->first();
                        @endphp
                        <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}">
                            <img src="{{ asset('storage/uploads/image/' . $image->image) }}" alt="{{ $image->image }}"
                                class="object-contain w-full h-full" />
                        </a>
                    @else
                        <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}">
                            <img src="/static_img/4414467.png" alt="{{ $item->assets1 . $item->assets2 }}"
                                class="object-contain w-full h-full p-8" />
                        </a>
                    @endif
                </div>

                {{-- 🔹 Content section --}}
                <div class="flex flex-col flex-grow justify-between p-5">
                    <div>
                        <h5 class="mb-2 text-sm lg:text-xl md:text-xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                                {{$item->item}}
                            </h5>
                            <h5 class="mb-2 text-sm lg:text-xl md:text-xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                                {{ $item->assets1 . $item->assets2 }}
                            </h5>


                        <p class="text-gray-700 dark:text-gray-400 text-sm text-center line-clamp-2">
                            {{ $item->item_description }}
                        </p>

                        <div class="flex justify-center mt-2">
                            @if ($item->initial_condition<>'')
                             <span
                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm dark:bg-blue-200 dark:text-blue-800">
                                {{ $item->initial_condition }}
                            </span>
                            @endif

                        </div>
                         <p class="text-gray-700 mt-2 dark:text-gray-400 text-sm text-center line-clamp-2">
                            Last Transaction : {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-M-Y') }}
                        </p>
                    </div>

                    {{-- 🔹 Button --}}
                    <div class="flex justify-center mt-4">
                        <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            View
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
     </div>
@endsection
