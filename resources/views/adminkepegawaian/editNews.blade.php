@extends('layout.index')

@section('content')
    <div class="p-5">
        <h1 class="text-gray-800 pl-2 w-full border-l-4 border-[#5A88C6] text-2xl mb-10">Edit News</h1>
        <a href="/admin/kepegawaian/news" class="py-2 text-blue-400 hover:text-blue-700"><i class="fa-solid fa-arrow-left"></i> Back</a>

        <form method="POST" enctype="multipart/form-data" class="w-1/2" onsubmit="confirmSave(event)">
            @csrf
            @method("PUT")
            <div class="my-5">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" placeholder="Your Title..." value="{{ $news->title }}">
                @error("title")
                    <span class="text-sm text-red-800 italice">{{ $message }}</span>
                @enderror
            </div>
            <div class="my-5">
                <div class="flex items-end gap-5">  
                    <div class="flex-1">
                        <img src="{{ asset('storage/'. $news->image) }}" class="w-full" alt="Avatar">
                    </div>
                    <div class="flex-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="image">Image</label>
                        <input type="file" name="image" id="image" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="image_file">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="image_file">File must be image.</p>
                        @error("image")
                            <span class="text-sm text-red-800 italice">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
            </div>
            <div class="my-5">

                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your content</label>
                <textarea id="content" name="content" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="resize: none;" required="" placeholder="Your Content...">{{ $news->content }}</textarea>
                @error("content")
                    <span class="text-sm text-red-800 italice">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="py-2.5 px-10 text-sm font-medium text-white bg-[#5A88C6] transition rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
        </form>
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
