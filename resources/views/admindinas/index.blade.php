@extends('layout.index')

@section('content')
    <div class="p-5 bg-white rounded-lg shadow">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-10">Dinas <br><span class="text-base text-red-600 @If(Auth::user()->useronopd ?? false)text-green-600 @endif">OPD: {{ Auth::user()->useronopd->opd->opd_name ?? 'Belum Terhubung Ke OPD' }}</span></h1>

        @if(Auth::user()->useronopd ?? false)
        <div class="my-10">
            <div class="w-[280px] h-[280px]">
                <canvas id="chart"></canvas>
            </div>
        </div>

        @endif

    </div>


    <script>
        const data = {
            labels: [
                'Tervalidasi ' + {{ $validateUsers }},
                'Blue ' + {{ $nonValidateUsers }},
            ],
            datasets: [{
                label: 'Tervalidasi/Belum Tervalidasi',
                data: [{{ $validateUsers }}, {{ $nonValidateUsers }}],
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                ],
                hoverOffset: 4
            }]
            };

        const config = {
        type: 'doughnut',
        data: data,
        };

        const chart = new Chart('chart', config);
    </script>
@endsection
