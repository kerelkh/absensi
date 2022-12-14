@extends('layout.index')

@section('content')
<div class="p-5 bg-white rounded-lg shadow">

    <nav class="flex mb-5 pb-2 border-b border-gray-400" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/admin/dinas/users" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
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

    <div class="my-10">
                <h1 class="text-gray-800 pl-2 w-full border-l-4 border-green-600 text-2xl mb-5">OPD User</h1>
                <form action="{{ URL::current() }}" method="POST" onsubmit="confirmUpdateOPD(event)">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-5">
                        <div>
                            <p class="text-sm mb-5">OPD Sebelumnya</p>
                            <p class="text-sm">Pindahkan Ke OPD</p>
                        </div>

                        <div>
                            <p class="text-sm mb-5">: {{ ($user->useronopd) ? $user->useronopd->opd->opd_name : 'Tidak ada OPD' }}</p>
                            <p class="text-sm">: {{ Auth()->user()->useronopd->opd->opd_name }}</p>
                        </div>

                    </div>
                    <button type="submit" class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ambil</button>
                </form>
            </div>
</div>

<script>
    function confirmUpdateOPD(e) {
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
</script>
@endsection
