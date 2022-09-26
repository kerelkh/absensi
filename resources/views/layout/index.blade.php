<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $datas['title'] }} - E-OFFICE</title>
    <link rel="shortcut icon" href="{{ asset('logos/Logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/fontawesome/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
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

        .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
        }
        .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
        }
        @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
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


    <div id="app" class="relative w-full h-screen  overflow-hidden bg-white">
        <div class="h-full flex">
            <div class="w-72 h-full relative" id="sidenav">
                <div class="w-full flex justify-center items-center py-2 mb-2">
                    <img src="{{ asset('logos/FullLogo_1.png') }}" alt="Logo" class="w-3/4">
                </div>
                <ul class="relative px-5 space-y-2">
                    @if($datas['menus'] ?? false)
                        <li class="font-medium text-gray-400">Menu</li>
                        @foreach($datas['menus'] as $menu)
                        <li class="relative">
                            <a class="flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-ellipsis whitespace-nowrap bg-gradient-to-r hover:text-blue-600 hover:font-medium hover:from-blue-100 hover:to-transparent hover:border-l-4 hover:border-blue-600 transition-all duration-150 {{ (Request::is($menu->name)) ? 'text-blue-600 font-medium from-blue-100 to-transparent border-l-4 border-blue-600' : '' }}" href="{{ $menu->url }}" data-mdb-ripple="true" data-mdb-ripple-color="primary">
                            {!! $menu->icon !!}
                            <span class="capitalize cursor-pointer">{{ $menu->name }}</span>
                            </a>
                        </li>
                        @endforeach

                    @endif
                </ul>
                {{-- <hr class="my-2">
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
                </div> --}}
            </div>
            <div class="w-full h-full overflow-y-auto">
                <div class="w-full py-2 px-5 bg-white leading-8 flex justify-between items-center sticky top-0 z-20">
                    <div class="flex gap-5">
                        <button id="toggleSidenav" class=" text-lg outline-none text-gray-400 hover:text-gray-900"><i class="fa-solid fa-bars"></i></button>
                    </div>
                    <div class="flex justify-center items-center gap-5">
                        <p>{{ auth()->user()->username }}</p>
                        <div id="toggle-nav-hidden" data-toggle='#nav-hidden' class="relative w-8 h-8 rounded-full bg-gray-200 hover:bg-blue-400 hover:text-gray-700 transition flex justify-center items-center cursor-pointer">
                            <i class="fa-solid fa-user"></i>
                            <div id="nav-hidden" class="shadow-lg absolute z-20 -bottom-14 p-2 bg-white rounded right-0 ">
                                <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center py-1 px-3 text-red-600 hover:bg-red-100 hover:font-medium"><i class="fa-solid fa-arrow-right-from-bracket w-3 h-3 mr-3" role="img"></i> Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="min-h-screen bg-blue-50 overflow-y-auto w-full px-10 py-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    @include('templates.loading')
    <script>
        $('document').ready(function() {
            $('#toggleSidenav').on('click', function() {
                $('#sidenav').fadeToggle();
            })
            setTimeout(()=> {
                $('#loading').fadeOut(300);
            },1000);
            $('#nav-hidden').hide();
        });

        $(document).bind("ajaxSend", function(){
            $("#loading").fadeIn(300);
        }).bind("ajaxComplete", function(){
            $("#loading").fadeOut(300);
        });

        $(document).on('click', '#toggle-nav-hidden', function(){
            let id = $(this).data('toggle');
            $(id).fadeToggle(100);
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
