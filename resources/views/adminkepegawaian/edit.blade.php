@extends('layout.index')

@section('content')
    <div class="p-5 bg-white rounded-lg shadow">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-10">Informasi User</h1>

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


        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl my-10">Current OPD User</h1>

        <form action="{{ URL::current() }}/opd" method="POST" onsubmit="confirmUpdateOPD(event)">
            @csrf
            @method('PUT')
            <div>
                <label for="opd" class="sr-only">Underline select</label>
                <select id="opd" name="opd" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option value="" selected>Tidak ada OPD</option>
                    @foreach($opds as $opd)
                        <option 
                            value="{{ $opd->id }}"
                            @if($user->useronopd ?? false)
                                @if($user->useronopd->opd->id == $opd->id)
                                selected
                                @endif  
                            @endif
                        >{{ $opd->opd_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update OPD</button>
        </form>

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
                confirmButtonText: 'Ya, Hapus!'
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
    </script>
@endsection
