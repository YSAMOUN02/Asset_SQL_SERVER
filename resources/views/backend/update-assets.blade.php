@extends('backend.master')
@section('content')
    <form class="p-5 dark:bg-gray-900" enctype="multipart/form-data" action="/admin/assets/update/submit" method="POST">
        @csrf
        <h1 class="title_base dark:text-blue-100">Asset Info</h1>
     
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="Reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference <span
                        class="text-rose-500">*</span></label>
                <input type="text" id="Reference"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="document" value="{{ old('document', $asset->document ?? '') }}" required />
                <input type="text" class="hidden" name="id" value="{{ $asset->assets_id }}">
            </div>

            <div class="flex flex-col w-full">
                <label for="no" id="assets_label"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code <span class="text-rose-500">*</span></label>
                <div class="flex w-full">
                    @if (!empty($asset->assets1))
                        <input type="text" id="Asset_Code" name="asset_code1"
                            class="percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->assets1 }}" />
                    @else
                        <input type="text" id="Asset_Code" name="asset_code1"
                            class="percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif
                    @if (!empty($asset->assets2))
                        <input type="text" name="asset_code2" value="{{ $asset->assets2 }}"
                            class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @else
                        <input type="text" name="asset_code2" value=""
                            class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @endif

                </div>
            </div>
            <div>
                <label for="fa_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA-No</label>
                <input type="text" id="fa_no" value="{{ old('fa_no', $asset->fa_no ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="fa_no" />
            </div>
            <div>
                <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                <input type="text" id="item" value="{{ old('item', $asset->item ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="item" />
            </div>
            <div>
                <label for="Issue_Date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue
                    Date</label>
                <input type="date" id="Issue_Date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('issue_date', $asset->issue_date, today()) }}" name="issue_date" />
            </div>
            <div>
                <label for="Initial_Conditions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initial
                    Conditions</label>
                <input type="text" id="Initial_Conditions"
                    value="{{ old('intail_condition', $asset->initial_condition ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="intail_condition" />
            </div>

            <div>
                <label for="Specifications"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specifications</label>
                <input type="text" id="Specifications" value="{{ old('specification', $asset->specification ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="specification" />
            </div>
            <div>
                <div>
                    <label for="item_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item
                        Description</label>

                    <input type="text" id="item_description" name="item_description"
                        value="{{ old('item_description', $asset->item_description ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />


                </div>
            </div>
            <div>
                <label for="asset_group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Group</label>
                <input type="text" id="asset_group" value="{{ old('asset_group', $asset->asset_group ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_group" />
            </div>

            <div>
                <label for="remark_assets"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_assets" value="{{ old('remark_assets', $asset->remark_assets ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_assets" />
            </div>
        </div>


        <h1 class="mb-2 title_base dark:text-blue-100">Asset Holder Info</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="Asset_Holder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset Holder
                    ID</label>
                <input type="text" id="Asset_Holder" value="{{ old('asset_holder', $asset->asset_holder ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_holder" placeholder="INV-90.." />
            </div>
            <div>
                <label for="holder_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="holder_name" value="{{ old('holder_name', $asset->holder_name ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="holder_name" />
            </div>
            <div>
                <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position/
                    Title</label>
                <input type="text" id="Asset_Holder" value="{{ old('position', $asset->position ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="position" />
            </div>
            <div>
                <label for="Location"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" id="Location" value="{{ old('location', $asset->location ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="location" />
            </div>
            <div>
                <label for="department"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                <select id="department" name="department"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if (!empty($asset->department))
                        <option value="{{ $asset->department }}">{{ $asset->department }}</option>
                    @endif
                    @if (!empty($department))
                        @foreach ($department as $item)
                            @if ($item->content != $asset->department)
                                <option value="{{ $item->content }}">{{ $item->content }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div>
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                <select id="small" name="company"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if (!empty($asset->company))
                        <option value="{{ $asset->company }}">{{ $asset->company }}</option>
                    @endif
                    @if (!empty($company))
                        @foreach ($company as $item)
                            @if ($item->content != $asset->company)
                                <option value="{{ $item->content }}">{{ $item->content }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div>
                <label for="remark_holder"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_holder"  value="{{ old('remark_internal_doc', $asset->remark_internal_doc ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_holder" />
            </div>
        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">Internal Document</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="grn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GRN No</label>
                <input type="text" id="grn" value="{{ old('grn', $asset->grn ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="grn" />
            </div>
            <div>
                <label for="PO" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PO No</label>
                <input type="text" id="PO"  value="{{ old('po', $asset->po ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="po" />
            </div>
            <div>
                <label for="PR" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PR (Purchase
                    Request)</label>
                <input type="text" id="PR" value="{{ old('pr', $asset->pr ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="pr" />
            </div>
            <div>
                <label for="dr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR (Department
                    Request)</label>
                <input type="text" id="dr" name="dr"  value="{{ old('dr', $asset->dr ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div>
                <label for="dr_requested_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                    (Requested by)</label>
                <input type="text" id="dr_requested_by" name="dr_requested_by"  value="{{ old('dr_requested_by', $asset->dr_requested_by ?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>




            <div>
                <div>
                    <label for="drdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR Request
                        Date</label>
                    <input type="date" id="drdate" name="dr_date" value="{{ old('dr_date', $asset->dr_date ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       />
                </div>
            </div>

            <div>
                <label for="remark_internal_doc"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_internal_doc" value="{{ old('remark_internal_doc', $asset->remark_internal_doc?? '') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_internal_doc" />
            </div>

        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">ERP Invoice</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div class="flex flex-col w-full">
                <label for="no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code (Account)</label>

     
                    <input type="text" id="asset_code_account" name="asset_code_account" readonly
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $asset->asset_code_account ?? '' }}" />
       
            </div>
            <div>
                <div>
                    <label for="invoice_posting_date"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Invoice Posting Date</label>
                  
                        <input type="date" id="invoice_posting_date" name="invoice_posting_date" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('invoice_posting_date', $asset->invoice_date?? '') }}" />
               

                </div>
            </div>
            <div>
                <label for="fa_invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                    No</label>

                    <input type="text" id="fa_invoice" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="invoice"   value="{{ old('invoice', $asset->invoice_no?? '') }}"/>
          

            </div>

            <div>
                <label for="fa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fix
                    Assets-No</label>

                    <input type="text" id="fa" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="fa" placeholder=""  value="{{ old('fa', $asset->fa?? '') }}" />
             

            </div>
            <div>
                <div>
                    <label for="fa_class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA Class
                        Code</label>

                        <input type="text" id="fa_class" name="fa_class" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('fa_class', $asset->fa_class?? '') }}" />
                 

                </div>
            </div>

            <div>
                <div>
                    <label for="FA_Subclass_Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Subclass Code</label>

                        <input type="text" id="FA_Subclass_Code" name="fa_subclass" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('fa_class', $asset->fa_class?? '') }}"  />
                   

                </div>
            </div>

            <div>
                <div>
                    <label for="depreciation_book_code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Depreciation Book Code</label>

                        <input type="text" id="depreciation_book_code" name="depreciation_book_code" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                             value="{{ old('depreciation_book_code', $asset->depreciation?? '') }}" />
               

                </div>
            </div>

            <div>
                <div>
                    <label for="fa_posting_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Posting Type</label>

        
                        <input type="text" id="fa_posting_type" name="fa_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('fa_type', $asset->fa_type?? '') }}"    readonly />
          

                </div>
            </div>
            <div>
                <div>
                    <label for="fa_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Location</label>

                        <input type="text" id="fa_location" name="fa_location"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('fa_location', $asset->fa_location?? '') }}"  readonly />
               

                </div>
            </div>

            <div class="flex flex-col w-full">
                <label for="no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost &
                    Vat</label>
                <div class="flex w-full">
           
                        <input type="text" id="cost" name="cost" readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ old('cost', (float) $asset->cost?? '') }}" />
                   
                        <input type="text" id="currency" name="currency"          value="{{ old('currency',  $asset->currency?? '') }}"  readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
               

                        <input type="text" id="vat" name="vat"     value="{{ old('vat',$asset->vat?? '') }}"
                            readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  
                </div>
            </div>
            <div>
                <div>
                    <label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
  
                 
                            <textarea id="description" name="description" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description', $asset->description ?? '') }}</textarea>

                </div>
            </div>

            <div>
                <div>
                    <label for="invoice_description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Description</label>
       
                        <textarea id="invoice_description" name="invoice_description" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('invoice_description', $asset->invoice_description ?? '') }}</textarea>

                </div>
            </div>
        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">Vendor Info</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">

            <div>
                <div>
                    <label for="vendor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
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
                    <label for="vendor_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
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
                    @if (!empty($asset->Address))
                        <input type="text" id="address" name="address" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->Address }}" />
                    @else
                        <input type="text" id="address" name="address" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

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

                    @if (!empty($asset->Contact))
                        <input type="text" id="contact" name="contact" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->Contact }}" />
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
        <div>
           <a href="">
             {{$qr_code}}
           </a>
        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">Image </h1>
        <input type="text" class="hidden" name="image_state" value="0" id="image_state">
        <input type="text" class="hidden" name="file_state" value="0" id="file_state">
        <div id="image_show" class="grid gap-6 mb-6 grid-cols-1 lg:grid-cols-4 md:grid-cols-4">

        </div>
        </div>

        <h1 class="mb-2 title_base dark:text-blue-100">Other FIle</h1>
        <div id="container_file" class="grid gap-6 mb-6 grid-cols-1 lg:grid-cols-4 md:grid-cols-2">


        </div>


        <div class="btn_float_right">
            <button type="button" onclick="append_img()"
                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-image" style="color: #ffffff;"></i>
            </button>
            <button type="button" onclick=" append_file()"
                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-file"></i>
            </button>
            <button type="submit"
                class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Submit
            </button>
        </div>
    </form>
@endsection
