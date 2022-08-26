@extends('layout.index')

@section('content')
<div class="p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-[#5A88C6] text-2xl mb-5">Data OPD</h1>
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

    <div class="mt-10">
        <a href="/opd/addopd" class="inline-block text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-full px-4 py-3 text-center mb-3"><i class="fa-solid fa-plus mr-5"></i>Tambah opd</a>
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-10">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        OPD Name
                    </th>
                    <th scope="col" class="py-3 px-6">
                        OPD Address
                    </th>
                    <th scope="col" class="py-3 px-6">
                        OPD Longitude
                    </th>
                    <th scope="col" class="py-3 px-6">
                        OPD Latitude
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Distance (Meter)
                    </th>
                    <th scope="col" class="py-3 px-6">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($opds as $opd)
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $opd->opd_name }}
                    </th>
                    <td class="py-4 px-6">
                        {{ $opd->opd_address }}
                    </td>
                    <td class="py-4 px-6">
                        {{ $opd->opd_longitude }}
                    </td>
                    <td class="py-4 px-6">
                        {{ $opd->opd_latitude }}
                    </td>
                    <td class="py-4 px-6">
                        {{ $opd->distance }}
                    </td>
                    <td class="py-4 px-6">
                        <a href="/opd/{{ $opd->slug }}/edit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-6">
                        Tidak Ada OPD
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>


</div>
@endsection
