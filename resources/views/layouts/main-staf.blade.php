<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APLIKASI - SADM</title>
    @vite('resources/css/app.css')
    @stack('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
</head>

<body class=" bg-[#f5f6fa]">
    <x-staf-navbar />
    <div class=" flex">
    <!-- Check if we are on a page with a kelas object -->
    @if((isset($kelas) && isset($kelas->id)) || (isset($staff_acces) && (isset($staff_acces->akses_nilai) || isset($staff_acces->akses_absen))))
        @php
            $kelasId = isset($kelas->id) ? $kelas->id : 
                    (isset($staff_acces->kelas_id) ? $staff_acces->kelas_id : 
                    (isset($kelas) ? $kelas->id : null));
        @endphp
        <x-alternative-staf-sidebar :kelasId="$kelasId" :staffAksesNilai="$staff_acces->akses_nilai ?? 0" :staffAksesAbsen="$staff_acces->akses_absen ?? 0"/>
    @else
        <x-staf-sidebar />
    @endif

        @yield('content')
    </div>
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
