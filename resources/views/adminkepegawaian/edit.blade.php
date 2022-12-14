@extends('layout.index')

@section('content')
    <div class="p-5">

    <nav class="flex mb-5 pb-2 border-b border-gray-400" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/admin/kepegawaian/users" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
            <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
            Users
            </a>
        </li>
        <li>
            <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <a href="{{ URL::current() }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $user->email }}</a>
            </div>
        </li>
    </nav>

    <div class="w-full grid grid-cols-2 gap-5">
        <div class="col-span-1">
            <div class="w-full bg-white rounded-lg shadow grid place-items-center p-5 bg-cover bg-no-repeat bg-center" style="background-image: url({{ asset('images/background-profile.png') }})">
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/user-picture.jpg') }}" class="rounded-full w-52 ring-1 ring-blue-700 shadow-lg" alt="Avatar">
                <p class="w-full text-center mt-2 font-semibold">Foto Profil</p>
            </div>
            <div class="w-full bg-white rounded-lg shadow grid place-items-center p-5 mt-5">
                <canvas id="myChart" class="w-full"></canvas>
            </div>
            <div class="w-full bg-white rounded-lg shadow grid place-items-center p-5 mt-5">
                <p class="text-lg">Recent Activity</p>
                <p>-</p>
            </div>
        </div>
        <div class="col-span-1">
            <div class="mb-10">
                <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-5">Informasi user</h1>
                <form method="POST" onsubmit="confirmUpdateinformation(event)">
                    @csrf
                    @method('PUT')

                    <div class="relative z-0 w-full mb-6 group">
                        <input type="email" name="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $user->email }}" placeholder=" " required="">
                        <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                        @error('email')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $user->name }}" required="">
                        <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama</label>
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="number" name="nip" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $user->nip }}" required="">
                        <label for="nip" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">NIP</label>
                        @error('nip')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Perubahan</button>
                </form>
            </div>

            <div class="my-10">
                <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-5">Detail user</h1>
                <form action="{{ URL::current() }}/detail" method="POST" onsubmit="confirmUpdateDetail(event)">
                    @csrf
                    @method("PUT")
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="number" name="nik" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $user->userDetail->nik ?? '' }}" required="">
                        <label for="nik" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">NIK</label>
                        @error('nik')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="pangkat" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $user->userDetail->pangkat ?? '-' }}" required="">
                        <label for="pangkat" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pangkat</label>
                        @error('pangkat')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="jabatan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $user->userDetail->jabatan ?? '-' }}" required="">
                        <label for="jabatan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jabatan</label>
                        @error('jabatan')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Detail User</button>
                </form>
            </div>

            @if($user->useronopd ?? false)
            <div class="my-10">
                <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-5">Validasi User</h1>

                <form action="{{ URL::current() }}/validation" method="POST" onsubmit="confirmUpdateValidasi(event)">
                    @csrf
                    @method("PUT")
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="valid" class="sr-only">Validasi</label>
                        <select id="valid" name="valid" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option
                                value="0"
                                @if($user->useronopd->valid == 0)
                                selected
                                @endif
                                >Belum Tervalidasi</option>
                            <option
                                value="1"
                                @if($user->useronopd->valid == 1)
                                selected
                                @endif
                                >Tervalidasi</option>
                        </select>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Validasi</button>
                </form>

            </div>
            @endif

            <div class="my-10">
                <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-5">Ubah password</h1>
                <form action="{{ URL::current() }}/password" method="POST" onsubmit="confirmUpdatePassword(event)">
                    @csrf
                    @method("PUT")
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                        @error('password')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="password_confirmation" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Konfirmasi Password</label>
                        @error('password_confirmation')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Password</button>
                </form>
            </div>
        </div>
    </div>



    </div>

    <script>
        function confirmUpdateinformation(e) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }

        function confirmUpdateOPD(e) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update OPD!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }

        function confirmUpdatePassword(e) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update Password!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }

        function confirmUpdateDetail(e) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update Detail!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }

        function confirmUpdateValidasi(e) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update Validasi!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }
    </script>

    <script>
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Precense Statistic',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
