<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- ICON Website  --}}
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/16925/16925957.png" type="image/x-icon">
    {{-- Tail Wind  --}}
    {{-- @vite('resources/css/app.css') --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            background: url('https://img.freepik.com/free-vector/gradient-hexagonal-background_23-2148932756.jpg?ga=GA1.1.184516767.1721893455&semt=ais_hybrid');
            background-position: center;
            background-size: cover;
        }

        #button_submit {
            background-color: rgb(190 242 100);
        }

        #toast {

            position: absolute;
            top: 40px;
            left: 50%;
            z-index: 99;
            transform: translate(-50%, -50%);
            animation: fade_up 10s forwards;
        }

        #code_submit {
            display: none;
        }

        #toast_red {
            position: absolute;
            display: none;
            top: 40px;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 1;
            visibility: visible;
            animation: fadeOut2 4s forwards;
            z-index: 99;

        }

        #loading {
            position: fixed;
            /* fixed relative to viewport */
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            /* use flex to center inner box */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.2);
            /* optional overlay */
            transition: opacity 0.3s ease;
        }


        #loading h1 {
            margin: 0 10px;
        }

        .password-requirements {
            list-style: none;
            padding-left: 0;
            margin-top: 5px;
        }

        .password-requirements li {
            color: red;
            margin: 2px 0;
        }

        .password-requirements li.valid {
            color: green;
        }

        #button_submit {
            display: none;
        }



        @keyframes fadeOut2 {
            0% {
                display: block;

            }

            100% {
                display: none;

            }
        }


        @keyframes fade_up {
            0% {


                opacity: 1;
            }

            100% {
                opacity: 0;


            }
        }
    </style>
    <title>Asset MIS Login</title>
</head>

<body>

    @if (Session::has('fail'))
        <div id="toast"
            class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 fill-red-800 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        {{ Session::get('fail') }}
                    </p>
                </div>
            </div>
        </div>
        </div>
    @endif
    @if (Session::has('error'))
        <div id="toast"
            class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 fill-red-800 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        {{ Session::get('error') }}
                    </p>
                </div>
            </div>
        </div>
        </div>
    @endif
    @if (Session::has('success'))
        <div id="toast"
            class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
            role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 fill-lime-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                        </path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                        {{ Session::get('success') }}
                    </p>
                </div>
            </div>
        </div>
        </div>
    @endif

    <div id="toast_red"
        class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700"
        role="alert" tabindex="-1" aria-labelledby="hs-toast-warning-example-label">
        <div class="flex p-4">
            <div class="shrink-0">
                <svg class="shrink-0 size-4 fill-rose-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                    </path>
                </svg>
            </div>
            <div class="ms-3">
                <p id="hs-toast-warning-example-label" class="text-sm text-gray-700 dark:text-neutral-400">
                    Error
                </p>
            </div>
        </div>
    </div>
    <!-- Toast -->

    <section class= "min-w-full min-h-screen flex justify-center align-middle   dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 id="label_big"
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Reset Your Password
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="/reset/password/submit" method="POST" id="form_login">

                        @csrf
                        <div>
                            <label for="">User</label>
                            <input type="text" disabled value="{{ $user->fname . ' ' . $user->lname }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <label for="password1"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password </label>
                            <input type="password" name="password" id="password1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>

                            <input type="text" name="user_id" value="{{ $user->id }}" class="hidden">
                            <input type="text" name="temp_code" value="{{ $tempCode->code }}" class="hidden">
                            <label for="name_email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Re type
                                Password</label>
                            <input type="password" id="password2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                            <ul class="password-requirements">
                                <li id="uppercase">❌ At least one uppercase letter</li>
                                <li id="lowercase">❌ At least one lowercase letter</li>
                                <li id="number">❌ At least one number</li>
                                <li id="symbol">❌ At least one special symbol</li>
                                <li id="match">❌ Passwords must match</li>
                            </ul>
                            <div><input type="checkbox" onclick="view_pass()"> <span>view password</span></div>
                            <button type="submit" id="button_submit"
                                class="w-full text-white hidden  hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Reset
                                Now
                            </button>

                        </div>







                    </form>
                </div>
            </div>
        </div>
    </section>

    <div id="loading"
        class="fixed inset-0 flex items-center justify-center z-[9999] pointer-events-none opacity-100 transition-opacity duration-700 ">
        <div
            class="flex  flex-col items-center justify-center p-6 rounded-2xl shadow-2xl bg-cyan-600 dark:bg-gray-800/90 w-64 sm:w-72 backdrop-blur animate-fade">

            <!-- Spinner with percentage -->
            <div class="relative mb-4 w-14 h-14 bg-cyan-600">
                <svg class="w-14 h-14 text-cyan-400 animate-spin-fast drop-shadow-lg" viewBox="0 0 50 50">
                    <circle class="opacity-20" cx="25" cy="25" r="22" stroke="currentColor"
                        stroke-width="4" fill="none"></circle>
                    <path class="opacity-80" fill="currentColor"
                        d="M25 5a20 20 0 1 0 20 20A20 20 0 0 0 25 5zm0 36a16 16 0 1 1 16-16 16 16 0 0 1-16 16z">
                    </path>
                </svg>
                <div id="percent_text"
                    class="absolute inset-0 flex items-center justify-center text-sm font-bold text-gray-800 dark:text-gray-100">
                    0%
                </div>
            </div>

            <!-- Loading text with animated dots -->
            <h1 id="loading_text" class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 tracking-wide">
                Loading
            </h1>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                <div id="progress_bar"
                    class="progress-glow h-3 w-0 transition-all duration-300 ease-out rounded-full">
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    let toast_red = document.getElementById('toast_red');
    let password1 = document.getElementById('password1');
    let password2 = document.getElementById('password2');
    const reqUppercase = document.getElementById('uppercase');
    const reqLowercase = document.getElementById('lowercase');
    const reqNumber = document.getElementById('number');
    const reqSymbol = document.getElementById('symbol');
    const reqMatch = document.getElementById('match');

    let blockEnter = true; // initially block Enter

    view_state = 0;

    function view_pass() {
        if (view_state === 0) {
            password1.type = "text";
            password2.type = "text";
            view_state = 1;
        } else {
            password1.type = "password";
            password2.type = "password";
            view_state = 0;
        }
    }
    // Function to prevent Enter
    function preventEnter(e) {
        if (blockEnter && e.key === 'Enter') e.preventDefault();
    }

    password1.addEventListener('keydown', preventEnter);
    password2.addEventListener('keydown', preventEnter);

    function updateRequirements() {
        const pass = password1.value;
        const confirmPass = password2.value;

        const hasUppercase = /[A-Z]/.test(pass);
        const hasLowercase = /[a-z]/.test(pass);
        const hasNumber = /[0-9]/.test(pass);
        const hasSymbol = /[^A-Za-z0-9]/.test(pass);
        const isMatch = pass && confirmPass && pass === confirmPass;

        reqUppercase.classList.toggle('valid', hasUppercase);
        reqUppercase.textContent = (hasUppercase ? '✅ ' : '❌ ') + "At least one uppercase letter";

        reqLowercase.classList.toggle('valid', hasLowercase);
        reqLowercase.textContent = (hasLowercase ? '✅ ' : '❌ ') + "At least one lowercase letter";

        reqNumber.classList.toggle('valid', hasNumber);
        reqNumber.textContent = (hasNumber ? '✅ ' : '❌ ') + "At least one number";

        reqSymbol.classList.toggle('valid', hasSymbol);
        reqSymbol.textContent = (hasSymbol ? '✅ ' : '❌ ') + "At least one special symbol";

        if (!confirmPass) {
            reqMatch.classList.remove('valid');
            reqMatch.textContent = "❌ Passwords must match";
        } else {
            reqMatch.classList.toggle('valid', isMatch);
            reqMatch.textContent = (isMatch ? '✅ ' : '❌ ') + "Passwords must match";
        }

        // If password is valid
        if (hasUppercase && hasLowercase && hasNumber && hasSymbol && isMatch) {
            showToast("✅ Password is valid!");
            document.getElementById('button_submit').style.display = "block";

            // Allow Enter now
            blockEnter = false;
        } else {
            // Still block Enter
            blockEnter = true;
            document.getElementById('button_submit').style.display = "none";
        }
    }

    // Live update while typing
    password1.addEventListener("input", updateRequirements);
    password2.addEventListener("input", updateRequirements);




    document.addEventListener("DOMContentLoaded", async () => {
        try {
            const data = await showLoader(async () => {
                // simulate some initial async task
                await new Promise(resolve => setTimeout(resolve, 10));
                return {
                    message: "Page ready"
                };
            });
            console.log(data);
        } catch (err) {
            console.error(err);
        }
    });

    async function showLoader(asyncTask) {
        const loadingDiv = document.getElementById("loading");
        const percentText = document.getElementById("percent_text");
        const progressBar = document.getElementById("progress_bar");
        const loadingText = document.getElementById("loading_text");

        if (!loadingDiv || !percentText || !progressBar || !loadingText) return;

        // Show loader
        loadingDiv.classList.remove("hidden");
        loadingDiv.style.opacity = "1";

        // Reset UI
        progressBar.style.width = "0%";
        percentText.innerText = "0%";

        let progress = 0;
        let finished = false;

        // Smooth progress simulation
        const interval = setInterval(() => {
            if (!finished) {
                progress += Math.random() * 5 + 1; // slow increment
                if (progress > 95) progress = 95; // cap until task finishes
            } else {
                progress += 2; // finish fast
                if (progress >= 100) progress = 100;
            }
            progressBar.style.width = progress + "%";
            percentText.innerText = Math.floor(progress) + "%";
        }, 100);

        let result;
        try {
            result = await asyncTask();
            finished = true;
        } catch (err) {
            finished = true;
            clearInterval(interval);
            throw err;
        }

        // Ensure 100% at the end
        progressBar.style.width = "100%";
        percentText.innerText = "100%";
        clearInterval(interval);

        // Fade out
        setTimeout(() => {
            loadingDiv.style.opacity = "0";
            setTimeout(() => {
                loadingDiv.classList.add("hidden");
            }, 500);
        }, 500);

        return result;
    }

    function showToast(message) {
        const p = toast_red.querySelector("p");
        if (p) {
            p.innerHTML = message;
        }
        toast_red.style.display = 'block';

        // optional: reset animation so it works every time
        toast_red.classList.remove("fade-in");
        void toast_red.offsetWidth; // force reflow
        toast_red.classList.add("fade-in");

        // optional auto-hide after 3s
        setTimeout(() => {
            toast_red.style.display = 'none';
        }, 3000);
    }

    function showToast(message) {
        const p = toast_red.querySelector("p");
        if (p) {
            p.innerHTML = message;
        }
        toast_red.style.display = 'block';

        // optional: reset animation so it works every time
        toast_red.classList.remove("fade-in");
        void toast_red.offsetWidth; // force reflow
        toast_red.classList.add("fade-in");

        // optional auto-hide after 3s
        setTimeout(() => {
            toast_red.style.display = 'none';
        }, 3000);
    }
</script>

</html>
