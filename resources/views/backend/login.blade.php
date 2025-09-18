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
            display: none;
            position: absolute;
            top: 40px;
            left: 50%;
            z-index: 99;
            transform: translate(-50%, -50%);
            animation: fade_up 10s forwards;
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

        #loading h1 {
            margin: 0 10px;
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
    <link rel="stylesheet" href="{{ URL('/assets/css/style_backend.css') }}">
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
    </div>
    <!-- Toast -->

    <section class= "min-w-full min-h-screen flex justify-center align-middle   dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="/login/submit" method="POST" id="form_login"
                        onsubmit="event.preventDefault(); submit_with_api();">
                        @csrf
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User Name or
                                Email</label>
                            <input type="text" name="name_email" id="name_email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" required="">
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="">
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                                </div>
                            </div>
                            <a href="/forgot/password"
                                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot
                                password?</a>
                        </div>
                        <button type="submit" id="button_submit"
                            class="w-full text-white  hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign
                            in</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <div id="loading"
        class="fixed inset-0 flex items-center justify-center z-[9999] pointer-events-none opacity-100 transition-opacity duration-700">
        <div
            class="flex flex-col items-center justify-center p-6 rounded-2xl shadow-2xl bg-white/90 dark:bg-gray-800/90 w-64 sm:w-72 backdrop-blur animate-fade">

            <!-- Spinner with percentage -->
            <div class="relative mb-4 w-14 h-14">
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
</body>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
    let toast_red = document.getElementById('toast_red');

    async function submit_with_api() {
        try {
            const response = await showLoader(() =>
                fetch('/api/login/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name_email: document.getElementById('name_email').value,
                        password: document.getElementById('password').value,
                        remember: document.getElementById('remember').checked,
                    }),
                })
            );

            let data = {};
            try {
                data = await response.json();
            } catch (e) {
                // ignore JSON parse error (like 401 with empty body)
                data = {};
            }

            if (response.ok) {
                console.log('Login successful:', data);
                if (data.token) {
                    localStorage.setItem('token', data.token);
                }
                document.getElementById('form_login').submit();
            } else {
                // always run on 401/403/other errors
                showToast(data.message || "Invalid Credential.");
            }
        } catch (error) {
            showToast("Server error, please try again.");
            console.error(error);
        }
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

        // Run your async task
        let result;
        try {
            result = await asyncTask();
            finished = true;
        } catch (err) {
            console.error(err);
            finished = true;
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
</script>

</html>
