@extends('layouts.main-staf')

@section('content')
<div class="w-full bg-gray-100 p-6">
    <div class="w-24 mx-1 border-collapse border rounded-md bg-red-600 hover:bg-red-500 p-2 text-center mb-2">
        <a href="{{route('staff.dashboard')}}" class="text-white hover:text-gray-100 font-medium text-base">
            < Kembali</a>
    </div>
    <h1 class="text-2xl font-bold mb-4">Nilai</h1>
    <div class="bg-white p-4 shadow-md rounded-lg">
        <x-tables>
            <table class="w-full border-collapse border rounded-md text-sm" id="table">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">No</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Mata Pelajaran</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Semester</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Status Nilai</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapel_with_nilai as $index => $mapel)
                    <tr class="text-center">
                        <td class="border p-3 whitespace-nowrap font-medium text-base">{{ $index + 1 }}</td>
                        <td class="border p-3 whitespace-nowrap font-medium text-base">{{ $mapel->nama_mapel }}</td>
                        <td class="border p-3 whitespace-nowrap font-medium text-base">{{ $mapel->semester }}</td>
                        <td class="border p-3 whitespace-nowrap font-medium text-base">{{ $mapel->status_nilai }}</td>
                        <td class="border p-3 whitespace-nowrap font-medium text-base">
                            <a href="{{ route('staff.manajemen-nilai.show', $mapel->id) }}">
                                <div class="inline-block p-2 hover:bg-gray-200 rounded-md transition-all duration-300 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-7 text-orange-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </div>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-tables>
    </div>
</div>
@endsection