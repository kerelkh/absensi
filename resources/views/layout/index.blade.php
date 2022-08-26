<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-OFFICE</title>
    <link rel="shortcut icon" href="{{ asset('logos/Logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
</head>
<body>
    {{-- sweetalert --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif


    <div id="app" class="relative w-full h-screen  overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url({{ asset('images/background-layout.png') }})">
        <div class="flex h-full">
            <div class="w-60 h-full relative" id="sidenav">
                {{-- Profile Sidenav --}}
                <div class="pt-4 pb-2 px-6 mb-5">
                    <div class="flex items-center">
                      <div class="shrink-0">
                        <img src="{{ asset('images/user-picture.jpg') }}" class="rounded-full w-10" alt="Avatar">
                      </div>
                      <div class="grow ml-3">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                      </div>
                    </div>
                </div>
                <ul class="relative px-1">
                    <p class="text-sm font-medium py-4 px-6 h-12 overflow-hidden text-gray-700">Menu</p>
                    @if(auth()->user()->role->id == 1)
                        <li class="relative">
                            <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" href="/opd" data-mdb-ripple="true" data-mdb-ripple-color="primary">
                            <i class="fa-solid fa-chart-line w-3 h-3 mr-3" role="img"></i>
                            <span>Data OPD</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->role->id == 2)
                        <li class="relative">
                            <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" href="/admin/kepegawaian" data-mdb-ripple="true" data-mdb-ripple-color="primary">
                            <i class="fa-solid fa-chart-line w-3 h-3 mr-3" role="img"></i>
                            <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="relative">
                            <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" href="/admin/kepegawaian/users" data-mdb-ripple="true" data-mdb-ripple-color="primary">
                            <i class="fa-solid fa-users w-3 h-3 mr-3" role="img"></i>
                            <span>Users</span>
                            </a>
                        </li>
                        <li class="relative">
                            <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" href="/admin/kepegawaian/admins" data-mdb-ripple="true" data-mdb-ripple-color="primary">
                            <i class="fa-solid fa-users w-3 h-3 mr-3" role="img"></i>
                            <span>Admins</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <hr class="my-2">
                <ul class="relative px-1">
                    <p class="text-sm font-medium py-4 px-6 h-12 overflow-hidden text-gray-700">Web</p>
                    @if(auth()->user()->role->id == 1)
                    <li class="relative">
                        <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" href="/" data-mdb-ripple="true" data-mdb-ripple-color="primary">
                        <i class="fa-solid fa-gears w-3 h-3 mr-3" role="img"></i>
                        <span>Setting</span>
                        </a>
                    </li>

                    @endif
                    <li class="relative">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-red-700 text-ellipsis whitespace-nowrap rounded hover:bg-blue-50 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="primary">
                                <i class="fa-solid fa-arrow-right-from-bracket w-3 h-3 mr-3" role="img"></i>
                                <span>Logout</span>
                                </button>
                        </form>
                    </li>
                </ul>
                <div class="text-center bottom-0 absolute w-full">
                  <hr class="m-0">
                  <p class="py-2 text-xs text-gray-700 italic ">&copy; Copyright 2022 E-Office Kepahiang</p>
                </div>
            </div>
            <div class="w-full h-full overflow-y-auto">
                <div class="min-h-screen bg-white overflow-y-auto w-full px-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


</body>
</html>
