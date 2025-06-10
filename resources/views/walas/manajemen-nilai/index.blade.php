@extends('layouts.main-walas')

@section('content')
    <div class="w-full bg-gray-100 p-6">
        {{-- <div class="w-24 mx-1 border-collapse border rounded-md bg-red-600 hover:bg-red-500 p-2 text-center mb-2">
            <a href="{{ route('walas.index') }}"
                class="text-white flex items-center gap-1 justify-center hover:text-gray-100 font-medium text-base">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Kembali
            </a>
        </div> --}}
        <h1 class="text-2xl font-bold mb-4">Nilai</h1>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <x-tables>
                <table class="w-full border-collapse border rounded-md text-sm" id="table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Mata Pelajaran</th>
                            <th class="border p-2">Semester</th>
                            <th class="border p-2">Status Nilai</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel_with_nilai as $index => $mapel)
                            <tr class="text-center">
                                <td class="border p-2">{{ $index + 1 }}</td>
                                <td class="border p-2">{{ $mapel->nama_mapel }}</td>
                                <td class="border p-2">{{ $mapel->semester }}</td>
                                <td class="border p-2">{{ $mapel->status_nilai }}</td>
                                <td class="border p-2">
                                    <a href="{{ route('walas.manajemen-nilai.show', $mapel->id) }}">✏️</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-tables>
        </div>
    </div>
@endsection
