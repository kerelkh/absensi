@extends('layout.index')

@section('content')
    <div class="p-5">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-[#5A88C6] text-2xl mb-10">News</h1>


        <div class="grid grid-cols-2 gap-5">
            <form method="POST" enctype="multipart/form-data" class="col-span-1" onsubmit="confirmSave(event)">
                @csrf
                <div class="my-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" placeholder="Your Title...">
                    @error("title")
                        <span class="text-sm text-red-800 italice">{{ $message }}</span>
                    @enderror
                </div>
                <div class="my-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="image">Image</label>
                    <input type="file" name="image" id="image" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="image_file" required="">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="image_file">File must be image.</p>
                    @error("image")
                        <span class="text-sm text-red-800 italice">{{ $message }}</span>
                    @enderror
                </div>
                <div class="my-5">
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your content</label>
                    <textarea id="content" name="content" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="resize: none;" required="" placeholder="Your Content..."></textarea>
                    @error("content")
                        <span class="text-sm text-red-800 italice">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="py-2.5 px-10 text-sm font-medium text-white bg-[#5A88C6] transition rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
            </form>

            <div class="col-span-1 p-5 bg-blue-400/10 rounded-lg">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-500 mb-5">List News</h2>
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

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Image
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Title
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Created At
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($newses as $news)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="shrink-0">
                                            <img src="{{ asset('storage/'. $news->image) }}" class="w-10" alt="Avatar">
                                        </div>
                                    </th>
                                    <td class="py-4 px-6">
                                        <a href="{{ URL::current() . '/' . $news->slug }}" class="text-blue-600 dark:text-blue-500 hover:underline">{{ $news->title }}</a>
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $news->created_at->diffForHumans() }}
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="{{ URL::current() . '/' . $news->slug . '/edit' }}" class="font-medium bg-blue-400 hover:bg-blue-600 text-white p-2 rounded-lg"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    </td>
                                </tr>
                            @empty

                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="my-2">
                    {{ $newses->links('vendor.pagination.tailwind') }}
                </div>

            </div>
        </div>
    </div>

    <script>
        function confirmSave(e) {
            e.preventDefault();
            Swal.fire({
                text: "Apakah kamu yakin ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan Berita!'
                }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
                })
        }
    </script>
@endsection
