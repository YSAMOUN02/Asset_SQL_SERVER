@extends('backend.master')
@section('content')
@section('header')
  Asset Add Form
@endsection
@section('style')
   <span class="ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
                 class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Form Assets Registration</span>
</span>

@endsection
<style>
@media print {
    body * {
        visibility: hidden; /* hide everything */
    }
    #form_assets, #form_assets * {
        visibility: visible; /* show only the form */
    }
    #form_assets {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    button {
        display: none; /* hide buttons */
    }
    .hide_print{
        display: none
    }
}
</style>
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>

<div class="table_select">
    <div class="select_id_assets">


    </div>

</div>



<form class=" p-4 py-1  lg:p-10 lg:py-10 md:p-2  md:py-2 bg-white dark:bg-gray-900 de" enctype="multipart/form-data"
    action="/admin/assets/add/submit" method="POST" id="form_assets">
    @csrf
    <h1 class="title_base text-black dark:text-blue-100">Asset Info</h1>
    <div class="grid gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2 lg:grid-cols-2 md:grid-cols-2">
        <div>
            <label for="Reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference <span
                    class="text-rose-500">*</span></label>
            <input type="text" id="Reference"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="reference" required />
        </div>

        <div class="flex flex-col w-full">
            <label for="no" id="assets_label"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                Code <span class="text-rose-500">*</span></label>
            <div class="flex w-full">
                @if (!empty($asset->assets))
                    <input type="text" id="asset_Code1" name="assets1" readonly
                        class="p-2.5 percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $asset->assets }}" />
                @else
                    <input type="text" id="asset_Code1" name="assets1" required
                        class="p-2.5 percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                @endif

                {{-- <input type="text" name="assets2" value="" placeholder="Department Code" class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    > --}}

                <select type="text" name="assets2" required placeholder="Department Code"
                    class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected></option>
                    <option value="MT">MT</option>
                    <option value="IT">IT</option>
                    <option value="HR">HR</option>
                </select>
            </div>
        </div>
        <div>
            <label for="fa_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA-No</label>
            <input type="text" id="fa_no"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="fa_no" />
        </div>
        <div>
            <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item <span
                    class="text-rose-500">*</span></label>
            <input type="text" id="item"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="item" required />
        </div>
        <div>
            <label for="transaction_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue
                Date</label>
            <input type="text" id="transaction_date" name="transaction_date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />


        </div>
        <div>
            <label for="Initial_Conditions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initial
                Conditions <span class="text-rose-500">*</span></label>
            <input type="text" id="Initial_Conditions"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="initial_condition" required />
        </div>

        <div>
            <label for="Specifications"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specifications <span
                    class="text-rose-500">*</span></label>
            <input type="text" id="Specifications"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="specification" required />
        </div>
        <div>
            <div>
                <label for="item_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item
                    Description <span class="text-rose-500">*</span></label>

                <input type="text" id="item_description" name="item_description" required
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
            <label for="old_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Code
                (Optional)</label>
            <input type="text" id="old_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="old_code" />
        </div>
        <div>
            <label for="remark_assets"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
            <input type="text" id="remark_assets"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="remark_assets" />
        </div>
    </div>


    <h1 class="mb-2 title_base text-black dark:text-blue-100">Asset Holder Info</h1>
    <div class="grid gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
        <div>
            <label for="Asset_Holder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                Holder
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

            <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Department <span class="text-rose-500">*</span>
            </label>

            <input list="departments_list" id="department" name="department" required
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Start typing department...">
            @php $departments = [ 'Accounting & Finance', 'Administration & HR', 'Management', 'Maintenance', 'Planning', 'Purchase', 'Regulatory Affairs', 'External Project & Special Project', 'Warehouse', 'Logistic', 'MIS', 'Consultant', 'Accounting & Finance', 'Research & Development', 'Commercial', 'Regulatory Affairs', 'Production', 'Quality Control', 'Maintenance', 'Warehouse', 'Management', 'Quality Assurance', 'Pizza Project', 'Kitchen Center', 'Consultant', 'Commercial', 'Production', 'Export and Marketing', 'Quality Assurance', 'Quality Control', 'Research & Development', 'Quality Production', 'Order', ]; @endphp
            <datalist id="departments_list">
                @foreach ($departments as $department)
                    <option value="{{ $department }}"></option>
                @endforeach
            </datalist>
        </div>
        <div>
            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company <span
                    class="text-rose-500">*</span></label>
            <select id="company" name="company" required
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected></option>
                <option value="CFR">CFR</option>
                <option value="Depomex">Depomex</option>
                <option value="INV">INV</option>
                <option value="Other">Other</option>
                <option value="PPM">PPM</option>
                <option value="PPM&Confirel">PPM&Confirel</option>
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
    <h1 class="mb-2 title_base text-black dark:text-blue-100">Internal Document</h1>
    <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
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
                <label for="dr_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR Request
                    Date</label>
                <input type="datetime-local" id="dr_date" name="dr_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
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



    {{-- -----------------------------------------------------------------------------------ACOUNT DATA _--------------------------------------------------- --}}

    @if ($no_invoice == 1)
        <h1 class="mb-2 title_base text-black dark:text-blue-100">ERP Invoice</h1>
        <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">
            <div class="flex flex-col w-full">
                <label for="no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code (Account)</label>

                @if (!empty($asset->assets))
                    <input type="text" id="asset_code_account" name="asset_code_account" readonly
                        class="w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $asset->assets }}" />
                @else
                    <input type="text" id="asset_code_account" name="asset_code_account" readonly
                        name="asset_code_account"
                        class="w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" />
                @endif
            </div>
            <div>
                <div>
                    <label for="invoice_posting_date"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Invoice Posting Date</label>
                    @if (!empty($asset->paid_date))
                        <input type="text" id="invoice_posting_date" name="invoice_date" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @else
                        <input type="text" id="invoice_posting_date" name="invoice_date" readonly
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
                        name="invoice_no" value="{{ $asset->invoice_no }}" />
                @else
                    <input type="text" id="fa_invoice" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="invoice_no" />
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
                    <label for="fa_class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                        Class
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
                    <label for="FA_Subclass_Code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
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
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Depreciation Book
                        Code</label>
                    @if (!empty($asset->depreciation))
                        <input type="text" id="depreciation_book_code" name="depreciation" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->depreciation }}" />
                    @else
                        <input type="text" id="depreciation_book_code" name="depreciation" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>

            <div>
                <div>
                    <label for="fa_posting_type"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
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
                            class="percent3 bg-gray-50 p-2.5 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ (float) $asset->cost }}" />
                    @else
                        <input type="text" id="cost" name="cost" readonly
                            class="percent7 px-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif
                    @if (!empty($asset->currency))
                        <input type="text" id="currency" name="currency" value="{{ $asset->currency }}"
                            readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @else
                        <input type="text" id="currency" value="" name="currency" readonly
                            class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @endif

                    @if (!empty($asset->vat))
                        <input type="text" id="vat" name="vat" value="{{ (float) $asset->vat }}"
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
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                        Description</label>
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
        <h1 class="mb-2 title_base text-black dark:text-blue-100">Vendor Info</h1>
        <div class="grid  gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2">

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
    @endif
    <h1 class="mb-2 title_base text-black dark:text-blue-100">Image </h1>
    <input type="text" class="hidden" name="image_state" value="0" id="image_state">
    <input type="text" class="hidden" name="file_state" value="0" id="file_state">
    <div id="image_show" class="grid gap-6 mb-6 grid-cols-1 lg:grid-cols-4 md:grid-cols-4">










    </div>
    </div>

    <h1 class="mb-2 title_base dark:text-blue-100 hide_print">Other FIle</h1>
    <div id="container_file" class="grid gap-6 mb-6 grid-cols-1 lg:grid-cols-4 md:grid-cols-2 hide_print">


    </div>


    <div class="btn_float_right">

        <button type="button" onclick="window.print()" class="text-white update_btn hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i class="fa-solid fa-print"></i></button>
        <button type="button" onclick="search_assets()"
            class="text-white update_btn hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Search
            Invoice
        </button>
        <button type="button"
        {{-- onclick="append_img()" --}}
        onclick="{alert('Under maintenance')}"
            class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            <i class="fa-solid fa-image" style="color: #ffffff;"></i>
        </button>
        <button type="button"
        {{-- onclick="append_file()" --}}
                onclick="{alert('Under maintenance')}"
            class="text-white update_btn focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            <i class="fa-solid fa-file"></i>
        </button>
        <button type="submit"
            class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Submit
        </button>
    </div>
</form>
@php
    $defaultDate =
        !empty($asset->paid_date) && $asset->paid_date != '1900-01-01'
            ? \Carbon\Carbon::parse($asset->paid_date)->format('Y-m-d') // Use Y-m-d
            : null;
@endphp


<script>
    flatpickr("#transaction_date", {
        dateFormat: "d-M-Y",
        defaultDate: "today"
    });
    flatpickr("#dr_date", {
        dateFormat: "d-M-Y",
        defaultDate: "today"
    });

    flatpickr("#invoice_posting_date", {
        dateFormat: "d-M-Y",
        defaultDate: "{{ $defaultDate }}",
        clickOpens: false
    });
    const departmentInput = document.getElementById('department');
    const validDepartments = @json($departments);

    departmentInput.addEventListener('change', function() {
        if (!validDepartments.includes(this.value)) {
            alert("Please select a department from the list!");
            this.value = ""; // clear invalid input
        } else {
            // Trigger your search function here
            otherSearch();
        }
    });

</script>
@endsection
