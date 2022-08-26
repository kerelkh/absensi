@extends('layout.index')

@section('content')
    <div class="p-5">
        <div class="flex justify-between items-center">
            <h1 class="text-gray-800 pl-2 w-full border-l-4 border-[#5A88C6] text-2xl mb-5">Users</h1>
            <form class="flex items-center">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="search" id="search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" value="{{ request('search') }}">
                </div>
                <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-[#5A88C6] transition rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
            </form>
        </div>
        <a href="/admin/kepegawaian/adduser" class="inline-block text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-full px-4 py-3 text-center mb-3"><i class="fa-solid fa-plus mr-5"></i>Tambah user</a>


        <div class="mb-2 w-full grid grid-cols-4 gap-5">
            @forelse ($users as $user)
                <div class="col-span-1 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="pt-4 pb-2 mx-auto w-fit mb-5">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/user-picture.jpg') }}" class="rounded-full w-14" alt="Avatar">
                            </div>
                            <div class="grow ml-3">
                                <p class="text-sm font-semibold">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->nip }}</p>
                                <span class="p-1 rounded-md {{ $user->useronopd?->valid ? 'bg-green-400' : 'bg-red-400' }} text-white text-xs">validasi: {{ $user->useronopd?->valid ? 'Valid' : 'Belum Valid' }}</span>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="w-full flex divide-x-2 text-xs">
                        <div class="grid place-items-center w-full">OPD: {{ $user->useronopd?->opd->opd_name }}</div>
                        <div class="grid place-items-center w-full">Ruang: - </div>
                    </div>
                    <hr class="mt-2">
                    <div class="transition hover:bg-blue-50 text-blue-400 font-semibold">
                        <a href="/admin/kepegawaian/{{ $user->email }}/edit" class="inline-block w-full h-full p-2 text-center">Detail</a>
                    </div>
                </div>
            @empty
                <p class="p-2 w-full font-semibold text-lg">Tidak Ada data ditemukan</p>
            @endforelse

        </div>
        <div class="my-2">
            {{ $users->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>

    </div>
@endsection
