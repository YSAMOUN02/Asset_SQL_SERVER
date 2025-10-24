@extends('backend.master')
@section('content')
    <div
        class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-2 p-4  gap-4 justify-start bg-white dark:bg-black h-full w-full">

        @foreach ($assets as $item)
            <div  class="max-w-sm flex flex-col items-center justify-between bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                @if ($item->images && $item->images->isNotEmpty())
                    @foreach ($item->images as $image)
                        <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}">
                            <img class="rounded-t-lg" src="{{ asset('storage/uploads/image/' . $image?->image) }}"
                                alt="{{ $image?->image }}" />

                        </a>
                    @endforeach
                @else
                    <div class="p-8">
                        <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}">
                            <img class="rounded-t-lg" class="" alt="{{ $item->assets1 . $item->assets2 }}" />
                    </div>
                @endif

                <div class="p-5">
                    <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $item->assets1 . $item->assets2 }}
                        </h5>
                    </a>
                    <div class="flex flex-col">
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $item->item }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $item->item_description }}</p>

                    <span class=" block items-center bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm dark:bg-blue-200 dark:text-blue-800 ">{{ $item->initial_condition }}</span>
                    </div>
                    <br>
                    <a href="/admin/assets/data/view/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        View
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach



    </div>
@endsection
