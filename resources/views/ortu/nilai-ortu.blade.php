@extends('layouts.nilai-kehadiran-ortu')
@section('nilai-kehadiran-content')
<table class="border-collapse border rounded-md text-sm max-w-8xl mx-4 mt-5 mb-5 w-[97%]">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Mata Pelajaran</th>
            <th class="border p-2">Nilai UTS</th>
            <th class="border p-2">Nilai UAS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($matapelajaran as $mapel)
            @php
                // Find the nilai related to this mata pelajaran
                $nilaiItem = $nilai->firstWhere('matapelajaran_id', $mapel->id);
            @endphp
            <tr class="text-center">
                <td class="border p-2">{{ $mapel->nama_mapel }}</td>
                <td class="border p-2">{{ $nilaiItem->nilai_uts ?? 'N/A' }}</td>
                <td class="border p-2">{{ $nilaiItem->nilai_uas ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="bg-white shadow-lg rounded-xl text-center mr-11 p-1 w-full">
    <div class="text-center flex flex-row justify-between items-center px-6">
        <div class="text-gray-600">Ranking Keseluruhan</div>
        <div class="text-2xl pr-40 font-light ">{{ $studentRanking }}</div>
    </div>

</div>
@endsection
