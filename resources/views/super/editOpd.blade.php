@extends('layout.index')

@section('content')
<div class="p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-[#5A88C6] text-2xl mb-5">OPD: {{ $opd->opd_name }}</h1>
    </div>

    <div class="mt-5 flex gap-10 items-center">
        <a href="/opd" class="inline-block text-blue-400 hover:text-blue-700"><i class="fa-solid fa-arrow-left"></i> Back</a>
        <form method="POST" onsubmit="confirmDeleteinformation(event)">
            @csrf
            @method('delete')
            <button class="bg-red-800 hover:bg-red-600 py-2 px-5 rounded-md text-white"><i class="fa-solid fa-trash"></i> Delete</button>
        </form>
    </div>

    <div class="mt-10">
        <form method="POST" onsubmit="confirmUpdateinformation(event)">
            @csrf
            @method('PUT')

            <div class="relative z-0 w-1/2 mb-6 group">
                <input type="text" name="opd_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $opd->opd_name }}" placeholder=" " required="">
                <label for="text" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">OPD Name</label>
                @error('opd_name')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative z-0 w-1/2 mb-6 group">
                <input type="text" name="opd_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $opd->opd_address }}" placeholder=" " required="">
                <label for="text" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">OPD Address</label>
                @error('opd_address')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative z-0 w-1/2 mb-6 group">
                <input type="text" name="opd_longitude" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $opd->opd_longitude }}" placeholder=" " required="">
                <label for="text" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">OPD Longitude</label>
                @error('opd_longitude')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative z-0 w-1/2 mb-6 group">
                <input type="text" name="opd_latitude" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $opd->opd_latitude }}" placeholder=" " required="">
                <label for="text" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">OPD latitude</label>
                @error('opd_latitude')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative z-0 w-1/2 mb-6 group">
                <input type="number" name="distance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $opd->distance }}" placeholder=" " required="">
                <label for="text" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Distance (meter)</label>
                @error('distance')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>



            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Perubahan</button>
        </form>
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
            confirmButtonText: 'Ya, Update OPD!'
            }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
            })
    }

    function confirmDeleteinformation(e) {
        e.preventDefault();
        Swal.fire({
            text: "Apakah kamu yakin ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Delete OPD!'
            }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
            })
    }
</script>

@endsection
