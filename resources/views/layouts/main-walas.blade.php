<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APLIKASI - SADM</title>
    @vite('resources/css/app.css')
</head>
<body class=" bg-[#f5f6fa]">
    <x-walas-navbar/>
    <div class=" flex">
        <x-walas-sidebar/>
        @yield('content')
    </div>
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
    @stack('scripts')
</body>
</html>