@extends('layouts.main-staf')

@section('content')
<div class="w-full bg-gray-100 p-6">
    <div class="w-24 mx-1 border-collapse border rounded-md bg-red-600 hover:bg-red-500 p-2 text-center mb-2">
        <a href="{{route('staff.manajemen-nilai.index')}}" class="text-white hover:text-gray-100 font-medium text-base">
        < Kembali</a>
    </div>
    <h1 class="text-2xl font-bold mb-4">Nilai / {{ $data['mapel']['nama_mapel'] }}
    </h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-40 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" id="success-alert">
        <span class="block font-semibold sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 px-4 py-3" onclick="document.getElementById('success-alert').remove()">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert" id="error-alert">
        <span class="block sm:inline font-semibold">{{ session('error') }}</span>
        <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 px-4 py-3" onclick="document.getElementById('error-alert').remove()">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endif

    <div class="bg-white p-4 shadow-md rounded-lg">
        <x-tables>
            <table class="w-full border-collapse border rounded-md text-sm" id="table">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">UTS</th>
                        <th class="border p-2">UAS</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['siswa'] as $index => $siswa)
                    <tr class="text-center">
                        <td class="border p-2">{{ $index + 1 }}</td>
                        <td class="border p-2">{{ $siswa->nama }}</td>
                        <td class="border p-2">
                            @php
                            $nilai = collect($data['mapel']['nilai'])->first(function ($nilai) use ($siswa) {
                            return $nilai->detailKelas->siswa_id === $siswa->id;
                            });
                            @endphp
                            {{ $nilai ? $nilai->nilai_uts : '0' }}
                        </td>
                        <td class="border p-2">
                            {{ $nilai ? $nilai->nilai_uas : '0' }}
                        </td>
                        <td class="border p-2">
                            <div x-data="{ open: false }">
                                <button @click="open = true" class="text-blue-600 hover:text-blue-800">
                                    ✏️
                                </button>

                                <x-modal-nilai title="Input Nilai">
                                    <form action="{{ route('staff.manajemen-nilai.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_mapel" value="{{ $data['mapel']['id'] }}">
                                        <input type="hidden" name="id_kelas" value="{{ $data['mapel']['kelas']->id }}">
                                        <div class="mb-4">
                                            <label class="flex justify-start text-sm font-medium mb-1 opacity-50">Nama</label>
                                            <input type="text" name="nama" value="{{ $siswa->nama }}" readonly class="w-full border rounded px-3 py-2 bg-gray-100">
                                        </div>
                                        <div class="mb-4">
                                            <label class="flex justify-start text-sm font-medium mb-1 opacity-50">UTS</label>
                                            <input type="number" name="uts" value="{{ $nilai ? $nilai->nilai_uts : '' }}" class="w-full border rounded px-3 py-2" placeholder="ex: 80" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="flex justify-start text-sm font-medium mb-1 opacity-50">UAS</label>
                                            <input type="number" name="uas" value="{{ $nilai ? $nilai->nilai_uas : '' }}" class="w-full border rounded px-3 py-2" placeholder="ex: 80" required>
                                        </div>
                                        <div class="flex flex-col justify-center gap-2">
                                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                                                Confirm
                                            </button>
                                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </x-modal-nilai>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-tables>
    </div>
</div>
@endsection