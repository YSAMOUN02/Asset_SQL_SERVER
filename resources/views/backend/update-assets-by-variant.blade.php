@extends('backend.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <div class="border-b bg-white dark:bg-slate-900 dark:text-white border-gray-200 dark:border-gray-700">
        <ul id="variant_tabs"
            class="flex  overflow-x-auto whitespace-nowrap -mb-px text-sm font-medium text-center text-gray-500   dark:text-gray-200">

            @if ($asset_main->variant == $variant)
                <li class="me-2 active_tab">
                    <a href="/admin/assets/data/{{ $state }}/id={{ $asset_main->assets_id }}/variant={{ $asset_main->variant }}"
                        class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                        <i class="fa-brands fa-codepen mr-3 "></i>Lastest Change Variant {{ $asset_main->variant }}
                        @if ($asset_main->deleted == 1)
                            &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i>
                            &ensp;({{ \Carbon\Carbon::parse($asset_main->deleted_at)->format('d-M-Y') }})
                        @endif
                    </a>
                </li>
            @else
                <li class="me-2 ">
                    <a href="/admin/assets/data/{{ $state }}/id={{ $asset_main->assets_id }}/variant={{ $asset_main->variant }}"
                        class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                        <i class="fa-brands fa-codepen mr-3 "></i>Lastest Change Variant {{ $asset_main->variant }}
                        @if ($asset_main->deleted == 1)
                            &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i>
                            &ensp;({{ \Carbon\Carbon::parse($asset_main->deleted_at)->format('d-M-Y') }})
                        @endif
                    </a>
                </li>
            @endif
            @php
                $asset = $asset_main;
                $master_status = $asset_main->status;
                $master_id = $asset_main->assets_id;
                $current_last_variant = $asset_main->variant;
                $master_image = $asset_main->images;
                $master_variant = $asset_main->variant;
            @endphp

            @if (count($asset_main->assets_variant) > 0)
                @foreach ($asset_main->assets_variant as $item)
                    @if ($item->variant == 1)
                        @if ($item->variant == $variant)
                            <li class="me-2 active_tab">
                                @php
                                    $colors = [
                                        '#e74c3c',
                                        '#8e44ad',
                                        '#3498db',
                                        '#16a085',
                                        '#f39c12',
                                        '#d35400',
                                        '#2ecc71',
                                    ];
                                    $color = $colors[$item->variant % count($colors)];
                                @endphp
                                <a href="/admin/assets/data/{{ $state }}/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                                    class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                                    <i class="fa-solid fa-folder-plus mx-2" style="color: {{ $color }}"></i> Variant
                                    {{ $item->variant }}
                                    @if ($item->deleted == 1)
                                        &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i>
                                        &ensp;({{ \Carbon\Carbon::parse($item->deleted_at)->format('d-M-Y') }})
                                    @endif
                                </a>
                            </li>
                        @else
                            <li class="me-2 ">
                                @php
                                    $colors = [
                                        '#e74c3c',
                                        '#8e44ad',
                                        '#3498db',
                                        '#16a085',
                                        '#f39c12',
                                        '#d35400',
                                        '#2ecc71',
                                    ];
                                    $color = $colors[$item->variant % count($colors)];
                                @endphp
                                <a href="/admin/assets/data/{{ $state }}/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                                    class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                                    <i class="fa-solid fa-folder-plus mx-2" style="color: {{ $color }}"></i> Variant
                                    {{ $item->variant }}
                                    @if ($item->deleted == 1)
                                        &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i>
                                        &ensp;({{ \Carbon\Carbon::parse($item->deleted_at)->format('d-M-Y') }})
                                    @endif
                                </a>
                            </li>
                        @endif
                    @elseif($item->variant > 1)
                        @if ($variant == $item->variant)
                            <li class="me-2 active_tab">
                                @php
                                    $colors = [
                                        '#e74c3c',
                                        '#8e44ad',
                                        '#3498db',
                                        '#16a085',
                                        '#f39c12',
                                        '#d35400',
                                        '#2ecc71',
                                    ];
                                    $color = $colors[$item->variant % count($colors)];
                                @endphp
                                <a href="/admin/assets/data/{{ $state }}/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                                    class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                                    <i class="fa-solid fa-palette mx-2" style="color: {{ $color }}"></i> Variant
                                    {{ $item->variant }}
                                    @if ($item->deleted == 1)
                                        &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i>
                                        &ensp;({{ \Carbon\Carbon::parse($item->deleted_at)->format('d-M-Y') }})
                                    @endif
                                </a>
                            </li>
                        @else
                            <li class="me-2">
                                @php
                                    $colors = [
                                        '#e74c3c',
                                        '#8e44ad',
                                        '#3498db',
                                        '#16a085',
                                        '#f39c12',
                                        '#d35400',
                                        '#2ecc71',
                                    ];
                                    $color = $colors[$item->variant % count($colors)];
                                @endphp
                                <a href="/admin/assets/data/{{ $state }}/id={{ $item->assets_id }}/variant={{ $item->variant }}"
                                    class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                                    <i class="fa-solid fa-palette mx-2" style="color: {{ $color }}"></i> Variant
                                    {{ $item->variant }}
                                    @if ($item->deleted == 1)
                                        &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i>
                                        &ensp;({{ \Carbon\Carbon::parse($item->deleted_at)->format('d-M-Y') }})
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        </ul>
    </div>

    @if (!empty($asset_main->assets_variant))
        @foreach ($asset_main->assets_variant as $item)
            @php
                if ($item->variant == $variant) {
                    $asset = $item;
                    break; // stop looping once found
                }
            @endphp
        @endforeach
    @endif
    <form class="p-5 dark:bg-gray-900 bg-white" id="form-submit" enctype="multipart/form-data"
        action="/admin/assets/update/submit" method="POST"
        @if ($state != 'update') onsubmit="return false;" @endif>

        @csrf

        <h1 class="title_base text-black dark:text-blue-100">Asset Info

            @if ($master_status == 1)
                <span class="title_base text-green-600">[Last Active]</span>
            @else
                <span class="title_base text-red-600">[Inactive]</span>
            @endif
        </h1>






        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
            <div>
                <label for="">Reference<span class="text-rose-500">*</span></label>
                <input type="text" list="references_list" id="ReferenceInput" onchange="setReferenceId(this)"
                    oninput="validateInputField(this,30)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="reference" required autocomplete="off" value="{{ old('reference', $asset->reference ?? '') }}" />

                <input type="hidden" id="ReferenceId" name="reference_id" />

                <datalist id="references_list">
                    @foreach ($references as $item)
                        <option data-id="{{ $item->id }}"
                            value="{{ $item->code . str_pad($item->no, 5, '0', STR_PAD_LEFT) }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </datalist>
                <input type="text" class="hidden" name="assets_id" value="{{ $asset->assets_id }}">
                <input type="text" class="hidden" name="state" value="{{ $state }}">
            </div>



            <div class="flex flex-col w-full">
                <label for="no" id="assets_label"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset Code <span
                        class="text-rose-500" id="assets12">*</span> </label>
                <div class="flex w-full">
                    <input type="text" id="asset_Code1" name="asset1" readonly oninput="validateInputField(this,30)"
                        class="percent70 bg-gray-50 border border-gray-300 p-2.5 text-gray-900 text-sm focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('assets1', $asset->assets1 ?? '') }}" />

                    <select name="assets2" required oninput="validateInputField(this,10)"
                        class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        @foreach ($assets2 as $asset2)
                            @if (($asset->assets2 ?? '') == '-' . $asset2->code)
                                <option value="{{ $asset->assets2 }}" selected>
                                    {{ str_replace('-', '', $asset2->code) . ' : ' . $asset2->name }}</option>
                            @else
                                <option value="{{ '-' . $asset2->code }}">{{ $asset2->code . ' : ' . $asset2->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="fa_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA-No</label>
                <input type="text" id="fa_no" oninput="validateInputField(this,100)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="fa_no" value="{{ old('fa_no', $asset->fa_no ?? '') }}" />
            </div>

            <div>
                <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item <span
                        class="text-rose-500">*</span></label>
                <input type="text" id="item" oninput="validateInputField(this,255)" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="item" value="{{ old('item', $asset->item ?? '') }}" />
            </div>

            <div>
                <label for="transaction_date"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction Date</label>
                <input type="text" id="transaction_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="transaction_date" />
            </div>

            <div>
                <label for="initial_condition"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initial
                    Conditions <span class="text-rose-500">*</span></label>


                <select required id="Initial_Condition" name="initial_condition" oninput="validateInputField(this,255)"
                    required
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
           focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
           dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    <option value="New" @if (($asset->initial_condition ?? '') == 'New') selected @endif>New</option>
                    <option value="Good" @if (($asset->initial_condition ?? '') == 'Good') selected @endif>Good</option>
                    <option value="Very good" @if (($asset->initial_condition ?? '') == 'Very good') selected @endif>Very good</option>
                    <option value="Low" @if (($asset->initial_condition ?? '') == 'Low') selected @endif>Low</option>
                    <option value="Second hand" @if (($asset->initial_condition ?? '') == 'Second hand') selected @endif>Second hand</option>
                    <option value="Medium" @if (($asset->initial_condition ?? '') == 'Medium') selected @endif>Medium</option>
                    <option value="Old" @if (($asset->initial_condition?? '') == 'Old') selected @endif>Old</option>
                    <option value="Very old" @if (($asset->initial_condition ?? '') == 'Very old') selected @endif>Very old</option>
                    <option value="Broken" @if (($asset->initial_condition ?? '') == 'Broken') selected @endif>Broken</option>

                </select>


            </div>

            <div>
                <label for="Specifications"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specifications <span
                        class="text-rose-500">*</span></label>
                <input type="text" id="Specifications" required oninput="validateInputField(this,255)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="specification" value="{{ old('specification', $asset->specification ?? '') }}" />
            </div>

            <div>
                <label for="item_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item
                    Description <span class="text-rose-500">*</span></label>
                <input type="text" id="item_description" name="item_description" required
                    oninput="validateInputField(this,255)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('item_description', $asset->item_description ?? '') }}" />
            </div>

            <div>
                <label for="asset_group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Group</label>
                <input type="text" id="asset_group" oninput="validateInputField(this,255)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_group" value="{{ old('asset_group', $asset->asset_group ?? '') }}" />
            </div>

            <div>
                <label for="old_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Code
                    (Optional)</label>
                <input type="text" id="old_code" oninput="validateInputField(this,100)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="old_code" value="{{ old('old_code', $asset->old_code ?? '') }}" />
            </div>
            <div>
                <label for="remark_assets"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_assets" oninput="validateInputField(this,255)"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_assets" value="{{ old('remark_assets', $asset->remark_assets ?? '') }}" />
            </div>
        </div>



        <h1 class="mb-2 title_base text-black dark:text-blue-100">Asset Holder Info <button type="button"
                id="clear_user"
                class="text-white  bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-2 py-1 ext-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"><i
                    class="fa-regular fa-trash-can"></i></button></h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">

            <div>
                <label for="asset_holder">Asset Holder ID </label>
                <input type="text" id="asset_holder" name="asset_holder" list="asset_list" placeholder="INV-90.."
                    autocomplete="off" value="{{ old('asset_holder', $asset->asset_holder ?? '') }}" oninput="validateInputField(this,30)"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
       dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <datalist id="asset_list"></datalist>
            </div>

            <div>
                <label for="holder_name">Name</label>
                <input type="text" id="holder_name" name="holder_name" list="users_list" autocomplete="off"
                    value="{{ old('holder_name', $asset->holder_name ?? '') }}" oninput="validateInputField(this,80)"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
       dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Start typing name...">
                <datalist id="users_list"></datalist>
            </div>
            <div>
                <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Position/Title
                </label>
                <input type="text" id="position" name="position"
                    value="{{ old('position', $asset->position ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div>
                <label for="Location"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" id="Location" oninput="validateInputField(this,100)" autocomplete="off"
                    value="{{ old('location', $asset->location ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="location" />
            </div>

            <div>
                <label for="department">Department <span class="text-rose-500">*</span></label>
                <input list="departments_list" id="department" name="department" autocomplete="off" required
                    value="{{ old('department', $asset->department ?? '') }}"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
            focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
            dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Start typing department...">
                <datalist id="departments_list">
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->name }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div>
                <label for="company">Company <span class="text-rose-500">*</span></label>
                <input list="company_list" id="company" name="company" autocomplete="off" required
                    value="{{ old('company', $asset->company ?? '') }}"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
       dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Start typing company...">
                <datalist id="company_list">
                    @foreach ($company as $comp)
                        <option value="{{ $comp->code }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div>
                <label for="remark_holder"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_holder"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_holder" value="{{ old('remark_holder', $asset->remark_holder ?? '') }}" />
            </div>
        </div>

        <h1 class="mb-2 title_base text-black dark:text-blue-100">Internal Document</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="grn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GRN No</label>
                <input type="text" id="grn"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="grn" value="{{ old('grn', $asset->grn ?? '') }}" />
            </div>
            <div>
                <label for="po" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PO No</label>
                <input type="text" id="po"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="po" value="{{ old('po', $asset->po ?? '') }}" />
            </div>
            <div>
                <label for="pr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PR (Purchase
                    Request)</label>
                <input type="text" id="pr"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="pr" value="{{ old('pr', $asset->pr ?? '') }}" />
            </div>
            <div>
                <label for="dr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR (Department
                    Request)</label>
                <input type="text" id="dr"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="dr" value="{{ old('dr', $asset->dr ?? '') }}" />
            </div>
            <div>
                <label for="dr_requested_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                    (Requested by)</label>
                <input type="text" id="dr_requested_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="dr_requested_by" value="{{ old('dr_requested_by', $asset->dr_requested_by ?? '') }}" />
            </div>
            <div>
                <label for="dr_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR Request
                    Date</label>
                <input type="text" id="dr_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="dr_date" value="{{ old('dr_date', $asset->dr_date, today()) }}" />


            </div>
            <div>
                <label for="remark_internal_doc"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_internal_doc"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_internal_doc"
                    value="{{ old('remark_internal_doc', $asset->remark_internal_doc ?? '') }}" />
            </div>
        </div>

        <h1 class="mb-2 title_base text-black dark:text-blue-100">ERP Invoice</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <!-- Asset Code (Account) -->
            <div class="flex flex-col w-full">
                <label for="asset_code_account" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code (Account)</label>
                <input type="text" id="asset_code_account" name="asset_code_account" readonly
                    class="w-full bg-gray-50 border p-2.5 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('asset_code_account', $asset->asset_code_account ?? '') }}" />
            </div>

            <div>
                <label for="invoice_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Invoice Posting Date
                </label>
                <input type="text" id="invoice_date" name="invoice_date" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <!-- Invoice No -->
            <div>
                <label for="invoice_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                    No</label>
                <input type="text" id="invoice_no" name="invoice_no" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('invoice_no', $asset->invoice_no ?? '') }}" />
            </div>

            <!-- Fix Assets-No -->
            <div>
                <label for="fa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fix
                    Assets-No</label>
                <input type="text" id="fa" name="fa" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa', $asset->fa ?? '') }}" />
            </div>

            <!-- FA Class -->
            <div>
                <label for="fa_class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Class</label>
                <input type="text" id="fa_class" name="fa_class" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_class', $asset->fa_class ?? '') }}" />
            </div>

            <!-- FA Subclass Code -->
            <div>
                <label for="FA_Subclass_Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Subclass Code</label>
                <input type="text" id="FA_Subclass_Code" name="fa_subclass" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_subclass', $asset->fa_subclass ?? '') }}" />
            </div>

            <!-- Depreciation Book Code -->
            <div>
                <label for="depreciation"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Depreciation Book Code</label>
                <input type="text" id="depreciation" name="depreciation" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('depreciation', $asset->depreciation ?? '') }}" />
            </div>

            <!-- FA Posting Type -->
            <div>
                <label for="fa_posting_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Posting Type</label>
                <input type="text" id="fa_posting_type" name="fa_type" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_type', $asset->fa_type ?? '') }}" />
            </div>

            <!-- FA Location -->
            <div>
                <label for="fa_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Location</label>
                <input type="text" id="fa_location" name="fa_location" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_location', $asset->fa_location ?? '') }}" />
            </div>

            <!-- Cost & VAT -->
            <div class="flex flex-col w-full">
                <label for="cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost &
                    VAT</label>
                <div class="flex w-full">
                    <input type="text" id="cost" name="cost" readonly
                        class="percent3 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('cost', (float) $asset->cost ?? '') }}" />
                    <input type="text" id="currency" name="currency" readonly
                        class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('currency', $asset->currency ?? '') }}" />
                    <input type="text" id="vat" name="vat" readonly
                        class="percent3 px-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('vat', $asset->vat ?? '') }}" />
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Description
                </label>
                <textarea id="description" name="description" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description', $asset->description ?? '') }}</textarea>
            </div>

            <div class="flex flex-col w-full">
                <label for="invoice_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Invoice Description
                </label>
                <textarea id="invoice_description" name="invoice_description" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('invoice_description', $asset->invoice_description ?? '') }}
                </textarea>
            </div>

        </div>


        <h1 class="mb-2 title_base text-black dark:text-blue-100">Vendor Info</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">

            <div>
                <div>
                    <label for="vendor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
                        No</label>

                    <input type="text" id="vendor" name="vendor" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value= "{{ old('vendor', $asset->vendor ?? '') }}" />


                </div>
            </div>
            <div>
                <div>
                    <label for="vendor_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
                        Name</label>

                    <input type="text" id="vendor_name" name="vendor_name" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value= "{{ old('vendor_name', $asset->vendor_name ?? '') }}" />


                </div>
            </div>
            <div>
                <div>
                    <label for="address"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>

                    <input type="text" id="address" name="address" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value= "{{ old('address', $asset->address ?? '') }}" />


                </div>
            </div>
            <div>
                <div>
                    <label for="address2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address
                        2</label>
                    @if (!empty($asset->address2))
                        <input type="text" id="address2" name="address2" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->address2 }}" />
                    @else
                        <input type="text" id="address2" name="address2" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
            <div>
                <div>
                    <label for="contact"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>

                    @if (!empty($asset->contact))
                        <input type="text" id="contact" name="contact" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->contact }}" />
                    @else
                        <input type="text" id="contact" name="contact" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
            <div>
                <div>
                    <label for="phone"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                    @if (!empty($asset->phone))
                        <input type="text" id="phone" name="phone" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->phone }}" />
                    @else
                        <input type="text" id="phone" name="phone" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
            <div>
                <div>
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-Mail</label>
                    @if (!empty($asset->email))
                        <input type="text" id="email" name="email" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->email }}" />
                    @else
                        <input type="text" id="email" name="email" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
        </div>
        <h1 class="mb-2 title_base text-black dark:text-blue-100">QR Code </h1>
        <div id="qr_code">

            <a target="_blank" href="/admin/qr/code/print/assets={{ $asset->assets1 . $asset->assets2 }}">
                {!! QrCode::size(250)->generate($asset->assets1 . $asset->assets2) !!}
            </a>
        </div>
        <h1 class="mb-2 title_base text-black mt-4 dark:text-blue-100">Image </h1>
        {{-- Count for New Image inserted --}}
        <input type="text" class="hidden" name="image_state" value="0" id="image_state">
        <input type="text" class="hidden" name="file_state" value="0" id="file_state">
        <div id="image_show" class="grid gap-6 mb-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

            @if (!empty($master_image))
                @php
                    $image_qty = 0;
                    $image_no = 0;
                @endphp

                @foreach ($master_image as $item)
                    @if ($item->variant == $variant)
                        @php
                            $image_qty++;
                            $image_no++;
                        @endphp
                        <div class="image_box relative overflow-hidden rounded shadow-md"
                            id="image_box_varaint{{ $item->id }}" style="min-height:300px;">
                            {{-- Display image --}}
                            <img id="image_box_varaint_img{{ $item->id }}"
                                src="{{ asset('storage/uploads/image/' . $item->image) }}"
                                onclick="maximize_minimize('image_box_varaint_img{{ $item->id }}',1)"
                                alt="{{ $item->image }}" class="zoomable w-full h-full object-cover cursor-pointer">

                            {{-- Delete button --}}
                            <button type="button" onclick="remove_image_from_stored_varaint({{ $item->id }})"
                                class="absolute top-2 right-10 bg-white p-1 rounded shadow hover:bg-red-100">
                                <i class="fa-solid fa-trash text-red-600"></i>
                            </button>

                            {{-- Download button --}}
                            <a download="{{ $item->image }}"
                                href="{{ asset('storage/uploads/image/' . rawurlencode($item->image)) }}"
                                class="absolute top-2 right-2 bg-white p-1 rounded shadow hover:bg-green-100">
                                <i class="fa-regular fa-circle-down text-green-600"></i>
                            </a>

                            {{-- Hidden input --}}
                            <input type="hidden" value="{{ $item->image }}"
                                id="image_input_variant_{{ $item->id }}" name="image_stored{{ $image_no }}">
                        </div>
                    @endif
                @endforeach

                {{-- Track total images --}}
                <input type="hidden" name="state_stored_image" value="{{ $image_qty }}">
            @endif
        </div>

        <h1 class="mb-2 title_base text-black dark:text-blue-100">Other FIle</h1>
        <div id="container_file" class="grid justify-start gap-6 mb-6 grid-cols-1 lg:grid-cols-1 md:grid-cols-1">

            @if (!empty($asset->files))
                @php
                    $file_qty = 0;
                    $file_no = 1;

                @endphp

                @foreach ($asset->files as $item)
                    @php
                        $pathInfo = pathinfo($item->file);

                        $extension = $pathInfo['extension']; // txt
                        $filename = $item->file; // example
                    @endphp
                    @if ($item->variant == $current_variant)
                        @if ($extension == 'xlsx')
                            <div class="flex box_file" id="file_container{{ $file_no }}">
                                <a target="_blank" href="/uploads/files/{{ $filename }}">
                                    <i class="fa-solid fa-file-excel" style=" color: #009d0a;"></i>
                                    <span class="px-5 dark:text-white">{{ $filename }}</span>
                                    <input type="text" value="{{ $filename }}"
                                        name="file_stored{{ $file_no }}" class="hidden">
                                </a>
                                <button type="button" onclick="remove_file_container({{ $file_no }})">
                                    <i class="fa-solid fa-trash" style="color: #ff0000; font-size:20px;"></i>
                                </button>
                            </div>
                        @elseif($extension == 'pdf')
                            <div class="flex box_file" id="file_container{{ $file_no }}">
                                <a target="_blank" href="/uploads/files/{{ $filename }}">
                                    <i class="fa-solid fa-file-pdf" style="color: #ff0000;"></i>
                                    <span class="px-5 dark:text-white">{{ $filename }}</span>
                                    <input type="text" value="{{ $filename }}"
                                        name="file_stored{{ $file_no }}" class="hidden">
                                </a>
                                <button type="button" onclick="remove_file_container({{ $file_no }})">
                                    <i class="fa-solid fa-trash" style="color: #ff0000; font-size:20px;"></i>
                                </button>
                            </div>
                        @elseif($extension == 'pptx')
                            <div class="flex box_file" id="file_container{{ $file_no }}">
                                <a target="_blank" href="/uploads/files/{{ $filename }}">
                                    <i class="fa-solid fa-file-powerpoint" style="color: #ff6600;"></i>
                                    <span class="px-5 dark:text-white">{{ $filename }}</span>
                                    <input type="text" value="{{ $filename }}"
                                        name="file_stored{{ $file_no }}" class="hidden">
                                </a>
                                <button type="button" onclick="remove_file_container({{ $file_no }})">
                                    <i class="fa-solid fa-trash" style="color: #ff0000; font-size:20px;"></i>
                                </button>
                            </div>
                        @elseif($extension == 'docx')
                            <div class="flex box_file" id="file_container{{ $file_no }}">
                                <a target="_blank" href="/uploads/files/{{ $filename }}">
                                    <i class="fa-solid fa-file-word" style="color: #004dd1;"></i>
                                    <span class="px-5 dark:text-white">{{ $filename }}</span>
                                    <input type="text" value="{{ $filename }}"
                                        name="file_stored{{ $file_no }}" class="hidden">
                                </a>
                                <button type="button" onclick="remove_file_container({{ $file_no }})">
                                    <i class="fa-solid fa-trash" style="color: #ff0000; font-size:20px;"></i>
                                </button>
                            </div>
                        @elseif($extension == 'zip')
                            <div class="flex box_file" id="file_container{{ $file_no }}">
                                <a target="_blank" href="/uploads/files/{{ $filename }}">
                                    <i class="fa-solid fa-file-zipper" class="dark:text-blue-100"
                                        style="color: #000000;"></i>
                                    <span class="px-5 dark:text-white">{{ $filename }}</span>
                                    <input type="text" value="{{ $filename }}"
                                        name="file_stored{{ $file_no }}" class="hidden">
                                </a>
                                <button type="button" onclick="remove_file_container({{ $file_no }})">
                                    <i class="fa-solid fa-trash" style="color: #ff0000; font-size:20px;"></i>
                                </button>
                            </div>
                        @else
                        @endif
                    @endif
                    @php
                        $file_qty++;
                        $file_no++;
                    @endphp
                @endforeach
                <input type="text" class="hidden" name="state_stored_file" value="{{ $file_qty }}">
            @endif

        </div>

        </div>

        </div>

        </div>
        @if ($state == 'view')
            <script>
                const form = document.querySelector('#form-submit'); // select your form
                if (form) {
                    form.querySelectorAll('input, select, textarea, button').forEach(el => {
                        el.disabled = true; // disable all fields
                    });
                }
            </script>
        @else
            @if ($asset->deleted == 0)
                <div class="btn_float_right">

                    @if ($master_variant == $variant)
                        <a href="/admin/movement/add/detail/id={{ $master_id }}">
                            <button type="button"
                                class="text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                Movement
                            </button>
                        </a>
                    @endif
                    <button type="button" onclick="search_assets()"
                        class="text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Search
                        Invoice
                    </button>
                    <button type="button" onclick="append_img()" {{-- onclick="{alert('Under maintenance')}" --}}
                        class="text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        <i class="fa-solid fa-image" style="color: #ffffff;"></i>
                    </button>
                    {{-- <button type="button"

                     onclick="{alert('Under maintenance')}"
                        class="text-white update_btn font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        <i class="fa-solid fa-file"></i>
                    </button> --}}
                    @if ($variant == $master_variant)
                        <button type="submit"
                            class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Submit
                        </button>
                    @else
                        <button type="submit"
                            class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Restore <i class="fa-solid fa-download"></i>
                        </button>
                    @endif

                </div>
            @else
                {{-- @if (Auth::user()->role == 'super_admin') --}}
                <div class="btn_float_right">

                    <button type="submit"
                        class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Restore <i class="fa-solid fa-download"></i>
                    </button>

                </div>
                {{-- @endif --}}
            @endif
        @endif
    </form>
    @php
        $defaultDate_invoice = !empty($asset->invoice_date)
            ? \Carbon\Carbon::parse($asset->invoice_date)->format('Y-m-d')
            : '1900-01-01';

        if ($asset->invoice_date == '1900-01-01') {
            $defaultDate_invoice = '1900-01-01';
        }

        $defaultDate_transaction = !empty($asset->transaction_date)
            ? \Carbon\Carbon::parse($asset->transaction_date)->format('Y-m-d')
            : \Carbon\Carbon::now()->format('Y-m-d');

        $defaultDate_dr = !empty($asset->dr_date)
            ? \Carbon\Carbon::parse($asset->dr_date)->format('Y-m-d')
            : \Carbon\Carbon::now()->format('Y-m-d');
    @endphp
    <script>
        flatpickr("#transaction_date", {
            altInput: true, // show pretty date
            altFormat: "d-M-Y", // display format
            dateFormat: "Y-m-d", // value submitted to backend
            defaultDate: "{{ $defaultDate_transaction }}"
        });

        flatpickr("#dr_date", {
            altInput: true,
            altFormat: "d-M-Y",
            dateFormat: "Y-m-d",
            defaultDate: "{{ $defaultDate_dr }}"
        });

        flatpickr("#invoice_date", {
            altInput: true,
            altFormat: "d-M-Y",
            dateFormat: "Y-m-d",
            defaultDate: "{{ $defaultDate_invoice }}",
            clickOpens: false
        });



        document.addEventListener("DOMContentLoaded", function() {
            const input1 = document.getElementById("assets1");
            const select2 = document.getElementById("assets2");
            const labelSpan = document.getElementById("assets12");

            function updateLabel() {
                const val1 = input1.value.trim();
                const val2 = select2.value.trim();
                if (val1 && val2) {
                    labelSpan.textContent = val1 + val2; // concat with '-' already in val2
                } else {
                    labelSpan.textContent = "*"; // fallback if empty
                }
            }

        });

        document.querySelectorAll('#image_show .zoomable').forEach(img => {
            const lens = document.createElement('div');
            lens.classList.add('zoom-lens');
            document.body.appendChild(lens); // append to body for fixed positioning

            let targetX = 0,
                targetY = 0;
            let currentX = 0,
                currentY = 0;
            let targetZoom = 2;
            let currentZoom = 2;
            const zoomStep = 0.2;
            const minZoom = 1;
            const maxZoom = 5;

            img.addEventListener('mousemove', e => {
                targetX = e.clientX;
                targetY = e.clientY;
                lens.style.display = 'block';
            });

            img.addEventListener('mouseleave', () => lens.style.display = 'none');

            img.addEventListener('wheel', e => {
                e.preventDefault();
                targetZoom += e.deltaY < 0 ? zoomStep : -zoomStep;
                targetZoom = Math.max(minZoom, Math.min(maxZoom, targetZoom));
            });

            function animateLens() {
                currentX += (targetX - currentX) * 0.15;
                currentY += (targetY - currentY) * 0.15;
                currentZoom += (targetZoom - currentZoom) * 0.1;

                lens.style.left = (currentX - lens.offsetWidth / 2) + 'px';
                lens.style.top = (currentY - lens.offsetHeight / 2) + 'px';

                const rect = img.getBoundingClientRect();
                const imgX = currentX - rect.left;
                const imgY = currentY - rect.top;

                lens.style.backgroundImage = `url(${img.src})`;
                lens.style.backgroundSize = `${img.width * currentZoom}px ${img.height * currentZoom}px`;
                lens.style.backgroundPosition =
                    `${-imgX * currentZoom + lens.offsetWidth / 2}px ${-imgY * currentZoom + lens.offsetHeight / 2}px`;

                requestAnimationFrame(animateLens);
            }

            animateLens();
        });
        const tabs = document.getElementById('variant_tabs');
        tabs.addEventListener('wheel', (e) => {
            e.preventDefault(); // prevent vertical scroll
            tabs.scrollLeft += e.deltaY; // use vertical scroll to scroll horizontally
        });







        let usersCache = [];

        async function fetchUsers() {
            let companyCode = document.getElementById('company').value.trim();
            let departmentName = document.getElementById('department').value.trim();
            let name = document.getElementById('holder_name').value.trim();
            let id = document.getElementById('asset_holder').value.trim();

            let url = `/users/search?company=${companyCode}&department=${departmentName}&name=${name}&id=${id}`;
            let response = await fetch(url);
            if (!response.ok) return;

            let users = await response.json();
            usersCache = users;

            // Populate Name datalist
            let nameList = document.getElementById('users_list');
            nameList.innerHTML = "";
            users.forEach(user => {
                let option = document.createElement('option');
                option.value = `${user.fname} ${user.lname}`;
                nameList.appendChild(option);
            });

            // Populate ID datalist
            let idList = document.getElementById('asset_list');
            idList.innerHTML = "";
            users.forEach(user => {
                let option = document.createElement('option');
                option.value = user.id_card || user.id;
                idList.appendChild(option);
            });
        }

        // Fill all fields from a user object
        function fillFields(user) {
            document.getElementById('holder_name').value = `${user.fname} ${user.lname}`;
            document.getElementById('asset_holder').value = user.id_card || user.id || '';
            document.getElementById('company').value = user.company?.code || '';
            document.getElementById('department').value = user.department?.name || '';
            document.getElementById('position').value = user.position || '';
        }

        // Select by Name
        function fillUserDetailsByName() {
            let input = document.getElementById('holder_name').value.trim();
            let user = usersCache.find(u => (u.fname + " " + u.lname).trim() === input);
            if (!user) return;
            fillFields(user);
        }

        // Select by ID
        function fillUserDetailsById() {
            let input = document.getElementById('asset_holder').value.trim();
            let user = usersCache.find(u => ((u.id_card || u.id || '').toString().trim() === input));
            if (!user) return;
            fillFields(user);
        }

        // Attach listeners
        ['company', 'department', 'holder_name', 'asset_holder'].forEach(id => {
            document.getElementById(id).addEventListener('input', fetchUsers);
        });

        document.getElementById('holder_name').addEventListener('change', fillUserDetailsByName);
        document.getElementById('asset_holder').addEventListener('change', fillUserDetailsById);







        document.getElementById('clear_user').addEventListener('click', function(e) {
            e.preventDefault(); // prevent any default button behavior

            // Clear all user-related inputs
            document.getElementById('holder_name').value = '';
            document.getElementById('asset_holder').value = '';
            document.getElementById('company').value = '';
            document.getElementById('department').value = '';
            document.getElementById('position').value = '';

            // Clear datalists
            document.getElementById('users_list').innerHTML = '';
            document.getElementById('asset_list').innerHTML = '';

            // Clear cached users
            usersCache = [];
        });
        // Prepare arrays from Blade variables

        const validCompanies = @json($company->pluck('code')); // Array of valid company codes
        const validDepartments = @json($departments->pluck('name')); // Array of valid department names

        // Function to validate inputs with toast
        function validateInputList(inputId, validList, label) {
            const input = document.getElementById(inputId);
            input.addEventListener('blur', () => {
                if (!validList.includes(input.value.trim())) {
                    input.value = ''; // clear if not in valid list

                    // Show toast
                    const toast_red = document.getElementById('toast_red'); // make sure this exists in your HTML
                    toast_red.querySelector("p").textContent = `Invalid ${label}, please select from list`;
                    toast_red.style.display = "block";

                    // Hide toast after 3 seconds
                    setTimeout(() => {
                        toast_red.style.display = "none";
                    }, 3000);
                }
            });
        }

        // Apply validation
        validateInputList('company', validCompanies, 'Company');
        validateInputList('department', validDepartments, 'Department');
    </script>

@endsection
