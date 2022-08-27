@extends('layout.index')

@section('content')
<div class="p-5">

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

    <div class="my-10  w-full grid grid-cols-3">
        <div class="pt-4 pb-2 px-6 mb-5 col-span-2 ">
            <div class="flex items-center">
              <div class="shrink-0">
                <img src="{{ asset('images/user-picture.jpg') }}" class="rounded-full w-20 ring-2 ring-blue-400 ring-offset-2" alt="Avatar">
              </div>
              <div class="grow ml-5 flex gap-5 divide-x-2">
                <div class="pl-5">
                    <span class="text-xs italic">Name</span>
                    <p>{{ $user->name }}</p>
                </div>
                <div class="pl-5">
                    <span class="text-xs italic">NIP</span>
                    <p>{{ $user->nip }}</p>
                </div>
                <div class="pl-5">
                    <span class="text-xs italic">OPD</span>
                    <p>{{ $user->useronopd->opd->opd_name }}</p>
                </div>
              </div>
            </div>

            <div class="mt-10">
                <div class="col-span-2">
                    <form class="w-fit flex items-center">
                        <input type="month" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="date" value="{{ request('date') ?? now()->format('Y-m') }}">
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
                                        Distance
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
                                        {{ $absen->jarak . ' m' }}
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
        </div>

        <div class="col-span-1 bg-[#5A88C6]/5 text-[#5A88C6] p-5 divide-y-2">
            <div>
                <span class="text-sm italic font-semibold">Joined Date</span>
                <p class="pb-2 leading-8">{{ $user->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <span class="text-sm italic font-semibold">NIK</span>
                <p class="pb-2 leading-8">{{ $user->userDetail->nik }}</p>
            </div>
            <div>
                <span class="text-sm italic font-semibold">Pangkat</span>
                <p class="pb-2 leading-8">{{ $user->userDetail->pangkat }}</p>
            </div>
            <div>
                <span class="text-sm italic font-semibold">Jabatan</span>
                <p class="pb-2 leading-8">{{ $user->userDetail->jabatan }}</p>
            </div>
        </div>

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
@endsection
