@extends('backend.master')
@section('header')
    Movement Process
@endsection
@section('style')
    <span class="mobile_hide ml-10 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl"><span
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
                        Movement <span class="text-rose-500">*</span></label>

                    <input type="text" list="references_list" id="ReferenceInput" onchange="setReferenceId(this)"
                        oninput="validateInputField(this,30)" onchange="setReferenceId(this)"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="reference" required autocomplete="off" value="{{ old('reference') }}" />

                    <input type="hidden" id="ReferenceId" name="reference_id" />

                    <datalist id="references_list">
                        @foreach ($references as $item)
                            <option data-id="{{ $item->id }}"
                                value="{{ $item->code . str_pad($item->no, 5, '0', STR_PAD_LEFT) }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </datalist>



                    <input type="text" name="last_assets_id" value="{{ $asset->assets_id }}" class="hidden">
                </div>

                <div class="flex flex-col w-full">
                    <label for="no" id="assets1"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                        Code <span class="text-rose-500">*</span></label>
                    <div class="flex w-full">
                        @if (!empty($asset->assets1))
                            <input type="text" id="assets1" readonly
                                class="percent70 bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $asset->assets1 }}" />
                        @else
                            <input type="text" id="assets2" name="assets2"
                                class="percent70 bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @endif


                        <select name="assets2" required oninput="validateInputField(this,10)"
                            class="percent30 bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-e-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                    <label for="transaction_date"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction Date</label>
                    <input type="text" id="transaction_date" name="transaction_date"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ \Carbon\Carbon::parse(now())->format('d-M-Y') }}" />
                </div>

                <div>
                    <label for="asset_holder">Asset Holder ID <button type="button" id="clear_user"
                            class="text-white  bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-2 py-0 ext-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"><i
                                class="fa-regular fa-trash-can"></i></button></label>
                    <input type="text" id="asset_holder" name="asset_holder" list="asset_list" placeholder="INV-90.."
                        autocomplete="off"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <datalist id="asset_list"></datalist>
                </div>

                <div>
                    <label for="holder_name">Name</label>
                    <input type="text" id="holder_name" name="holder_name" list="users_list" autocomplete="off"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Start typing name...">
                    <datalist id="users_list"></datalist>
                </div>
                <div>
                    <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Position/Title
                    </label>
                    <input type="text" id="position" name="position"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="Location"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                    <input type="text" id="Location" autocomplete="off"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="location" />
                </div>

                <div>
                    <label for="department">Department <span class="text-rose-500">*</span></label>
                    <input list="departments_list" id="department" name="department" autocomplete="off" required
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Start typing department...">

                    <datalist id="departments_list">
                        <option value="" selected></option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->name }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label for="company">Company <span class="text-rose-500">*</span></label>
                    <input list="company_list" id="company" name="company" autocomplete="off" required
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Start typing company...">
                    <datalist id="company_list">
                        <option value="" selected></option>
                        @foreach ($company as $comp)
                            <option value="{{ $comp->code }}"></option>
                        @endforeach
                    </datalist>
                </div>





                <div>
                    <label for="purpose"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purpose</label>
                    <input type="text" id="purpose" name="purpose"
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="Initail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                        Initail
                        Condition <span class="text-rose-500">*</span></label>
                    <select  id="" required id="Initail" name="initial_condition" required
                         class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected></option>
                        <option value="New">New</option>
                        <option value="Good">Good</option>
                        <option value="Very good">Very good</option>
                        <option value="Low">Low</option>
                        <option value="Second hand">Second hand</option>
                        <option value="Medium">Medium</option>
                        <option value="Old">Old</option>
                        <option value="Very old">Very old</option>
                        <option value="Broken">Broken</option>
                        <option value="Donation">Donation</option>
                        <option value="Disposal">Disposal</option>
                        <option value="Sold Out">Sold Out</option>
                    </select>

                </div>
                <div>
                    <label for="status_recieved"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
                        Recieved</label>
                    <select id="status_recieved" name="status_recieved" required
                        class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""></option>
                        <option value="Old">Old</option>
                        <option value="Good">Good</option>
                        <option value="Broken">Broken</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="btn_float_right">

                        <button
                            class="text-white update_btn hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Submit</button>
                    </div>
                </div>
        </form>
    </div>
    </div>

    <div class="border-b mt-5 p-5 bg-white dark:bg-slate-900 dark:text-white border-gray-200 dark:border-gray-700">




        <h1 class="title_base text-black dark:text-blue-100">Current Asset Info</h1>

        <div class="grid gap-1 lg:gap-6 mb-1 lg:mb-6 grid-cols-2 lg:grid-cols-2 md:grid-cols-2">
            <div class="w-full">
                <label for="ref"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference</label>
                <input type="text" id="ref" disabled
                    class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ $asset->reference }}" />
            </div>

            <div class="flex flex-col w-full">
                <label for="no" id="assets_label"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset
                    Code <span class="text-rose-500">*</span></label>
                <div class="flex w-full">
                    @if (!empty($asset->assets1))
                        <input type="text" id="assets1" disabled
                            class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $asset->assets1 }}" />
                    @else
                        <input type="text" id="assets2" disabled
                            class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @endif

                    <select name="assets2" required oninput="validateInputField(this,10)" disabled
                        class="bg-gray-100 percent30 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-e-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  >
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
                <label for="item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                <input type="text" id="item"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ $asset->item }}" disabled />
            </div>
            <div>
                <label for="Specification" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Specification</label>
                <input type="text" id="Specification"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled value="{{ $asset->specification }}" />
            </div>
            <div>
                <label for="transaction_date_from"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                    Transaction Date</label>
                <input type="text" id="transaction_date_from"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled value="{{ \Carbon\Carbon::parse($asset->transaction_date)->format('d-M-Y') }}" />
            </div>
            <div>
                <label for="holder_id_from"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holder</label>
                <input type="text" id="holder_id_from" disabled value="{{ $asset->asset_holder }}"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <div>
                <label for="holder_name_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holder
                    Name</label>
                <input type="text" id="holder_name_from" disabled value="{{ $asset->holder_name }}"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div>
                <label for="Location_from"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" id="Location_from" disabled value="{{ $asset->location }}"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>


            <div>
                <label for="department_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Department <span class="text-rose-500">*</span>
                </label>

                <input list="departments_list" id="department_from" required value="{{ $asset->department }}" disabled
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Start typing department...">
            </div>
            <div>
                <label for="company_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company
                    <span class="text-rose-500">*</span></label>
                <select id="company_from" disabled
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    <option value="{{ $asset->company }}">{{ $asset->company }}</option>


                </select>
            </div>
            <div>
                <label for="Location_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Initail
                    Condition</label>
                <input type="text" id="Location_from" disabled value="{{ $asset->initial_condition }}"
                     class="bg-gray-100 dark:bg-gray-800 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
        </div>
    </div>

    </div>
    <script>
        flatpickr("#transaction_date", {
            dateFormat: "d-M-Y",
            defaultDate: "today"

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

        function setReferenceId(input) {
            const value = input.value;
            const options = document.getElementById('references_list').options;
            let hiddenField = document.getElementById('ReferenceId');

            hiddenField.value = ''; // reset first
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === value) {
                    hiddenField.value = options[i].dataset.id;
                    break;
                }
            }
        }
    </script>
@endsection
