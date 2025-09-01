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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6  bg-white dark:bg-black">

        {{-- Chart 0: Assets This Month --}}
        <div class="flex flex-col items-center justify-between bg-white dark:bg-gray-800 p-4 rounded shadow h-96">

            <canvas id="thismonthchart"></canvas>
           <h4 class="mb-2 font-semibold text-gray-800 dark:text-white">Register Assets on {{$month_name}} {{$year_name}}
                ({{ $total_qty_this_month }} Assets)
            </h4>
        </div>

        {{-- Chart 0: Assets This Month --}}
        <div class="flex flex-col items-center justify-between bg-white dark:bg-gray-800 p-4 rounded shadow h-96">

            <canvas id="thisyearchart"></canvas>
            <h4 class="mb-2 font-semibold text-gray-800 dark:text-white">New Register Assets on {{$year_name}}
                ({{ $total_qty_this_year }} Assets)
            </h4>
        </div>
        {{-- Chart 0: Assets This Month --}}
        <div class="flex flex-col items-center justify-between bg-white dark:bg-gray-800 p-4 rounded shadow h-96">

            <canvas id="movementthis_month"></canvas>
            <h4 class="mb-2 font-semibold text-gray-800 dark:text-white">Movement on {{$month_name}} {{$year_name}}
                ({{ $movement }} Movements)
            </h4>
        </div>
        <div class="flex flex-col items-center justify-between bg-white dark:bg-gray-800 p-4 rounded shadow h-96">

            <canvas id="movementthis_year"></canvas>
            <h4 class="mb-2 font-semibold text-gray-800 dark:text-white">Movement on {{$month_name}} {{$year_name}}
                ({{ $movement_year }} Movements)
            </h4>

        </div>
    </div>


    <script>
        function redirectToYearMonth() {
            const y = document.getElementById('year').value;
            const m = document.getElementById('month').value;
            const r = document.getElementById('report').value;
            window.location.href = `/admin/dasboard/${r}/${y}/${m}`;
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


        new Chart(document.getElementById('thismonthchart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($this_month_status->keys()) !!}, // ["received","accepted","disposal"]
                datasets: [{
                    data: {!! json_encode($this_month_status->values()) !!}, // [25,12,4]
                    backgroundColor: [
                        '#4CAF50', // received - green
                        '#2196F3', // accepted - blue
                        '#F44336', // disposal - red
                        '#FF9800', // pending - orange
                        '#9C27B0', // rejected - purple
                        '#00BCD4', // in-progress - cyan
                        '#FFC107', // review - amber
                        '#E91E63', // cancelled - pink
                        '#3F51B5', // approved - indigo
                        '#8BC34A' // on-hold - light green
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // allows chart to fill container
                cutout: '50%', // makes doughnut thinner or thicker (adjust %)
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
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
                    },
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percent = total === 0 ? 0 : ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            },

            plugins: [ChartDataLabels]
        });





        // thisyearchart
        new Chart(document.getElementById('thisyearchart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($this_year_status->keys()) !!}, // ["received","accepted","disposal"]
                datasets: [{
                    data: {!! json_encode($this_year_status->values()) !!}, // [25,12,4]
                    backgroundColor: [
                        '#4CAF50', // received - green
                        '#2196F3', // accepted - blue
                        '#F44336', // disposal - red
                        '#FF9800', // pending - orange
                        '#9C27B0', // rejected - purple
                        '#00BCD4', // in-progress - cyan
                        '#FFC107', // review - amber
                        '#E91E63', // cancelled - pink
                        '#3F51B5', // approved - indigo
                        '#8BC34A' // on-hold - light green
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // allows chart to fill container
                cutout: '50%', // makes doughnut thinner or thicker (adjust %)
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
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
                    },
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percent = total === 0 ? 0 : ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            },
            plugins: [ChartDataLabels]
        });





        const labels = ['Active', 'Inactive'];
        const data = [{!! $active_count !!}, {!! $inactive_count !!}]; // -> [532,78]

        // Chart 3
        new Chart(document.getElementById('movementthis_month'), {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: data,
                    backgroundColor: ['#4CAF50', '#F44336'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // allows chart to fill container
                cutout: '50%', // makes doughnut thinner or thicker (adjust %)
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
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
                    },
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percent = total === 0 ? 0 : ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            },
            plugins: [ChartDataLabels]
        });




        // Chart 4
        const labels_year = ['Active', 'Inactive'];
        const data_year = [{!! $active_count_year !!}, {!! $inactive_count_year !!}]; // -> [532,78]

        // Chart 3
        new Chart(document.getElementById('movementthis_year'), {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: data_year,
                    backgroundColor: ['#4CAF50', '#F44336'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // allows chart to fill container
                cutout: '50%', // makes doughnut thinner or thicker (adjust %)
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
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
                    },
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const percent = total === 0 ? 0 : ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

@endsection
