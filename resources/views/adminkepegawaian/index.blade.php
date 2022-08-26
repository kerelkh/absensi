@extends('layout.index')

@section('content')
    <div class="p-5">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-[#5A88C6] text-2xl mb-10">Dashboard</h1>

        <div class="grid grid-cols-3">
            <div class="col-span-2 grid grid-cols-2">
                <div class="col-span-1">
                    <div class="w-full p-2 bg-white shadow-md">
                        <canvas id="chart1" class="w-full"></canvas>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="w-full p-2 bg-white shadow-md">
                        <canvas id="chart3" class="w-full"></canvas>
                    </div>
                </div>

            </div>
            <div class="col-span-1">
                <div class="w-full">
                    <div class="w-full p-2 bg-white shadow-md">
                        <canvas id="chart2" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        const data = {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
            datasets: [
                {
                label: 'Dataset',
                data: [5,2,7,9,10,4],
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, .5)',
                pointStyle: 'circle',
                pointRadius: 10,
                pointHoverRadius: 15
                }
            ]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                title: {
                    display: true,
                    text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
                }
                }
            }
        };

        const chart = document.getElementById('chart1');
        const newChart = new Chart(chart, config);
    </script>

<script>
    const data3 = {
        labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
        datasets: [
            {
            label: 'Dataset',
            data: [5,2,7,9,10,4],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, .5)',
            pointStyle: 'circle',
            pointRadius: 10,
            pointHoverRadius: 15
            }
        ]
    };
    const config3 = {
        type: 'line',
        data: data3,
        options: {
            responsive: true,
            plugins: {
            title: {
                display: true,
                text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
            }
            }
        }
    };

    const chart3 = document.getElementById('chart3');
    const newChart3 = new Chart(chart3, config3);
</script>

<script>
    const data2 = {
    labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
    datasets: [
        {
        label: 'Dataset 1',
        data: [10,45,33,20,37,20],
        backgroundColor: [
            'rgb(255, 22, 132)',
            'rgb(23, 45, 132)',
            'rgb(57, 99, 132)',
            'rgb(255, 99, 22)',
            'rgb(22, 219, 132)',
            'rgb(15, 14, 88)',
        ]
        }
    ]
    };
    const config2 = {
        type: 'polarArea',
        data: data2,
        options: {
            responsive: true,
            plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Polar Area Chart'
            }
            }
        },
    };

    const chart2 = document.getElementById('chart2');
    const newChart2 = new Chart(chart2, config2);
</script>
@endsection
