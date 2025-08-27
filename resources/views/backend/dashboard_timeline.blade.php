@extends('backend.master')
@section('content')
@section('header')
    (Dashboard Admin)
@endsection

<script src="{{ asset('assets/js/chart.js') }}"></script>
<script src="{{ asset('assets/js/chartjs-plugin-datalabels.js') }}"></script>
<div class="flex items-center justify-between  bg-white dark:bg-black  p-2.5">
    <span class="mb-4 t xt-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-amber-600 from-amber-400">Sumarry</span> Assets Data
    </span>
    <div class="flex items-center ">
        <div class="mx-2">
            <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                Report</label>
            <select id="report" name="report" onchange="redirectToYearMonth()"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="1" @if ($report == 1) selected @endif>Sumarry</option>
                <option value="2" @if ($report == 2) selected @endif>Department and Company</option>
                <option value="3" @if ($report == 3) selected @endif>Time Line</option>
            </select>
        </div>
        <div class="mx-2">
            <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                Month</label>
            <select id="month" name="month"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                onchange="redirectToYearMonth()">



                <option value="{{ $month }}">Disabled
                </option>

            </select>
        </div>
        <!-- Year Dropdown -->
        <div>
            <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                Year</label>
            <select id="year" name="year"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                onchange="redirectToYearMonth()">


                <option value="{{ $year }}">Disabled</option>

            </select>
        </div>

    </div>
</div>
</div>

{{-- Grid Layout --}}
<div class="grid grid-cols-1 lg:grid-cols-1 md:grid-cols-1 justify-start bg-white dark:bg-black h-full w-full">



    <div class="flex flex-col items-center justify-center p-4 w-full">
        <div class="w-full mx-auto bg-white dark:bg-gray-900 rounded-xl shadow p-4">
            <canvas id="ChartByYear" class="w-full h-[400px]"></canvas>
        </div>
        <span class="mt-2 text-transparent bg-clip-text bg-gradient-to-r to-purple-600 from-purple-400">
            Movement Active TimeLine

        </span>
    </div>

   <div class="flex flex-col items-center justify-center p-4 w-full">
        <div class="w-full mx-auto bg-white dark:bg-gray-900 rounded-xl shadow p-4">
            <canvas id="register" class="w-full h-[400px]"></canvas>
        </div>
        <span class="mt-2 text-transparent bg-clip-text bg-gradient-to-r to-purple-600 from-purple-400">
            Register Asset TImeLine

        </span>
    </div>

</div>


</div>


<script>
    // 🎨 Colors for bars
    function redirectToYearMonth() {
        const year = document.getElementById('year').value;
        const months_input = document.getElementById('month').value;
        const report = document.getElementById('report').value;
        if ((year && months_input) || (report == 3)) {
            window.location.href = `/admin/dasboard/${report}/${year}/${months_input}`;
        }
    }
    const colors = [
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)'
    ];


    // Data By Year Line Chart


    const yearLabels = @json($labels);
    const activeData = @json($activeData);
    const registerData = @json($registerData);

    new Chart(document.getElementById('ChartByYear'), {
        type: 'line',
        data: {
            labels: yearLabels,
            datasets: [{
                    label: 'Active',
                    data: activeData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },

            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.y} records`
                    }
                },
                datalabels: {
                    anchor: 'end', // position above the point
                    align: 'top',
                    color: '#111',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value) => value // show the quantity
                }
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels] // make sure this plugin is loaded
    });





    new Chart(document.getElementById('register'), {
        type: 'line',
        data: {
            labels: yearLabels,
            datasets: [
                {
                    label: 'Register',
                    data: registerData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.y} records`
                    }
                },
                datalabels: {
                    anchor: 'end', // position above the point
                    align: 'top',
                    color: '#111',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value) => value // show the quantity
                }
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels] // make sure this plugin is loaded
    });


</script>

@endsection
