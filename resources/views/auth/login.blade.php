<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - E-OFFICE</title>
    <link rel="shortcut icon" href="{{ asset('logos/Logo.png') }}" type="image/png">
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
                text: 'Login failed, Username/Password incorrect.',
                showConfirmButton: false,
                timer: 1000
                })
        </script>
    @endif

    <div class="w-full h-screen overflow-hidden flex bg-cover bg-center bg-no-repeat" style="background-image: url({{ asset('images/background-login.svg') }})">

        <div class="flex-1 h-full grid place-items-center py-10 px-5 relative">
            <div>
                <div id="logo" class="w-fit">
                    <img src="{{ asset('logos/FullLogo_1.png') }}" alt="Logo" class="h-10">
                </div>
                <div id="title-login" class="my-10">
                    <h2 class="font-semibold text-2xl">Login</h2>
                    <p>To access data, please sign-in using registered account.</p>
                </div>
                <div id="login-form" class="my-10">
                    <form method="POST" class=" w-full max-w-sm">
                        @csrf
                        <div class="relative z-0 w-full mb-10 group">
                            <input type="text" name="username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required autocomplete="off" autofocus/>
                            <label for="username" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">username</label>
                            @error('username')
                                <span class="text-red-600 text-xs">* {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-10 group">
                            <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                            @error('password')
                                <span class="text-red-600 text-xs">* {{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                      </form>
                </div>
                <div id="footer" class="mb-5">
                    <span class="text-sm font-semibold">Forgot username/password? Contact Admin.</span>
                </div>
                <div id="copyright" class="my-10 absolute bottom-0">
                    <span class="text-sm text-gray-500 italic">&copy; 2022 Copyright E-Office Kepahing</span></span>
                </div>
            </div>
        </div>
        <div class="hidden md:flex-1 h-full md:flex bg-cover bg-center bg-no-repeat" style="background-image: url({{ asset('images/background-image.svg') }})"></div>

    </div>

</body>
</html>
