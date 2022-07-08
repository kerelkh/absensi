<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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
                timer: 1000
            })
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    @endif


    <div id="app" class="relative w-full h-screen overflow-hidden">
        <x-navbar></x-navbar>
        <div class="flex h-full">
            <x-sidebar></x-sidebar>
            <div class="w-full h-full overflow-y-auto">
                <div class="h-[1800px] bg-gray-50 overflow-y-auto w-full p-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


</body>
</html>
