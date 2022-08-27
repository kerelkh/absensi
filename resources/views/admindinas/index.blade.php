@extends('layout.index')

@section('content')
    <div class="p-5 bg-white rounded-lg shadow">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-10">Dinas <br><span class="text-base text-red-600 @If(Auth::user()->useronopd ?? false)text-green-600 @endif">OPD: {{ Auth::user()->useronopd->opd->opd_name ?? 'Belum Terhubung Ke OPD' }}</span></h1>

        @if(Auth::user()->useronopd ?? false)
        <div class="my-10 grid grid-cols-3 gap-5">
            <div class="col-span-1">
                <div class="w-[280px] h-[280px]">
                    <canvas id="chart"></canvas>
                </div>
            </div>
            <div class="col-span-2">
                <h2 class="text-lg font-semibold">Absen</h2>
                <form class="w-fit flex items-center">
                    <input type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="date" value="{{ now()->format('Y-m-d') }}">
                    <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-[#5A88C6] transition rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Filter</button>
                </form>

                {{-- data --}}
                <div class="overflow-x-auto relative mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Picture
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    NIP/Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Time
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Absen Type
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    valid
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absens as $absen)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img src="{{ $absen->photo ? asset('storage/' . $absen->photo) : asset('images/user-picture.jpg') }}" alt="Photo absen" class="w-14 h-14 shadow-lg rounded-md">
                                </th>
                                <td class="py-4 px-6">
                                    {{ $absen->nip }}<br>
                                    {{ $absen->name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ date('d-m-Y H:i:s', strtotime($absen->absen_time)); }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $absen->absen_jenis ? 'Pulang' : 'Masuk' }}
                                </td>
                                <td class="py-4 px-6">
                                   <form action="/admin/dinas/{{ $absen->id }}/valid" method="POST" onsubmit="confirmUpdateValidate(event, '{{ asset('storage/' . $absen->photo) }}')">
                                        @csrf
                                        @method('PUT')
                                        <button class="p-2 rounded-md shadow-md text-white {{ $absen->valid ? 'bg-green-400 hover:bg-green-500' : 'bg-red-400 hover:bg-red-500' }}">{{ $absen->valid ? 'Valid' : 'Belum Valid' }}</button>
                                   </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 px-6 text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        @endif

    </div>

    <script>
        function confirmUpdateValidate(e, imageLink) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                imageUrl: imageLink,
                imageWidth: 400,
                imageAlt: 'Custom image',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update Valid!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }
    </script>

    <script>
        const data = {
            labels: [
                'Valid ' + {{ $validateUsers }},
                'Not valid ' + {{ $nonValidateUsers }},
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
