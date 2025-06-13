<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APLIKASI - SADM</title>
    @vite('resources/css/app.css')
    @stack('styles')
    <script>
        (function(m, a, z, e) {
            var s, t;
            try {
                t = m.sessionStorage.getItem('maze-us');
            } catch (err) {}

            if (!t) {
                t = new Date().getTime();
                try {
                    m.sessionStorage.setItem('maze-us', t);
                } catch (err) {}
            }

            s = a.createElement('script');
            s.src = z + '?apiKey=' + e;
            s.async = true;
            a.getElementsByTagName('head')[0].appendChild(s);
            m.mazeUniversalSnippetApiKey = e;
        })(window, document, 'https://snippet.maze.co/maze-universal-loader.js', 'db08c225-5ce2-4bf7-9f44-8c88c999648d');
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
</head>

<body class=" bg-[#f5f6fa]">
    <x-walas-navbar />
    <div class=" flex">
        <!-- Check if we are on a page with a kelas object -->
        @if (isset($kelas) && isset($kelas->id))
            <x-alternative-walas-sidebar :kelasId="$kelas->id" />
        @else
            <x-walas-sidebar />
        @endif

        @yield('content')
    </div>
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
