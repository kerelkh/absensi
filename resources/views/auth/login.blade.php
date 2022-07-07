<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                text: 'Gagal Login',
                showConfirmButton: false,
                timer: 1000
                })
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                text: 'Gagal Login',
                showConfirmButton: false,
                timer: 1000
                })
        </script>
    @endif

    <div class="w-full h-screen overflow-hidden relative flex justify-center items-center bg-cover bg-center bg-no-repeat" style="background-image: url({{ asset('images/bg1.jpg') }})">

        <form method="POST" class="bg-white p-5 shadow rounded-lg w-[320px] max-w-sm">
            @csrf
            <h1 class="mb-5 font-medium text-2xl">Sign In</h1>
            <div class="relative z-0 w-full mb-6 group">
                <input type="email" name="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                @error('email')
                    <span class="text-red-600 text-xs">* {{ $message }}</span>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                @error('password')
                    <span class="text-red-600 text-xs">* {{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
          </form>

    </div>

</body>
</html>
