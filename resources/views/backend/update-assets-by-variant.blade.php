@extends('backend.master')
@section('content')
    <div class="border-b bg-white dark:bg-slate-900 dark:text-white border-gray-200 dark:border-gray-700">
        <ul
            class="flex  overflow-x-auto whitespace-nowrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-200">
            @php
                $i = $total_varaint;
            @endphp

            @while ($i >= 0)
                @if ($total_varaint == $i)
                    @if ($i == $current_varaint)
                        <li class="me-2 active_tab">
                        @else
                        <li class="me-2">
                    @endif
                    <a href="/admin/assets/view/varaint={{ $i }}/id={{ $asset[$current_varaint]->assets_id }}"
                        class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                        <i class="fa-brands fa-codepen mr-3 "></i>Lastest Change
                        ({{ \Carbon\Carbon::parse($asset[$i]->created_at)->format('M d Y') }})
                        @if ($asset[$i]->deleted == 1)
                            &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i> &ensp;(Deleted at
                            {{ $asset[$i]->deleted_at }})
                        @endif
                    </a>
                    </li>
                @elseif($i == 0)
                    @if ($i == $current_varaint)
                        <li class="me-2 active_tab">
                        @else
                        <li class="me-2">
                    @endif
                    <a href="/admin/assets/view/varaint={{ $i }}/id={{ $asset[$current_varaint]->assets_id }}"
                        class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                        <i class="fa-solid fa-folder-open mr-3"></i>First Created
                        ({{ \Carbon\Carbon::parse($asset[$i]->created_at)->format('M d Y') }})
                        @if ($asset[$i]->deleted == 1)
                            &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i> &ensp;(Deleted at
                            {{ $asset[$i]->deleted_at }})
                        @endif
                    </a>
                    </li>
                @else
                    @if ($i == $current_varaint)
                        <li class="me-2 active_tab">
                        @else
                        <li class="me-2">
                    @endif
                    <a href="/admin/assets/view/varaint={{ $i }}/id={{ $asset[$current_varaint]->assets_id }}"
                        class="inline-flex items-center justify-center p-4  hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ">

                        <i class="fa-solid fa-palette mr-3"></i>V {{ $i }}
                        ({{ \Carbon\Carbon::parse($asset[$i]->created_at)->format('M d Y') }})
                        @if ($asset[$i]->deleted == 1)
                            &ensp; &ensp;<i class="fa-solid fa-trash-can" style="color: #ff0000;"></i> &ensp;(Deleted at
                            {{ $asset[$i]->deleted_at }})
                        @endif
                    </a>
                    </li>
                @endif
                @php
                    $i--;
                @endphp
            @endwhile


        </ul>
    </div>



    <form class="p-5 dark:bg-gray-900" id="form-submit" enctype="multipart/form-data" action="/admin/assets/update/submit"
        method="POST">
        @csrf
        <h1 class="title_base dark:text-blue-100">Asset Info</h1>

        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
            <div>
                <label for="Reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference <span
                        class="text-rose-500">*</span></label>
                <input type="text" id="Reference"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="document" value="{{ old('document', $asset[$current_varaint]->document ?? '') }}" required />
                <input type="text" class="hidden" name="id" value="{{ $asset[$current_varaint]->assets_id }}">
            </div>

            <div class="flex flex-col w-full">
                <label for="no" id="assets_label"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset Code <span
                        class="text-rose-500">*</span></label>
                <div class="flex w-full">
                    <input type="text" id="Asset_Code" name="asset_code1" readonly
                        class="percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('asset_code1', $asset[$current_varaint]->assets1 ?? '') }}" />

                    <input type="text" name="asset_code2" readonly
                        value="{{ old('asset_code1', $asset[$current_varaint]->assets2 ?? '') }}"
                        class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="fa_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA-No</label>
                <input type="text" id="fa_no"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="fa_no" value="{{ old('fa_no', $asset[$current_varaint]->fa_no ?? '') }}" />
            </div>

            <div>
                <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                <input type="text" id="item"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="item" value="{{ old('item', $asset[$current_varaint]->item ?? '') }}" />
            </div>

            <div>
                <label for="Issue_Date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue
                    Date</label>
                <input type="date" id="Issue_Date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('issue_date', $asset[$current_varaint]->issue_date, today()) }}" name="issue_date" />
            </div>

            <div>
                <label for="Initial_Conditions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initial
                    Conditions</label>
                <input type="text" id="initial_Conditions"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="intail_condition"
                    value="{{ old('intail_condition', $asset[$current_varaint]->initial_condition ?? '') }}" />
            </div>

            <div>
                <label for="Specifications"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Specifications</label>
                <input type="text" id="Specifications"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="specification"
                    value="{{ old('specification', $asset[$current_varaint]->specification ?? '') }}" />
            </div>

            <div>
                <label for="item_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item
                    Description</label>
                <input type="text" id="item_description" name="item_description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('item_description', $asset[$current_varaint]->item_description ?? '') }}" />
            </div>

            <div>
                <label for="asset_group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Group</label>
                <input type="text" id="asset_group"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_group" value="{{ old('asset_group', $asset[$current_varaint]->asset_group ?? '') }}" />
            </div>
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select id="status" name="status"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">



                    @if ($asset[$current_varaint]->deleted == 2)
                        <option value="2">Sold</option>
                        <option value="1">Deleted</option>
                        <option value="0">Available</option>
                    @elseif($asset[$current_varaint]->delected == 0)
                        <option value="0">Available</option>
                        <option value="1">Deleted</option>
                        <option value="2">Sold</option>
                    @endif

                </select>
            </div>

            <div>
                <label for="remark_assets"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_assets"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_assets"
                    value="{{ old('remark_assets', $asset[$current_varaint]->remark_assets ?? '') }}" />
            </div>
        </div>



        <h1 class="mb-2 title_base dark:text-blue-100">Asset Holder Info</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="asset_holder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Holder ID</label>
                <input type="text" id="asset_holder"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="asset_holder" value="{{ old('asset_holder', $asset[$current_varaint]->asset_holder ?? '') }}"
                    placeholder="INV-90.." />
            </div>
            <div>
                <label for="holder_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="holder_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="holder_name" value="{{ old('holder_name', $asset[$current_varaint]->holder_name ?? '') }}" />
            </div>
            <div>
                <label for="position"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position/Title</label>
                <input type="text" id="position"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="position" value="{{ old('position', $asset[$current_varaint]->position ?? '') }}" />
            </div>
            <div>
                <label for="location"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" id="location"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="location" value="{{ old('location', $asset[$current_varaint]->location ?? '') }}" />
            </div>
            <div>

                <label for="department"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                <select id="department" name="department"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if (!empty($asset[$current_varaint]->department))
                        <option value="{{ $asset[$current_varaint]->department }}">
                            {{ $asset[$current_varaint]->department }}</option>
                    @endif
                    @if (!empty($department))
                        @foreach ($department as $item)
                            @if ($item->content != $asset[$current_varaint]->department)
                                <option value="{{ $item->content }}">{{ $item->content }}</option>
                            @endif
                        @endforeach
                    @endif
                    <option value=""></option>

                </select>
            </div>
            <div>
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                <select id="company" name="company"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if (!empty($asset[$current_varaint]->company))
                        <option value="{{ $asset[$current_varaint]->company }}">{{ $asset[$current_varaint]->company }}
                        </option>
                    @endif
                    @if (!empty($company))
                        @foreach ($company as $item)
                            @if ($item->content != $asset[$current_varaint]->company)
                                <option value="{{ $item->content }}">{{ $item->content }}</option>
                            @endif
                        @endforeach
                    @endif
                    <option value=""></option>

                </select>
            </div>
            <div>
                <label for="remark_holder"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_holder"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_holder"
                    value="{{ old('remark_holder', $asset[$current_varaint]->remark_holder ?? '') }}" />
            </div>
        </div>

        <h1 class="mb-2 title_base dark:text-blue-100">Internal Document</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="grn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GRN No</label>
                <input type="text" id="grn"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="grn" value="{{ old('grn', $asset[$current_varaint]->grn ?? '') }}" />
            </div>
            <div>
                <label for="po" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PO No</label>
                <input type="text" id="po"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="po" value="{{ old('po', $asset[$current_varaint]->po ?? '') }}" />
            </div>
            <div>
                <label for="pr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PR (Purchase
                    Request)</label>
                <input type="text" id="pr"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="pr" value="{{ old('pr', $asset[$current_varaint]->pr ?? '') }}" />
            </div>
            <div>
                <label for="dr" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR (Department
                    Request)</label>
                <input type="text" id="dr"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="dr" value="{{ old('dr', $asset[$current_varaint]->dr ?? '') }}" />
            </div>
            <div>
                <label for="dr_requested_by" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR
                    (Requested by)</label>
                <input type="text" id="dr_requested_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="dr_requested_by"
                    value="{{ old('dr_requested_by', $asset[$current_varaint]->dr_requested_by ?? '') }}" />
            </div>
            <div>
                <label for="dr_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DR Request
                    Date</label>
                <input type="date" id="dr_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="dr_date" value="{{ old('dr_date', $asset[$current_varaint]->dr_date, today()) }}" />


            </div>
            <div>
                <label for="remark_internal_doc"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                <input type="text" id="remark_internal_doc"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="remark_internal_doc"
                    value="{{ old('remark_internal_doc', $asset[$current_varaint]->remark_internal_doc ?? '') }}" />
            </div>
        </div>

        <h1 class="mb-2 title_base dark:text-blue-100">ERP Invoice</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <!-- Asset Code (Account) -->
            <div class="flex flex-col w-full">
                <label for="asset_code_account" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code (Account)</label>
                <input type="text" id="asset_code_account" name="asset_code_account" readonly
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('asset_code_account', $asset[$current_varaint]->asset_code_account ?? '') }}" />
            </div>

            <!-- Invoice Posting Date -->
            <div>
                <label for="invoice_posting_date"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Posting Date</label>
                <input type="date" id="invoice_posting_date" name="invoice_posting_date" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('invoice_posting_date', $asset[$current_varaint]->invoice_date ?? '') }}" />
            </div>

            <!-- Invoice No -->
            <div>
                <label for="fa_invoice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                    No</label>
                <input type="text" id="fa_invoice" name="invoice" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('invoice', $asset[$current_varaint]->invoice_no ?? '') }}" />
            </div>

            <!-- Fix Assets-No -->
            <div>
                <label for="fa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fix
                    Assets-No</label>
                <input type="text" id="fa" name="fa" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa', $asset[$current_varaint]->fa ?? '') }}" />
            </div>

            <!-- FA Class -->
            <div>
                <label for="fa_class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Class</label>
                <input type="text" id="fa_class" name="fa_class" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa', $asset[$current_varaint]->fa_class ?? '') }}" />
            </div>

            <!-- FA Subclass Code -->
            <div>
                <label for="FA_Subclass_Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Subclass Code</label>
                <input type="text" id="FA_Subclass_Code" name="fa_subclass" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_subclass', $asset[$current_varaint]->fa_subclass ?? '') }}" />
            </div>

            <!-- Depreciation Book Code -->
            <div>
                <label for="depreciation_book_code"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Depreciation Book Code</label>
                <input type="text" id="depreciation_book_code" name="depreciation_book_code" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('depreciation_book_code', $asset[$current_varaint]->depreciation ?? '') }}" />
            </div>

            <!-- FA Posting Type -->
            <div>
                <label for="fa_posting_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Posting Type</label>
                <input type="text" id="fa_posting_type" name="fa_type" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_type', $asset[$current_varaint]->fa_type ?? '') }}" />
            </div>

            <!-- FA Location -->
            <div>
                <label for="fa_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">FA
                    Location</label>
                <input type="text" id="fa_location" name="fa_location" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('fa_location', $asset[$current_varaint]->fa_location ?? '') }}" />
            </div>

            <!-- Cost & VAT -->
            <div class="flex flex-col w-full">
                <label for="cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost &
                    VAT</label>
                <div class="flex w-full">
                    <input type="text" id="cost" name="cost" readonly
                        class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('cost', (float) $asset[$current_varaint]->cost ?? '') }}" />
                    <input type="text" id="currency" name="currency" readonly
                        class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('currency', $asset[$current_varaint]->currency ?? '') }}" />
                    <input type="text" id="vat" name="vat" readonly
                        class="percent3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ old('vat', $asset[$current_varaint]->vat ?? '') }}" />
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Description
                </label>
                <textarea id="description" name="description" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description', $asset[$current_varaint]->description ?? '') }}</textarea>
            </div>

            <div class="flex flex-col w-full">
                <label for="invoice_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Invoice Description
                </label>
                <textarea id="invoice_description" name="invoice_description" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('invoice_description', $asset[$current_varaint]->invoice_description ?? '') }}
                </textarea>
            </div>

        </div>


        <h1 class="mb-2 title_base dark:text-blue-100">Vendor Info</h1>
        <div class="grid gap-6 mb-6 md:grid-cols-2">

            <div>
                <div>
                    <label for="vendor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
                        No</label>

                    <input type="text" id="vendor" name="vendor" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value= "{{ old('vendor', $asset[$current_varaint]->vendor ?? '') }}" />


                </div>
            </div>
            <div>
                <div>
                    <label for="vendor_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor
                        Name</label>

                    <input type="text" id="vendor_name" name="vendor_name" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value= "{{ old('vendor_name', $asset[$current_varaint]->vendor_name ?? '') }}" />


                </div>
            </div>
            <div>
                <div>
                    <label for="address"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>

                    <input type="text" id="address" name="address" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value= "{{ old('address', $asset[$current_varaint]->address ?? '') }}" />


                </div>
            </div>
            <div>
                <div>
                    <label for="address2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address
                        2</label>
                    @if (!empty($asset[$current_varaint]->address2))
                        <input type="text" id="address2" name="address2" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset[$current_varaint]->address2 }}" />
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

                    @if (!empty($asset[$current_varaint]->contact))
                        <input type="text" id="contact" name="contact" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset[$current_varaint]->contact }}" />
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
                    @if (!empty($asset[$current_varaint]->phone))
                        <input type="text" id="phone" name="phone" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset[$current_varaint]->phone }}" />
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
                    @if (!empty($asset[$current_varaint]->email))
                        <input type="text" id="email" name="email" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset[$current_varaint]->email }}" />
                    @else
                        <input type="text" id="email" name="email" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                </div>
            </div>
        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">QR Code </h1>
        <div id="qr_code">
            <a target="_blank"
                href="/admin/qr/code/print/assets={{ $asset[$current_varaint]->assets1 . $asset[$current_varaint]->assets2 }}">
                {{ $qr_code }}
            </a>


        </div>
        <h1 class="mb-2 title_base mt-4 dark:text-blue-100">Image </h1>
        <input type="text" class="hidden" name="image_state" value="0" id="image_state">
        <input type="text" class="hidden" name="file_state" value="0" id="file_state">
        <div id="image_show" class="grid gap-6 mb-6 grid-cols-1 lg:grid-cols-4 md:grid-cols-4">
            @if (!empty($asset))
                @if (!empty($asset[$current_varaint]->images))
                    @php
                        $image_qty = 0;
                        $image_no = 1;

                    @endphp

                    @foreach ($asset[$current_varaint]->images as $item)
                        @if ($item->varaint == $current_varaint)
                            <div class="image_box" id="image_box_varaint{{ $item->id }}">
                                <img src="/uploads/image/{{ $item->image }}"
                                    onclick="maximize_minimize({{ $item->id }})" alt="Item">
                                <button type="button" onclick="remove_image_from_stored_varaint({{ $item->id }})"
                                    id="delete_image"><i class="fa-solid fa-trash" style="color: #ff0000;"></i></button>

                                <a download="{{ $item->image }}" href="/uploads/image/{{ $item->image }}"><button
                                        type="button" id="download_image"><i class="fa-regular fa-circle-down"
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
                    <input type="text" class="hidden" name="state_stored_image" value="{{ $image_qty }}">
                @endif
            @endif
        </div>
        <h1 class="mb-2 title_base dark:text-blue-100">Other FIle</h1>
        <div id="container_file" class="grid justify-start gap-6 mb-6 grid-cols-1 lg:grid-cols-1 md:grid-cols-1">

            @if (!empty($asset[$current_varaint]->files))
                @php
                    $file_qty = 0;
                    $file_no = 1;

                @endphp

                @foreach ($asset[$current_varaint]->files as $item)
                    @php
                        $pathInfo = pathinfo($item->file);

                        $extension = $pathInfo['extension']; // txt
                        $filename = $item->file; // example
                    @endphp
                    @if ($item->varaint == $current_varaint)
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
        @if ($total_varaint == $current_varaint && ($asset[$current_varaint]->deleted == 0 || $asset[$current_varaint]->deleted == 2))
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
        @else
            <div class="btn_float_right">
                <button type="button" onclick="change_form_attribute()"
                    class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Restore <i class="fa-solid fa-download"></i>
                </button>

            </div>
        @endif

    </form>
@endsection
