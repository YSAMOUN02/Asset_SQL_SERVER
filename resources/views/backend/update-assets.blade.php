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
                    name="document" required />
            </div>

            <div class="flex flex-col w-full">
                <label for="no" id="assets_label"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code <span class="text-rose-500">*</span></label>
                <div class="flex w-full">
                    @if (!empty($asset->assets1))
                        <input type="text" id="Asset_Code" name="asset_code1"
                            class="percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->assets }}" />
                    @else
                        <input type="text" id="Asset_Code" name="asset_code1"
                            class="percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                    <input type="text" name="asset_code2" value=""
                        class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">


                </div>
            </div>
            <div>
                <label for="fa_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA-No</label>
                <input type="text" id="fa_no"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="fa_no" />
            </div>
            <div>
                <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                <input type="text" id="item"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="item" />
            </div>
            <div>
                <label for="Issue_Date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue
                    Date</label>
                <input type="datetime-local" id="Issue_Date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ today() }}" name="issue_date" />
            </div>
            <div>
                <label for="Initial_Conditions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initial
                    Conditions</label>
                <input type="text" id="Initial_Conditions"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="intail_condition" />
            </div>

            <div>
                <label for="Specifications"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specifications</label>
                <input type="text" id="Specifications"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="specification" />
            </div>
            <div>
                <div>
                    <label for="item_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item
                        Description</label>

                    <input type="text" id="item_description" name="item_description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />


                </div>
            </div>
            <div>
                <label for="asset_group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Group</label>
                <input type="text" id="asset_group"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_group" />
            </div>

            <div>
                <label for="remark_assets"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_assets"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_assets" />
            </div>
        </div>


        <h1 class="mb-2 title_base dark:text-blue-100">Asset Holder Info</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="Asset_Holder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset Holder
                    ID</label>
                <input type="text" id="Asset_Holder"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_holder" placeholder="INV-90.." />
            </div>
            <div>
                <label for="holder_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="holder_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="holder_name" />
            </div>
            <div>
                <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position/
                    Title</label>
                <input type="text" id="Asset_Holder"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="position" />
            </div>
            <div>
                <label for="Location"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" id="Location"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="location" />
            </div>
            <div>
                <label for="department"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                <select id="department" name="department"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value=""></option>
                    <option value="IT">IT</option>
                    <option value="QA">QA</option>
                    <option value="Purchase">Purchase</option>
                    <option value="HR">HR</option>
                </select>
            </div>
            <div>
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                <select id="small" name="company"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value=""></option>
                    <option value="PPM">PPM</option>
                    <option value="CONFIREL">Confirel</option>
                    <option value="Investco">Invectco</option>
                    <option value="Depomix">Depomix</option>
                </select>
            </div>
            <div>
                <label for="remark_holder"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_holder"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_holder" />
            </div>
        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">Internal Document</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="grn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GRN No</label>
                <input type="text" id="grn"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="grn" />
            </div>
            <div>
                <label for="PO" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PO No</label>
                <input type="text" id="PO"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="po" />
            </div>
            <div>
                <label for="PR" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PR (Purchase
                    Request)</label>
                <input type="text" id="PR"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="pr" />
            </div>
            <div>
                <label for="dr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR (Department
                    Request)</label>
                <input type="text" id="dr" name="dr"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div>
                <label for="dr_requested_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                    (Requested by)</label>
                <input type="text" id="dr_requested_by" name="dr_requested_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>




            <div>
                <div>
                    <label for="dr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR Request
                        Date</label>
                    <input type="datetime-local" id="dr" name="dr_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ today() }}" />
                </div>
            </div>

            <div>
                <label for="remark_internal_doc"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_internal_doc"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_internal_doc" />
            </div>

        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">ERP Invoice</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div class="flex flex-col w-full">
                <label for="no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code (Account)</label>

                @if (!empty($asset->assets))
                    <input type="text" id="asset_code_account" name="asset_code_account" readonly
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $asset->assets }}" />
                @else
                    <input type="text" id="asset_code_account" name="asset_code_account" readonly
                        name="asset_code_account"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" />
                @endif
            </div>
            <div>
                <div>
                    <label for="invoice_posting_date"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Invoice Posting Date</label>
                    @if (!empty($asset->paid_date))
                        <input type="datetime-local" id="invoice_posting_date" name="invoice_posting_date" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->paid_date }}" />
                    @else
                        <input type="datetime-local" id="invoice_posting_date" name="invoice_posting_date" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
            <div>
                <label for="fa_invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                    No</label>
                @if (!empty($asset->invoice_no))
                    <input type="text" id="fa_invoice" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="invoice" value="{{ $asset->invoice_no }}" />
                @else
                    <input type="text" id="fa_invoice" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="invoice" />
                @endif

            </div>

            <div>
                <label for="fa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fix
                    Assets-No</label>

                @if (!empty($asset->fa))
                    <input type="text" id="fa" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="fa" placeholder="" value="{{ $asset->fa }}" />
                @else
                    <input type="text" id="fa" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="fa" placeholder="" />
                @endif

            </div>
            <div>
                <div>
                    <label for="fa_class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA Class
                        Code</label>

                    @if (!empty($asset->fa_class_code))
                        <input type="text" id="fa_class" name="fa_class" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->fa_class_code }}" />
                    @else
                        <input type="text" id="fa_class" name="fa_class" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>

            <div>
                <div>
                    <label for="FA_Subclass_Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Subclass Code</label>
                    @if (!empty($asset->fa_subclass))
                        <input type="text" id="FA_Subclass_Code" name="fa_subclass" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->fa_subclass }}" />
                    @else
                        <input type="text" id="FA_Subclass_Code" name="fa_subclass" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>

            <div>
                <div>
                    <label for="depreciation_book_code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Depreciation Book Code</label>
                    @if (!empty($asset->depreciation))
                        <input type="text" id="depreciation_book_code" name="depreciation_book_code" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->depreciation }}" />
                    @else
                        <input type="text" id="depreciation_book_code" name="depreciation_book_code" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>

            <div>
                <div>
                    <label for="fa_posting_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Posting Type</label>

                    @if (!empty($asset->type))
                        <input type="text" id="fa_posting_type" name="fa_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->type }}" readonly />
                    @else
                        <input type="text" id="fa_posting_type" name="fa_type" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
            <div>
                <div>
                    <label for="fa_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Location</label>

                    @if (!empty($asset->fa_location))
                        <input type="text" id="fa_location" name="fa_location"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->fa_location }}" readonly />
                    @else
                        <input type="text" id="fa_location" name="fa_location" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>

            <div class="flex flex-col w-full">
                <label for="no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost &
                    Vat</label>
                <div class="flex w-full">
                    @if (!empty($asset->cost))
                        <input type="text" id="cost" name="cost" readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ (float) $asset->cost }}" />
                    @else
                        <input type="text" id="cost" name="cost" readonly
                            class="percent7 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif
                    @if (!empty($asset->currency))
                        <input type="text" id="currency" name="currency" value="{{ $asset->currency }}" readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @else
                        <input type="text" id="currency" value="" name="currency" readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @endif

                    @if (!empty($asset->vat))
                        <input type="text" id="vat" name="vat" value="Vat {{ (float) $asset->vat }}"
                            readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @else
                        <input type="text" id="vat" name="vat" value="" readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @endif
                </div>
            </div>
            <div>
                <div>
                    <label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    @if (!empty($asset->description))
                        <input type="text" id="description" name="description" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->description }}" />
                    @else
                        <input type="text" id="description" name="description" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>

            <div>
                <div>
                    <label for="invoice_description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Description</label>
                    @if (!empty($asset->description))
                        <input type="text" id="invoice_description" name="invoice_description" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->fa_description }}" />
                    @else
                        <input type="text" id="invoice_description" name="invoice_description" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

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
