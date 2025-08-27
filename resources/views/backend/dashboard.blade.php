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
            <select id="report" name="report"
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
                @php
                    $months_label = [
                        'All' => 'All Months',
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                    ];
                @endphp

                @foreach ($months_label as $num => $name)
                    <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>{{ $name }}
                    </option>
                    @php
                        if ($num == $month) {
                            $month_name = $name;
                        }

                    @endphp
                @endforeach
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
                @php
                    use App\Models\StoredAssets;

                    // Get distinct years from transaction_date
                    $years = StoredAssets::selectRaw('YEAR(transaction_date) as year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->pluck('year');

                    $selectedYear = $year ?? ($years->first() ?? \Carbon\Carbon::now()->year);
                @endphp
                <option value="All" {{ $year == 'All' ? 'selected' : '' }}>All Years</option> =
                @foreach ($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

    </div>
</div>
</div>

{{-- Grid Layout --}}
<div class="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 justify-start bg-white dark:bg-black h-full w-full">


    <div class="flex flex-col items-center justify-center p-4">

        <div class="flex items-center justify-center w-full">
            <canvas id="Recordbycompany" width="400" height="200"></canvas>
        </div>
        <span class="text-transparent bg-clip-text bg-gradient-to-r to-purple-600 from-purple-400">Active Asset By
            Company From {{ $month_name }}
            @if ($year == 'All Years ')
                All Year
            @else
                on {{ $year_name }}
            @endif
            &ensp; {{ $totalQty_company }} Assets Active
        </span>
    </div>

    <div class="flex flex-col items-center justify-center p-4 w-full">
        <div class="w-full max-w-4xl mx-auto bg-white dark:bg-gray-900 rounded-xl shadow p-4">
            <canvas id="ChartByYear" class="w-full h-[400px]"></canvas>
        </div>
        <span class="mt-2 text-transparent bg-clip-text bg-gradient-to-r to-purple-600 from-purple-400">
            Active Asset By Year

        </span>
    </div>



</div>
<div class="grid grid-cols-1 lg:grid-cols-1 md:grid-cols-1 justify-start bg-white dark:bg-black h-full w-full min-h-64">
    <div class="flex flex-col items-center justify-center p-4 w-full">
        <div class="relative w-full max-w-6xl"> <!-- limit chart width -->
            <canvas id="Recordbydepartment"></canvas>
        </div>
        <span class="mt-2 text-transparent bg-clip-text bg-gradient-to-r to-purple-600 from-purple-400">
            Active Asset By Department
            @if ($year == 'All')
                All Year
            @else
                on {{ $year_name }}
            @endif
            &ensp; {{ $totalQty_department }} Assets Active
        </span>
    </div>

</div>




{{-- 📊 Summary Record This Month --}}







</div>


<script>
    // 🎨 Colors for bars
    function redirectToYearMonth() {
        const year = document.getElementById('year').value;
        const months_input = document.getElementById('month').value;
        const report = document.getElementById('report').value;
        if (year && months_input) {
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

    const borderColors = [
        'rgba(54, 162, 235, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];

    // Chart 1 - This Company
    const data_record_this_month = {
        labels: @json($labels_company),
        datasets: [{
            label: 'Summary Record on ' + {!! json_encode($month_name . ' ' . $year) !!},
            data: @json($data_company),
            backgroundColor: colors,
            borderColor: borderColors,
            borderWidth: 1
        }]
    };

    new Chart(document.getElementById('Recordbycompany'), {
        type: 'bar',
        data: data_record_this_month,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                datalabels: {
                    anchor: 'center',
                    align: 'center',
                    color: '#000',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value, context) => {
                        const dataArr = context.chart.data.datasets[0].data.map(Number);
                        const total = dataArr.reduce((sum, val) => sum + val, 0);
                        if (total === 0) return value; // avoid division by zero
                        const percent = ((value / total) * 100).toFixed(1);
                        return `${value} (${percent}%)`;
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels]
    });


    // Chart 2- This Department
    const data_record_this_month_department = {
        labels: @json($labels_department),
        datasets: [{
            label: 'Summary Record on ' + {!! json_encode($month_name . ' ' . $year) !!},
            data: @json($data_department),
            backgroundColor: colors,
            borderColor: borderColors,
            borderWidth: 1
        }]
    };

    new Chart(document.getElementById('Recordbydepartment'), {
        type: 'bar',
        data: data_record_this_month_department,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                datalabels: {
                    anchor: 'center',
                    align: 'center',
                    color: '#000',
                    font: {
                        weight: 'bold'
                    },
                    formatter: (value, context) => {
                        const dataArr = context.chart.data.datasets[0].data.map(Number);
                        const total = dataArr.reduce((sum, val) => sum + val, 0);
                        if (total === 0) return value; // avoid division by zero
                        const percent = ((value / total) * 100).toFixed(1);
                        return `${value} (${percent}%)`;
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels]
    });




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




    // Chart initialization
    const myChart = new Chart(document.getElementById('ChartByYear'), {
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
            maintainAspectRatio: false
        }
    });




    let isExpanded = false; // status: small=false, big=true
    const chartContainer = document.getElementById('body_backend');

    chartContainer.addEventListener('click', () => {
        if (!isExpanded) {
            // Expand chart
            chartContainer.style.position = 'absolute';
            chartContainer.style.top = '50px';
            chartContainer.style.left = '50px';
            chartContainer.style.width = '90%';
            chartContainer.style.height = '500px';
            isExpanded = true;
        } else {
            // Collapse chart back
            chartContainer.style.position = 'relative';
            chartContainer.style.width = '600px';
            chartContainer.style.height = '300px';
            isExpanded = false;
        }

        // Update chart to resize
        myChart.resize();
    });

    // Declare only once
</script>

@endsection
