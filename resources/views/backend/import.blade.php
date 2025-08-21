@extends('backend.master')
@section('content')
@section('header')
    (Import Assets)
@endsection
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
        <h1
            class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-gray-900 md:text-4xl lg:text-5xl dark:text-white">
            Import Asset Data
        </h1>
        <p class="mb-8 text-lg text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">
            Upload your Excel file (.xlsx or .csv) to add or update asset records. Make sure your file follows the
            correct template for smooth import.
        </p>
        <span class="text-rose-600" id="label_status">Drag and Drop File (Only 1 file allowed)</span>
        <!-- File upload form -->
        <form action="/admin/assets/import/submit" method="POST" enctype="multipart/form-data"
            class="flex flex-col items-center space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            @csrf
            <div class="flex flex-col p-5" id="upload-section">
                <label
                    class="flex p-5 flex-col items-center px-4 py-6 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-lg shadow-lg tracking-wide uppercase border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click
                                        to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Excel files only (.xlsx, .xls,
                                    .csv)</p>
                                </p>
                            </div>
                            <input id="dropzone-file" type="file" name="file" accept=".xlsx,.xls,.csv"
                                class="hidden" required />

                        </label>
                    </div>

                </label>
                <div class="grid grid-cols-2 gap-2">

                    <a href="/admin/import/assets/template">
                        <button type="button"
                            class="py-3 px-5 mt-5 text-base font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                            <i class="fa-solid fa-file-excel mx-2" style="color: #ffffff;"></i> Download Template
                        </button>
                    </a>
                   <button type="submit" id="uploadBtn"
        class="py-3 px-5 mt-5 text-base font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
        <i class="fa-solid fa-file-arrow-up mx-2" style="color: #ffffff;"></i> Import
    </button>
                </div>
            </div>
        </form>

        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            Only Excel files are supported. Make sure the file follows the required column order: <strong>Asset Name,
                Asset Code, Purchase Date, Value, etc.</strong>
        </p>
    </div>
</section>
{{-- Success Message --}}
@if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
        <span class="font-medium">Success!</span> {{ session('success') }}
    </div>
@endif

{{-- Single Error --}}
@if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
        <span class="font-medium">Error!</span> {{ session('error') }}
    </div>
@endif

{{-- Multiple Errors --}}
@if (session('errorList'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
        <span class="font-medium">Import failed with errors:</span>
        <ul class="list-disc pl-5 mt-2">
            @foreach (session('errorList') as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
 const dropzone = document.getElementById('dropzone-file').parentElement;
const input = document.getElementById('dropzone-file');
const labelStatus = document.getElementById('label_status');

// Allowed Excel MIME types/extensions
const allowedExtensions = ['xlsx', 'xls'];

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, e => e.preventDefault());
    dropzone.addEventListener(eventName, e => e.stopPropagation());
});

// Highlight on drag over
['dragenter', 'dragover'].forEach(eventName => {
    dropzone.classList.add('border-blue-500');
});

['dragleave', 'drop'].forEach(eventName => {
    dropzone.classList.remove('border-blue-500');
});

// Handle dropped files
dropzone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        if (filterFiles(files)) {
            input.files = files; // Assign dropped files to input
            updateStatus();
        }
    }
});

// Handle manual file selection
input.addEventListener('change', () => {
    if (filterFiles(input.files)) {
        updateStatus();
    } else {
        input.value = ''; // Clear invalid file
        updateStatus();
    }
});

function filterFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const ext = files[i].name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(ext)) {
            // Show toast for invalid file
            toast_red.querySelector("p").innerHTML = "Only Excel files are allowed!";
            toast_red.style.display = "block";
            toast_red.style.animation = "none"; // reset animation
            toast_red.offsetHeight; // reflow
            toast_red.style.animation = "fadeOut2 4s forwards"; // start fade
            return false;
        }
    }
    return true;
}

function updateStatus() {
    if (input.files.length > 0) {
        labelStatus.classList.remove('text-rose-600');
        labelStatus.classList.add('text-green-600');
        labelStatus.textContent =
            `${input.files.length} file${input.files.length > 1 ? 's' : ''} added for import.`;
    } else {
        labelStatus.textContent = '';
    }
}

document.getElementById('uploadBtn').addEventListener('click', function() {
    if (!input.files.length) {
        // Show toast if no file
        toast_red.querySelector("p").innerHTML = "Select File first !";
        toast_red.style.display = "block";
        toast_red.style.animation = "none"; // reset animation
        toast_red.offsetHeight; // reflow
        toast_red.style.animation = "fadeOut2 4s forwards"; // start fade
    } else {
        // Submit the form if file exists
        document.getElementById('uploadForm').submit();
    }
});

</script>

@endsection
