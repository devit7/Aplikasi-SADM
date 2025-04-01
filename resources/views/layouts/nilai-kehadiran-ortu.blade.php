@extends('layouts.main-ortu')
@section('content')
    <div class="w-full">
        <div class="flex w-full border border-blue-500 h-9">
            <a href="/ortu/nilai-kehadiran" id="nilai" class="{{ request()->is('ortu/nilai-kehadiran') ? 'bg-blue-500 text-white' : 'text-blue-500 bg-white' }} flex-1 text-center py-1 cursor-pointer">Nilai</a>
            <a href="/ortu/nilai-kehadiran/kehadiran" id="kehadiran" class="{{ request()->is('ortu/nilai-kehadiran/kehadiran') ? 'bg-blue-500 text-white' : 'text-blue-500 bg-white' }} flex-1 text-center py-1 cursor-pointer">Kehadiran</a>
        </div>
    </div>
    <div class="m-5">
        <h1 class="text-3xl font-poppins"> {{ strtoupper($detailKelas->kelas->nama_kelas . ' semester ' . $semester) }} </h1>
        <h2 class="text-2xl font-poppins"> {{ strtoupper($siswa->nama) }} </h2>
    </div>
    <div>
        @yield('nilai-kehadiran-content')
    </div>

@endsection
