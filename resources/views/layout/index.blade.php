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
</head>
<body>
    <div id="app" class="relative w-full h-screen overflow-hidden">
        <x-navbar></x-navbar>
        <div class="flex h-full">
            <x-sidebar></x-sidebar>
            <div class="w-full h-full overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>


</body>
</html>
