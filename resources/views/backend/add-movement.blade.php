@extends('backend.master')
@section('header')
    Movement Process
@endsection
@section('style')
    <span class="ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-700 to-cyan-400">Movement</span>
    </span>
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <div class="border-b p-5 bg-white dark:bg-slate-900 dark:text-white border-gray-200 dark:border-gray-700">
        <form method="POST" action="/admin/movement/add/submit">
            @csrf
            <h1 class="title_base text-black dark:text-blue-100">Movement Asset</h1>

            <div class="grid gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2 lg:grid-cols-2 md:grid-cols-2">
                <div>
                    <label for="ref_movementl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference
                        Movement</label>
                    <input type="text" id="ref_movement" name="ref_movement"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        <input type="text" name="last_assets_id" value="{{$asset->assets_id}}" class="hidden">
                    </div>

                <div class="flex flex-col w-full">
                    <label for="no" id="assets1"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                        Code <span class="text-rose-500">*</span></label>
                    <div class="flex w-full">
                        @if (!empty($asset->assets1))
                            <input type="text" id="assets1" readonly
                                class="p-2.5 percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->assets1 }}" />
                        @else
                            <input type="text" id="assets2" name="assets2" required
                                class="p-2.5 percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif

                        @php
                            $codes = [
                                'PD' => 'Production',
                                'CM' => 'Commercial',
                                '34' => 'Project at 34A',
                                'AG' => 'Administation and General Affairs',
                                'CP' => 'Confnirel Factory',
                                'EX' => 'Export',
                                'FD' => 'Accounting and Finance',
                                'HR' => 'Human Resource',
                                'IA' => 'Inernal Audit',
                                'IT' => 'Management of Information System',
                                'KA' => 'Project in Kampot',
                                'KE' => 'Project in Kep',
                                'LO' => 'Logistic',
                                'MG' => 'Management',
                                'MK' => 'Marketing',
                                'MT' => 'Maitenance',
                                'PN' => 'Planing',
                                'PP' => 'PPM Factory',
                                'PU' => 'Purchase',
                                'PV' => 'Project Prek Phnov',
                                'QA' => 'Quality Assurance',
                                'QM' => 'Quality Management',
                                'RD' => 'Research and Development',
                                'RP' => 'Registration and New Product',
                                'RT' => 'Project in Ratanakiri',
                                'SA' => 'Sales Adminstration',
                                'SL' => 'Sales',
                                'ST' => 'Stock/Warehouse',
                                'C' => 'Confirel',
                                'D' => 'Depomex',
                                'E' => 'External Project',
                                'I' => 'Investco',
                                'P' => 'PPM',
                            ];
                        @endphp

                        <select name="assets2" required name="assets2"
                            class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=""></option>
                            @foreach ($codes as $code => $key)
                                <option value="{{ '-' . $code }}" {{ $asset->assets2 == '-' . $code ? 'selected' : '' }}>
                                    {{ $code }}&ensp; ({{ $key }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div>
                    <label for="transaction_date"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction Date</label>
                    <input type="text" id="transaction_date" name="transaction_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ \Carbon\Carbon::parse(now())->format('d-M-Y') }}" />
                </div>
                <div>
                    <label for="holder_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To
                        Holder</label>
                    <input type="text" id="holder_id" name="holder"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>

                <div>
                    <label for="holder_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To Holder
                        Name</label>
                    <input type="text" id="holder_name" name="holder_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="Location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To
                        Location</label>
                    <input type="text" id="Location" name="location"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>


                <div>
                    <label for="department_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        To Department <span class="text-rose-500">*</span>
                    </label>

                    <input list="departments_list" id="department" required name="department"
                        value="{{ $asset->department }}"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
                  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
                  dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Start typing department...">

                    @php
                        $departments = [
                            'Accounting & Finance',
                            'Administration & HR',
                            'Management',
                            'Maintenance',
                            'Planning',
                            'Purchase',
                            'Regulatory Affairs',
                            'External Project & Special Project',
                            'Warehouse',
                            'Logistic',
                            'MIS',
                            'Consultant',
                            'Research & Development',
                            'Commercial',
                            'Production',
                            'Quality Control',
                            'Quality Assurance',
                            'Pizza Project',
                            'Kitchen Center',
                            'Export and Marketing',
                            'Quality Production',
                            'Order',
                        ];
                        $departments = array_unique($departments); // prevent duplicates
                    @endphp

                    <datalist id="departments_list">
                        @foreach ($departments as $department)
                            <option value="{{ $department }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To
                        Company
                        <span class="text-rose-500">*</span></label>
                    <select id="company" name="company"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <option value="CFR" @if (($asset->company ?? '') == 'CFR') selected @endif>CFR</option>
                        <option value="Depomex" @if (($asset->company ?? '') == 'Depomex') selected @endif>Depomex</option>
                        <option value="INV" @if (($asset->company ?? '') == 'INV') selected @endif>INV</option>
                        <option value="Other" @if (($asset->company ?? '') == 'Other') selected @endif>Other</option>
                        <option value="PPM" @if (($asset->company ?? '') == 'PPM') selected @endif>PPM</option>
                        <option value="PPM&Confirel" @if (($asset->company ?? '') == 'PPM&Confirel') selected @endif>PPM&Confirel</option>

                    </select>
                </div>
                <div>
                    <label for="purpose"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purpose</label>
                    <input type="text" id="purpose" name="purpose"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="Initail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                        Initail
                        Condition</label>
                    <input type="text" id="Initail" name="initial_condition"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="status_recieved" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                        Recieved</label>
                    <select id="status_recieved" name="status_recieved"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <option value="Old">Old</option>
                        <option value="Good">Good</option>
                        <option value="Broken">Broken</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="Other">Other</option>
                    </select>
                      <div class="btn_float_right">

                    <button  class="text-white update_btn hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Submit</button>
                </div>
            </div>
        </form>
    </div>
    </div>










































































    <div class="border-b mt-5 p-5 bg-white dark:bg-slate-900 dark:text-white border-gray-200 dark:border-gray-700">




        <h1 class="title_base text-black dark:text-blue-100">Current Asset Info</h1>

        <div class="grid gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2 lg:grid-cols-2 md:grid-cols-2">


            <div class="flex flex-col w-full">
                <label for="no" id="assets_label"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code <span class="text-rose-500">*</span></label>
                <div class="flex w-full">
                    @if (!empty($asset->assets1))
                        <input type="text" id="assets1" disabled
                            class="p-2.5 percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->assets1 }}" />
                    @else
                        <input type="text" id="assets2" disabled
                            class="p-2.5 percent70 bg-gray-50 border border-gray-300 text-gray-900 text-sm  focus:ring-blue-500 rounded-l-lg focus:border-blue-500 block   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                    @php
                        $codes = [
                            'PD' => 'Production',
                            'CM' => 'Commercial',
                            '34' => 'Project at 34A',
                            'AG' => 'Administation and General Affairs',
                            'CP' => 'Confnirel Factory',
                            'EX' => 'Export',
                            'FD' => 'Accounting and Finance',
                            'HR' => 'Human Resource',
                            'IA' => 'Inernal Audit',
                            'IT' => 'Management of Information System',
                            'KA' => 'Project in Kampot',
                            'KE' => 'Project in Kep',
                            'LO' => 'Logistic',
                            'MG' => 'Management',
                            'MK' => 'Marketing',
                            'MT' => 'Maitenance',
                            'PN' => 'Planing',
                            'PP' => 'PPM Factory',
                            'PU' => 'Purchase',
                            'PV' => 'Project Prek Phnov',
                            'QA' => 'Quality Assurance',
                            'QM' => 'Quality Management',
                            'RD' => 'Research and Development',
                            'RP' => 'Registration and New Product',
                            'RT' => 'Project in Ratanakiri',
                            'SA' => 'Sales Adminstration',
                            'SL' => 'Sales',
                            'ST' => 'Stock/Warehouse',
                            'C' => 'Confirel',
                            'D' => 'Depomex',
                            'E' => 'External Project',
                            'I' => 'Investco',
                            'P' => 'PPM',
                        ];
                    @endphp

                    <select disabled
                        class="percent30 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        @foreach ($codes as $code => $key)
                            <option value="{{ '-' . $code }}" {{ $asset->assets2 == '-' . $code ? 'selected' : '' }}>
                                {{ $code }}&ensp; ({{ $key }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                <input type="text" id="item"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ $asset->item }}" disabled />
            </div>
            <div>
                <label for="Specification" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Specification</label>
                <input type="text" id="Specification"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled value="{{ $asset->specification }}" />
            </div>
            <div>
                <label for="transaction_date_from"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                    Transaction Date</label>
                <input type="text" id="transaction_date_from"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled value="{{ \Carbon\Carbon::parse($asset->transaction_date)->format('d-M-Y') }}" />
            </div>
            <div>
                <label for="holder_id_from"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holder</label>
                <input type="text" id="holder_id_from" disabled value="{{ $asset->asset_holder }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <div>
                <label for="holder_name_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holder
                    Name</label>
                <input type="text" id="holder_name_from" disabled value="{{ $asset->holder_name }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div>
                <label for="Location_from"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" id="Location_from" disabled value="{{ $asset->location }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>


            <div>
                <label for="department_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Department <span class="text-rose-500">*</span>
                </label>

                <input list="departments_list" id="department_from" required value="{{ $asset->department }}" disabled
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
                  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
                  dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Start typing department...">

                @php
                    $departments = [
                        'Accounting & Finance',
                        'Administration & HR',
                        'Management',
                        'Maintenance',
                        'Planning',
                        'Purchase',
                        'Regulatory Affairs',
                        'External Project & Special Project',
                        'Warehouse',
                        'Logistic',
                        'MIS',
                        'Consultant',
                        'Research & Development',
                        'Commercial',
                        'Production',
                        'Quality Control',
                        'Quality Assurance',
                        'Pizza Project',
                        'Kitchen Center',
                        'Export and Marketing',
                        'Quality Production',
                        'Order',
                    ];
                    $departments = array_unique($departments); // prevent duplicates
                @endphp

                <datalist id="departments_list">
                    @foreach ($departments as $department)
                        <option value="{{ $department }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div>
                <label for="company_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company
                    <span class="text-rose-500">*</span></label>
                <select id="company_from" disabled
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    <option value="CFR" @if (($asset->company ?? '') == 'CFR') selected @endif>CFR</option>
                    <option value="Depomex" @if (($asset->company ?? '') == 'Depomex') selected @endif>Depomex</option>
                    <option value="INV" @if (($asset->company ?? '') == 'INV') selected @endif>INV</option>
                    <option value="Other" @if (($asset->company ?? '') == 'Other') selected @endif>Other</option>
                    <option value="PPM" @if (($asset->company ?? '') == 'PPM') selected @endif>PPM</option>
                    <option value="PPM&Confirel" @if (($asset->company ?? '') == 'PPM&Confirel') selected @endif>PPM&Confirel</option>

                </select>
            </div>
            <div>
                <label for="Location_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initail
                    Condition</label>
                <input type="text" id="Location_from" disabled value="{{ $asset->initial_condition }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
        </div>
    </div>













    </div>
    <script>
        flatpickr("#transaction_date", {
            dateFormat: "d-M-Y",
            defaultDate: "today"

        });
    </script>
@endsection
