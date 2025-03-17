@extends('layouts.main-ortu')
@section('content')
    <div class="w-full">
        <div class="flex w-full border border-blue-500 h-9">
            <a href="#" id="nilai" class="bg-blue-500 text-white flex-1 text-center py-1 cursor-pointer">Nilai</a>
            <a href="#" id="kehadiran" class="text-blue-500 bg-white flex-1 text-center py-1 cursor-pointer">Kehadiran</a>
        </div>
    </div>
    <div>
        <h1 class="text-3xl font-poppins">KELAS 3 SEMESTER GANJIL</h1>
        <h2 class="text-2xl font-poppins">DINDA SULISTYA</h2>
    </div>
    <table class="w-full border-collapse border rounded-md text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Mata Pelajaran</th>
                <th class="border p-2">Nilai</th>

            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td class="border p-2">Matematika</td>
                <td class="border p-2">90</td>
            </tr>
            <tr class="text-center">
                <td class="border p-2">Bahasa Indonesia</td>
                <td class="border p-2">95</td>
            </tr>
            <tr class="text-center">
                <td class="border p-2">Bahasa Inggris</td>
                <td class="border p-2">80</td>
            </tr>

        </tbody>
    </table>
@endsection
