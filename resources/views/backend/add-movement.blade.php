@extends('backend.master')
@section('content')
    <div class="table_select">
        <div class="select_id_assets">


        </div>

    </div>
    <form class="p-2 lg:p-10 py-2 lg:py-15 dark:bg-gray-900" enctype="multipart/form-data" action="/admin/movement/add/submit" method="POST">
        @csrf
        <h1 class="title_base dark:text-blue-100">Movement Info</h1>
        <div class="grid grid-cols-2 gap-6 mb-6 md:grid-cols-2">
            <div>

                <label for="movement_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Movement
                    Date</label>
                <input type="datetime-local" id="movement_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ today() }}" name="movement_date" />

            </div>
            <div>
                <label for="movement_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Movement No<span
                        class="text-rose-500">*</span></label>
                <input type="text" id="movement_no"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="movement_no" required />
            </div>
            <div>
                <label for="reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference <span
                        class="text-rose-500">*</span></label>
                <input type="text" id="reference"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="reference"  />
            </div>



          
        </div>

        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">


            <div class="grid gap-6 lg:grid-cols-1 md:grid-cols-1">
                <span class="title_base text-lg dark:text-blue-100">Movement From</span>
                


                <div>
                    <label for="from_department"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">From Department</label>
                    
                        

                        @if(!empty($department))
                            <select id="from_department"  name="from_department"
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>
                                @foreach ($department as $item)
                                <option value="{{$item->content}}">{{$item->content}}</option>
                                @endforeach
                            </select>
                        @else 
                        <input type="text" id="from_department"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="from_department" />
                        @endif
                </div>
                <div>
                    <label for="from_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">From
                        Name</label>
                    <input type="text" id="from_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="from_name" />
                </div>
                <div>
                    <label for="from_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                        Location <span class="text-rose-500">*</span></label>
                    <input type="text" id="from_location"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="from_location"  />
                </div>
                <div>
                    <label for="given_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Given
                        by</label>
                        @if(!empty($given_by))
                        <select  id="to_department"      name="to_department"
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=""></option>
                            @foreach ($given_by as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    @else 
                        <input type="text" id="given_by"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="given_by" />
                    @endif
                </div>
         
                <div>
                    <label for="from_remark"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                    <input type="text" id="from_remark"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="from_remark" />
                </div>
            </div>



            <div class="grid gap-6 lg:grid-cols-1 md:grid-cols-1">
                <span class="title_base text-lg dark:text-blue-100">Movement To</span>
              
                <div>
                    <label for="to_department"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To Department</label>
                  

                    @if(!empty($department))
                        <select  id="to_department"      name="to_department"
                            class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=""></option>
                            @foreach ($department as $item)
                            <option value="{{$item->content}}">{{$item->content}}</option>
                            @endforeach
                        </select>
                    @else 
                    <input type="text" id="to_department"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="to_department" />
                    @endif
                </div>
                <div>
                    <label for="to_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To
                        Name</label>
                    <input type="text" id="to_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="to_name" />
                </div>
                <div>
                    <label for="to_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                        Location</label>
                    <input type="text" id="to_location"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="to_location" />
                </div>
                <div>
                    <label for="received_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Received
                        Date</label>
                    <input type="datetime-local" id="received_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ today() }}" name="received_date" />
                </div>
                <div>
                    <label for="received_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Received
                        by</label>
                    <input type="text" id="received_by"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="received_by" />
                </div>
            </div>


        </div>
        <h1 class="title_base dark:text-blue-100">Other Information</h1>
        <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-3">
            <div>
                <label for="condition" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Conditions
                </label>
                <textarea id="condition" name="condition" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
            </div>
            <div>
                <label for="purpose" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Purpose
                </label>
                <textarea id="purpose" name="purpose" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
            </div>
            <div>
                <label for="verify_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Verify By
                </label>
                <input type="text" id="verify_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="verify_by" />
            </div>
            <div>
                <label for="authorized_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Authorized
                    by</label>
                <input type="text" id="authorized_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="authorized_by" />
            </div>
        </div>


        </div>

        {{-- Assets Data  --}}
        <div id="accordion-flush" data-accordion="collapse"
            data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white pb-5"
            data-inactive-classes="text-gray-500 dark:text-gray-400">


            <h2 id="accordion-flush-heading-3">
                <button type="button"
                    class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                    data-accordion-target="#accordion-flush-body-3" aria-expanded="false"
                    aria-controls="accordion-flush-body-3">
                    <h1 class="title_base dark:text-blue-100">Assets Info</h1>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                <div class="py-1 lg:py-5  border-b border-gray-200 dark:border-gray-700">

                    <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
                        <div class="hidden">
   
                            <input type="text" id="Reference" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="id_assets" value="{{ old('id', $asset->id ?? '') }}"  />
                                <input type="text" id="Reference" readonly
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="varaint" value="{{ old('id', $asset->varaint ?? '') }}"  />
                        </div>
                        
                        <div>
                            <label for="Reference"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" id="Reference" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="document" value="{{ old('document', $asset->document ?? '') }}"  />

                        </div>

                        <div>
                            <label for="no" id="assets_label"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset Code <span
                                    class="text-rose-500">*</span></label>

                            <input type="text" id="Reference" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="document" value="{{ old('document', $asset->assets1 . $asset->assets2 ?? '') }}" />


                        </div>

                        <div>
                            <label for="fa_no"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA-No</label>
                            <input type="text" id="fa_no" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="fa_no" value="{{ old('fa_no', $asset->fa_no ?? '') }}" />
                        </div>

                        <div>
                            <label for="item"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                            <input type="text" id="item" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="item" value="{{ old('item', $asset->item ?? '') }}" />
                        </div>

                        <div>
                            <label for="Issue_Date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue
                                Date</label>
                            <input type="date" id="Issue_Date" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('issue_date', $asset->issue_date, today()) }}" name="issue_date" />
                        </div>

                        <div>
                            <label for="Initial_Conditions"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initial
                                Conditions</label>
                            <input type="text" id="initial_Conditions"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="intail_condition" readonly
                                value="{{ old('intail_condition', $asset->initial_condition ?? '') }}" />
                        </div>

                        <div>
                            <label for="Specifications"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specifications</label>
                            <input type="text" id="Specifications" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="specification" value="{{ old('specification', $asset->specification ?? '') }}" />
                        </div>

                        <div>
                            <label for="item_description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item
                                Description</label>
                            <input type="text" id="item_description" name="item_description" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('item_description', $asset->item_description ?? '') }}" />
                        </div>

                        <div>
                            <label for="asset_group"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                                Group</label>
                            <input type="text" id="asset_group" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="asset_group" value="{{ old('asset_group', $asset->asset_group ?? '') }}" />
                        </div>

                        <div>
                            <label for="remark_assets"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                            <input type="text" id="remark_assets" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="remark_assets" value="{{ old('remark_assets', $asset->remark_assets ?? '') }}" />
                        </div>
                    </div>



                    <h1 class="mb-2 title_base dark:text-blue-100">Asset Holder Info</h1>
                    <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
                        <div>
                            <label for="asset_holder"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                                Holder ID</label>
                            <input type="text" id="asset_holder"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="asset_holder" value="{{ old('asset_holder', $asset->asset_holder ?? '') }}"
                                readonly placeholder="INV-90.." />
                        </div>
                        <div>
                            <label for="holder_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" id="holder_name" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="holder_name" value="{{ old('holder_name', $asset->holder_name ?? '') }}" />
                        </div>
                        <div>
                            <label for="position"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position/Title</label>
                            <input type="text" id="position" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="position" value="{{ old('position', $asset->position ?? '') }}" />
                        </div>
                        <div>
                            <label for="location"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                            <input type="text" id="location" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="location" value="{{ old('location', $asset->location ?? '') }}" />
                        </div>
                        <div>
                            <label for="department"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                            <select id="department" name="department" readonly
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>

                            </select>
                        </div>
                        <div>
                            <label for="company"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                            <select id="company" name="company" readonly
                                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>

                            </select>
                        </div>
                        <div>
                            <label for="remark_holder"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                            <input type="text" id="remark_holder" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="remark_holder" value="{{ old('remark_holder', $asset->remark_holder ?? '') }}" />
                        </div>
                    </div>

                    <h1 class="mb-2 title_base dark:text-blue-100">Internal Document</h1>
                    <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
                        <div>
                            <label for="grn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GRN
                                No</label>
                            <input type="text" id="grn" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="grn" value="{{ old('grn', $asset->grn ?? '') }}" />
                        </div>
                        <div>
                            <label for="po" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PO
                                No</label>
                            <input type="text" id="po" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="po" value="{{ old('po', $asset->po ?? '') }}" />
                        </div>
                        <div>
                            <label for="pr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PR
                                (Purchase
                                Request)</label>
                            <input type="text" id="pr" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="pr" value="{{ old('pr', $asset->pr ?? '') }}" />
                        </div>
                        <div>
                            <label for="dr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                                (Department
                                Request)</label>
                            <input type="text" id="dr" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="dr" value="{{ old('dr', $asset->dr ?? '') }}" />
                        </div>
                        <div>
                            <label for="dr_requested_by"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                                (Requested by)</label>
                            <input type="text" id="dr_requested_by" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="dr_requested_by"
                                value="{{ old('dr_requested_by', $asset->dr_requested_by ?? '') }}" />
                        </div>
                        <div>
                            <label for="dr_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                                Request
                                Date</label>
                            <input type="date" id="dr_date" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="dr_date" value="{{ old('dr_date', $asset->dr_date, today()) }}" />


                        </div>
                        <div>
                            <label for="remark_internal_doc"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                            <input type="text" id="remark_internal_doc" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="remark_internal_doc"
                                value="{{ old('remark_internal_doc', $asset->remark_internal_doc ?? '') }}" />
                        </div>
                    </div>

                    <h1 class="mb-2 title_base dark:text-blue-100">ERP Invoice</h1>
                    <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
                        <!-- Asset Code (Account) -->
                        <div class="flex flex-col w-full">
                            <label for="asset_code_account"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                                Code (Account)</label>
                            <input type="text" id="asset_code_account" name="asset_code_account" readonly
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->asset_code_account ?? '' }}" />
                        </div>

                        <!-- Invoice Posting Date -->
                        <div>
                            <label for="invoice_posting_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Posting
                                Date</label>
                            <input type="date" id="invoice_posting_date" name="invoice_posting_date" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->invoice_date ?? '' }}" />
                        </div>

                        <!-- Invoice No -->
                        <div>
                            <label for="fa_invoice"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                                No</label>
                            <input type="text" id="fa_invoice" name="invoice" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->invoice_no ?? '' }}" />
                        </div>

                        <!-- Fix Assets-No -->
                        <div>
                            <label for="fa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fix
                                Assets-No</label>
                            <input type="text" id="fa" name="fa" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->fa ?? '' }}" />
                        </div>

                        <!-- FA Class -->
                        <div>
                            <label for="fa_class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                                Class</label>
                            <input type="text" id="fa_class" name="fa_class" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->fa_class ?? '' }}" />
                        </div>

                        <!-- FA Subclass Code -->
                        <div>
                            <label for="FA_Subclass_Code"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                                Subclass Code</label>
                            <input type="text" id="FA_Subclass_Code" name="fa_subclass" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->fa_subclass ?? '' }}" />
                        </div>

                        <!-- Depreciation Book Code -->
                        <div>
                            <label for="depreciation_book_code"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Depreciation Book
                                Code</label>
                            <input type="text" id="depreciation_book_code" name="depreciation_book_code" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->depreciation ?? '' }}" />
                        </div>

                        <!-- FA Posting Type -->
                        <div>
                            <label for="fa_posting_type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                                Posting Type</label>
                            <input type="text" id="fa_posting_type" name="fa_type" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->fa_type ?? '' }}" />
                        </div>

                        <!-- FA Location -->
                        <div>
                            <label for="fa_location"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                                Location</label>
                            <input type="text" id="fa_location" name="fa_location" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->fa_location ?? '' }}" />
                        </div>

                        <!-- Cost & VAT -->
                        <div class="flex flex-col w-full">
                            <label for="cost"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost &
                                VAT</label>
                            <div class="flex w-full">
                                <input type="text" id="cost" name="cost" readonly
                                    class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $asset->cost ? number_format((float) $asset->cost, 2) : '' }}" />
                                <input type="text" id="currency" name="currency" readonly
                                    class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $asset->currency ?? '' }}" />
                                <input type="text" id="vat" name="vat" readonly
                                    class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $asset->vat ?? '' }}" />
                            </div>
                        </div>

                        <div class="flex flex-col w-full">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description
                            </label>
                            <textarea id="description" name="description" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description', $asset->description ?? '') }}
                </textarea>
                        </div>

                        <div class="flex flex-col w-full">
                            <label for="invoice_description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Invoice Description
                            </label>
                            <textarea id="invoice_description" name="invoice_description" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('invoice_description', $asset->invoice_description ?? '') }}
                </textarea>
                        </div>

                    </div>


                    <h1 class="mb-2 title_base dark:text-blue-100">Vendor Info</h1>
                    <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">

                        <div>
                            <div>
                                <label for="vendor"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
                                    No</label>

                                @if (!empty($asset->vendor))
                                    <input type="text" id="vendor" name="vendor" readonly
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        value="{{ $asset->vendor }}" />
                                @else
                                    <input type="text" id="vendor" name="vendor" readonly
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                @endif

                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="vendor_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
                                    Name</label>
                                @if (!empty($asset->vendor_name))
                                    <input type="text" id="vendor_name" name="vendor_name" readonly
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        value="{{ $asset->vendor_name }}" />
                                @else
                                    <input type="text" id="vendor_name" name="vendor_name" readonly
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                @endif

                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                @if (!empty($asset->address))
                                    <input type="text" id="address" name="address" readonly
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        value="{{ $asset->address }}" />
                                @else
                                    <input type="text" id="address" name="address" readonly
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                @endif

                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="address2"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address
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
                    <h1 class="mb-2 title_base dark:text-blue-100">QR Code  </h1>
                    <div id="qr_code">
                        <a target="_blank"
                            href="/admin/qr/code/print/assets={{ $asset->assets1 . $asset->assets2 }}">
                      
                            {!! QrCode::size(150)->generate($asset->assets1 . $asset->assets2) !!}
                        </a>
            
            
                    </div>
                    <h1 class="mb-2 title_base dark:text-blue-100">Image </h1>
                    <input type="text" class="hidden" name="image_state" value="0" id="image_state">
                    <input type="text" class="hidden" name="file_state" value="0" id="file_state">
                    <div id="image_show" class="grid gap-6 mb-6 grid-cols-1 lg:grid-cols-4 md:grid-cols-4">
                        @if (!empty($asset))
                            @if (!empty($asset->images))
                                @php
                                    $image_qty = 0;
                                    $image_no = 1;

                                @endphp

                                @foreach ($asset->images as $item)
                                    @if ($item->varaint == $asset->varaint)
                                        <div class="image_box" id="image_box_varaint{{ $item->id }}">
                                            <img src="/uploads/image/{{ $item->image }}"
                                                onclick="maximize_minimize({{ $item->id }})" alt="Item">


                                            <a download="{{ $item->image }}"
                                                href="/uploads/image/{{ $item->image }}"><button type="button"
                                                    id="download_image"><i class="fa-regular fa-circle-down"
                                                        style="color: #71bd00;"></i></button></a>
                                            <input type="text" value="{{ $item->image }}"
                                                name="image_stored{{ $image_no }}" class="hidden">
                                        </div>
                                        @php

                                            $image_qty++;
                                            $image_no++;

                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <h1 class="mb-2 title_base dark:text-blue-100">Other FIle</h1>
                    <div id="container_file"
                        class="grid justify-start gap-6 mb-6 grid-cols-1 lg:grid-cols-1 md:grid-cols-1">

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
                                @if ($item->varaint == $asset->varaint)
                                    @if ($extension == 'xlsx')
                                        <div class="flex box_file" id="file_container{{ $file_no }}">
                                            <a target="_blank" href="/uploads/files/{{ $filename }}">
                                                <i class="fa-solid fa-file-excel" style=" color: #009d0a;"></i>
                                                <span class="px-5 dark:text-white">{{ $filename }}</span>
                                                <input type="text" value="{{ $filename }}"
                                                    name="file_stored{{ $file_no }}" class="hidden">
                                            </a>

                                        </div>
                                    @elseif($extension == 'pdf')
                                        <div class="flex box_file" id="file_container{{ $file_no }}">
                                            <a target="_blank" href="/uploads/files/{{ $filename }}">
                                                <i class="fa-solid fa-file-pdf" style="color: #ff0000;"></i>
                                                <span class="px-5 dark:text-white">{{ $filename }}</span>
                                                <input type="text" value="{{ $filename }}"
                                                    name="file_stored{{ $file_no }}" class="hidden">
                                            </a>

                                        </div>
                                    @elseif($extension == 'pptx')
                                        <div class="flex box_file" id="file_container{{ $file_no }}">
                                            <a target="_blank" href="/uploads/files/{{ $filename }}">
                                                <i class="fa-solid fa-file-powerpoint" style="color: #ff6600;"></i>
                                                <span class="px-5 dark:text-white">{{ $filename }}</span>
                                                <input type="text" value="{{ $filename }}"
                                                    name="file_stored{{ $file_no }}" class="hidden">
                                            </a>

                                        </div>
                                    @elseif($extension == 'docx')
                                        <div class="flex box_file" id="file_container{{ $file_no }}">
                                            <a target="_blank" href="/uploads/files/{{ $filename }}">
                                                <i class="fa-solid fa-file-word" style="color: #004dd1;"></i>
                                                <span class="px-5 dark:text-white">{{ $filename }}</span>
                                                <input type="text" value="{{ $filename }}"
                                                    name="file_stored{{ $file_no }}" class="hidden">
                                            </a>

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

                                        </div>
                                    @else
                                    @endif
                                @endif
                                @php
                                    $file_qty++;
                                    $file_no++;
                                @endphp
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>


        <div class="btn_float_right">

            <button type="submit" 
                class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Submit
            </button>
        </div>
    </form>
@endsection
