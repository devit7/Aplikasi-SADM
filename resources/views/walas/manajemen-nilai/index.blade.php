@extends('layouts.main-walas')

@section('content')
    <div class="w-full bg-gray-100 p-6">
        <h1 class="text-2xl font-bold mb-4">Nilai</h1>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <x-tables>
                <table class="w-full border-collapse border rounded-md text-sm " id="table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Mata Pelajaran</th>
                            <th class="border p-2">Semester</th>
                            <th class="border p-2">Status Nilai</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel_with_nilai as $mapel)
                            <tr class="text-center">
                                <td class="border p-2">{{ $mapel->nama_mapel }}</td>
                                <td class="border p-2">{{ $mapel->semester }}</td>
                                <td class="border p-2">{{ $status_nilai != 0 ? 'Dinilai' : 'Belum Dinilai' }}</td>
                                <td class="border p-2">
                                    <a href="{{ url("walas/manajemen-nilai/$mapel->id") }}">✏️</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-tables>

        </div>
    </div>
    </div>
@endsection
