@extends('backend.master')
@section('content')
@section('header')
    Dashboard Admin
@endsection

<div id="top-filters" class="sticky top-0 z-50">
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/chartjs-plugin-datalabels.js') }}"></script>
    <div class="flex items-center justify-between  bg-white dark:bg-black  p-2.5">
        <span class="mb-4 t xt-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
                class="text-transparent bg-clip-text bg-gradient-to-r to-amber-600 from-amber-400">Sumarry</span> Assets
            Data
        </span>
        <div class="flex items-center ">
            <div class="mx-2">
                <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    Report</label>
                <select id="report" name="report"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    onchange="redirectToYearMonth()">
                    <option value="1" @if ($report == 1) selected @endif>Sumarry</option>
                    <option value="2" @if ($report == 2) selected @endif>Department and Company
                    </option>
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
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>



    <div
        class="text-sm font-medium text-center bg-white text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap justify-center -mb-px bg-gray-50 dark:bg-gray-800 p-2 rounded-lg shadow-sm">

            <!-- All tab -->
            <li class="mx-2">
                <a href="#all-charts"
                    class="inline-block px-6 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700
                      rounded-lg border border-gray-200 dark:border-gray-600
                      hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-blue-600 transition-all duration-200
                      font-medium text-sm">
                    All
                </a>
            </li>

            <!-- Company tabs -->
            @foreach ($labels_company as $index => $item)
                <li class="mx-2">
                    <a href="#department-company{{ $item }}"
                        class="inline-block px-6 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700
                          rounded-lg border border-gray-200 dark:border-gray-600
                          hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-blue-600 transition-all duration-200
                          font-medium text-sm">
                        {{ $item === null || $item === '' ? 'N/A' : $item }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>





<script>
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
</script>
<div id="main_cart" class="grid grid-cols-1 p-4 bg-white  dark:bg-white gap-4">
    {{-- Grid Layout --}}
    <div
        class="grid grid-cols-1 lg:grid-cols-1 md:grid-cols-1  justify-start bg-white dark:bg-white h-full w-full gap-2">


        <div class="flex flex-col items-center justify-center p-4">

            <div class="flex items-center justify-center w-full">
                <canvas id="Recordbycompany" width="400" height="600"></canvas>
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

    </div>
    @foreach ($departmentsData as $company => $deptData)
        <div id="department-company{{ $company }}"
            class="chart-wrapper flex flex-col items-center justify-center p-4 w-full">
            <!-- Chart container -->
            <div class="relative w-full chart_cont">
                <canvas id="chart-department-{{ $company }}"></canvas>
            </div>
            <h3 class="mt-2 font-semibold">
                Total Assets on {{ $company }} at {{ $year_name }}: Total ({{ $deptData['total'] }}) Assets
            </h3>

            <script>
                const data_record_this_month_department{{ $company }} = {
                    labels: @json($deptData['labels']),
                    datasets: [{
                        label: 'Summary Record on ' + {!! json_encode($month_name . ' ' . $year) !!},
                        data: @json($deptData['data']),
                        backgroundColor: colors, // your color array
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                };

                new Chart(document.getElementById('chart-department-{{ $company }}'), {
                    type: 'bar',
                    data: data_record_this_month_department{{ $company }},
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
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
                                    if (total === 0) return value;
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
            </script>
        </div>
    @endforeach





</div>







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

    // Chart 1 - This Company
    const data_record_this_month = {
        labels: @json($labels_company),
        datasets: [{
            label: 'Summary Record on ' + {!! json_encode($month_name . ' ' . $year) !!},
            data: @json($data_company),
            backgroundColor: colors, // array of colors
            borderColor: borderColors, // border colors
            borderWidth: 1
        }]
    };

    new Chart(document.getElementById('Recordbycompany'), {
        type: 'doughnut', // 🔥 change bar → doughnut
        data: data_record_this_month,
        options: {
            responsive: true,
            maintainAspectRatio: false, // allow full screen scaling
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 18, // bigger legend text
                            weight: 'bold'
                        },
                        padding: 20
                    }
                },
                datalabels: {
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 20 // bigger numbers inside
                    },
                    formatter: (value, context) => {
                        const dataArr = context.chart.data.datasets[0].data.map(Number);
                        const total = dataArr.reduce((sum, val) => sum + val, 0);
                        if (total === 0) return value;
                        const percent = ((value / total) * 100).toFixed(1);
                        return `${value} (${percent}%)`;
                    }
                }
            },
            layout: {
                padding: 10 // give some spacing around chart
            }
        },
        plugins: [ChartDataLabels]
    });

    const chartWrappers = document.querySelectorAll('.chart-wrapper'); // department charts
    const mainChart = document.getElementById('Recordbycompany'); // main chart container
    const topFilters = document.getElementById('top-filters'); // sticky top
    const topOffset = topFilters ? topFilters.offsetHeight : 0;

    document.querySelectorAll('a[href^="#"]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);

            if (targetId === 'all-charts') {
                // Show all charts + main chart
                chartWrappers.forEach(c => c.style.display = 'flex');
                if (mainChart) mainChart.style.display = 'block';
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else {
                // Hide all department charts + main chart
                chartWrappers.forEach(c => c.style.display = 'none');
                if (mainChart) mainChart.style.display = 'none';

                // Show only the selected department chart
                const targetChart = document.getElementById(targetId);
                if (targetChart) {
                    targetChart.style.display = 'flex';

                    // Scroll so chart bottom aligns with bottom of viewport, considering sticky top
                    const chartBottom = targetChart.offsetTop + targetChart.offsetHeight;
                    const scrollY = chartBottom - window.innerHeight + topOffset;
                    window.scrollTo({
                        top: scrollY,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
</script>

@endsection
