@extends('backend.master')
@section('content')
    <script>
        // Initialize Array for Chart Data
        var boxData = [];
    </script>
    @php
        // Chart 1
        // Fetch data as an array of key-value pairs where key is value and value is count
        $data = \App\Models\StoredAssets::selectRaw('company, COUNT(*) as count')
            // where('box_id', $box->id)
            // ->
            ->groupBy('company')
            ->get()
            ->mapWithKeys(function ($item) {
                // Ensure both key (value) and count are being properly accessed and casted
                return [$item->company => (int) $item->count]; // Cast count to integer
            });

        // Get the count of the data array
        $count_arr = $data->count();

        // Chart 2
        // Fetch data as an array of key-value pairs where key is value and value is count
        $data_department = \App\Models\StoredAssets::selectRaw('department, COUNT(*) as count')
            // where('box_id', $box->id)
            // ->
            ->groupBy('department')
            ->get()
            ->mapWithKeys(function ($item) {
                // Ensure both key (value) and count are being properly accessed and casted
                return [$item->department => (int) $item->count]; // Cast count to integer
            });

        // Get the count of the data array
        $count_arr_department = $data->count();

        // Chart 3
        // Convert the collection to an array
        $data_by_year = \App\Models\StoredAssets::selectRaw('YEAR(issue_date) as year, COUNT(*) as count')
            ->groupByRaw('YEAR(issue_date)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->year => (int) $item->count];
            });
        $count_arr_year = $data_by_year->count();
    @endphp
    {{-- // id: @json($box->id), --}}


    {{-- Push Data to Array for Chart Display  --}}
    <script>
        var data = @json($data);
        var count_arr = @json($count_arr);
        // Chart 1 Data
        boxData.push({

            id: 1,
            data: @json($data),
            count_arr: @json($count_arr),
            type_chart: 'donut'
        });
        // Chart 2 Data
        boxData.push({
            id: 2,
            data: @json($data_department),
            count_arr: @json($count_arr_department),
            type_chart: 'donut'
        });


        var data_by_year = @json($data_by_year);
        var count_arr2 = @json($count_arr_year);
        // Chart 3 Data
        boxData.push({

            id: 3,
            data: @json($data_by_year),
            count_arr: @json($count_arr_year),
            type_chart: 'label'
        });
    </script>
    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 justify-start bg-white dark:bg-black h-full w-full">

        {{-- Dynamic Chart --}}
        <div><div class="py-6" id="donut-chart1"></div></div>
        {{-- <div><div class="py-6" id="donut-chart2"></div></div> --}}
        <div><div id="donut-chart3" class="px-2.5"></div></div>

    </div>

    {{-- Chart Source  --}}
    <script src="{{ URL('assets/JS/apexcharts.min.js') }}"></script>
    {{-- Chart Data  --}}
    <script>

        boxData.map((item, index) => {
            call_apekchart(item.id, item.count_arr, item.data, item.type_chart);

        });


        function call_apekchart(id, count_arr, data, type_chart) {

            if (type_chart == 'donut') {

                if (document.getElementById("donut-chart" + id) && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("donut-chart" + id), getChartOptions_donut(
                        count_arr, data));
                    chart.render();
                }
            } else {

                if (document.getElementById("donut-chart" + id) && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("donut-chart" + id), getChartOptions_label(
                        count_arr,
                        data));
                    chart.render();
                }
            }

        }



        function getChartOptions_donut(arr_num, data) {


            let serie = []; // Make sure it's initialized as an empty array
            let label = []; // Make sure it's initialized as an empty array

            for (let key in data) {
                serie.push(data[key]); // Push the value
                label.push(key || 'NA Company'); // Push the key

            }

            const getChartOptions = () => {
                return {
                    series: serie,
                    colors: serie.map(() => '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')),


                    chart: {
                        height: 320,
                        width: "100%",
                        type: "donut",
                    },
                    stroke: {
                        colors: ["transparent"],
                        lineCap: "",
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: 20,
                                    },
                                    total: {
                                        showAlways: true,
                                        show: true,
                                        label: "All Assets Data",
                                        fontFamily: "Inter, sans-serif",
                                        formatter: function(w) {
                                            const sum = w.globals.seriesTotals.reduce((a, b) => {
                                                return a + b
                                            }, 0)
                                            return sum + 'Assets'
                                        },
                                    },
                                    value: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: -20,
                                        formatter: function(value) {
                                            return value + "Assets"
                                        },
                                    },
                                },
                                size: "80%",
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -2,
                        },
                    },
                    labels: label,
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        position: "bottom",
                        fontFamily: "Inter, sans-serif",
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "Assets"
                            },
                        },
                    },
                    xaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "k"
                            },
                        },
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                    },
                }
            }
            return getChartOptions();
        }

        function getChartOptions_label(arr_num, data) {


            let serie = [];
            let label = [];

            for (let key in data) {

                if (key == null || key == undefined || key == '') {


                } else {
                    serie.push(data[key]);
                    label.push(key);
                }

            }
            const options = {
                xaxis: {
                    show: true,
                    categories: label,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: true,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        },
                        formatter: function(value) {
                            return value + ' Assets';
                        }
                    }
                },
                series: [{
                    name: "Assets by Issue Date",
                    data: serie,
                    color: "#1A56DB",
                }],
                chart: {
                    sparkline: {
                        enabled: false
                    },
                    height: 320,
                    width: "100%",
                    type: "area",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                        show: false,
                    },
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                        shade: "#1C64F2",
                        gradientToColors: ["#1C64F2"],
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                legend: {
                    show: false
                },
                grid: {
                    show: false,
                },
            };

            return options;
        }
    </script>
@endsection
