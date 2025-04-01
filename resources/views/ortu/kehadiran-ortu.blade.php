@extends('layouts.nilai-kehadiran-ortu')
@section('nilai-kehadiran-content')
<div class="container mx-auto p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Total Absences -->
        <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
            <h2 class="text-xl font-semibold">Masuk</h2>
            <p class="text-3xl font-bold text-blue-500">12</p>
        </div>

        <!-- Excused Absences -->
        <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
            <h2 class="text-xl font-semibold">Izin</h2>
            <p class="text-3xl font-bold text-green-500">5</p>
        </div>

        <!-- Unexcused Absences -->
        <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
            <h2 class="text-xl font-semibold">Sakit</h2>
            <p class="text-3xl font-bold text-yellow-500">4</p>
        </div>

        <!-- Late Arrivals -->
        <div class="bg-white shadow-lg rounded-2xl p-6 text-center">
            <h2 class="text-xl font-semibold">Alpha</h2>
            <p class="text-3xl font-bold text-red-500">3</p>
        </div>
    </div>
    <table class="border-collapse border rounded-md text-sm max-w-8xl mx-4 mt-5 mb-5 w-[97%]">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absences as $absen)
                <tr class="text-center">
                    <td class="border p-2"> {{ $absen->tanggal }} </td>
                    <td class="border p-2"> {{ $absen->status }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection