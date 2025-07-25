<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GEN-SMART - SADM</title>
    @vite('resources/css/app.css')
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .light-theme {
            background-color: #f9fafb;
            color: #1f2937;
        }

        .light-theme .header-section {
            border-bottom: 1px solid #e5e7eb;
        }

        .breadcrumb-item a {
            color: #3b82f6;
        }

        .breadcrumb-item:last-child {
            color: #6b7280;
        }
    </style>
</head>

<body class="bg-white">
    <x-staf-navbar />
    <div class="flex">
        @if((isset($kelas) && isset($kelas->id)) ||
        (isset($staff_acces) && (
        isset($staff_acces->akses_nilai) ||
        isset($staff_acces->akses_absen) ||
        isset($staff_acces->akses_alquran_learning) ||
        isset($staff_acces->akses_extrakurikuler) ||
        isset($staff_acces->akses_worship_character)
        )))

        @php
        $kelasId = isset($kelas->id) ? $kelas->id :
        (isset($staff_acces->kelas_id) ? $staff_acces->kelas_id :
        (isset($kelas) ? $kelas->id : null));

        // Normalize variable names for consistency
        $staffAksesNilai = $staff_acces->akses_nilai ?? 0;
        $staffAksesAbsen = $staff_acces->akses_absen ?? 0;
        $staffAksesAlQuran = $staff_acces->akses_alquran_learning ?? 0;
        $staffAksesExtra = $staff_acces->akses_extrakurikuler ?? 0;
        $staffAksesWorship = $staff_acces->akses_worship_character ?? 0;

        @endphp
        <x-alternative-staf-sidebar
            :kelasId="$kelasId"
            :staffAksesNilai="$staffAksesNilai"
            :staffAksesAbsen="$staffAksesAbsen"
            :staffAksesAlQuran="$staffAksesAlQuran"
            :staffAksesExtra="$staffAksesExtra"
            :staffAksesWorship="$staffAksesWorship" />
        @else
        <x-staf-sidebar />
        @endif

        @yield('content')
    </div>
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
    @stack('scripts')
</body>

</html>