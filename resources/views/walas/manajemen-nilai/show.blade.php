@extends('layouts.main-walas')

@section('content')
    <div class="w-full bg-gray-100 p-6">
        <h1 class="text-2xl font-bold mb-4">Nilai / {{ $data['mapel']['nama_mapel'] }}</h1>
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <div class="bg-white p-4 shadow-md rounded-lg">
            <x-tables>
                <table class="w-full border-collapse border rounded-md text-sm" id="table">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">UTS</th>
                            <th class="border p-2">UAS</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['siswa'] as $siswa)
                            <tr class="text-center">
                                <td class="border p-2">{{ $siswa->nama }}</td>
                                <td class="border p-2">
                                    @php
                                        $nilai = collect($data['mapel']['nilai'])->first(function ($nilai) use (
                                            $siswa,
                                        ) {
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
                                            <form action="{{ url('walas/manajemen-nilai') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_mapel" value="{{ $data['mapel']['id'] }}">
                                                <input type="hidden" name="id_kelas"
                                                    value="{{ $data['mapel']['kelas']->id }}">
                                                <div class="mb-4">
                                                    <label
                                                        class="flex justify-start text-sm font-medium mb-1 opacity-50">Nama</label>
                                                    <input type="text" name="nama" value="{{ $siswa->nama }}"
                                                        readonly class="w-full border rounded px-3 py-2 bg-gray-100">
                                                </div>
                                                <div class="mb-4">
                                                    <label
                                                        class="flex justify-start text-sm font-medium mb-1 opacity-50">UTS</label>
                                                    <input type="number" name="uts"
                                                        value="{{ $nilai ? $nilai->nilai_uts : '' }}"
                                                        class="w-full border rounded px-3 py-2" placeholder="ex: 80"
                                                        required>
                                                </div>
                                                <div class="mb-4">
                                                    <label
                                                        class="flex justify-start text-sm font-medium mb-1 opacity-50">UAS</label>
                                                    <input type="number" name="uas"
                                                        value="{{ $nilai ? $nilai->nilai_uas : '' }}"
                                                        class="w-full border rounded px-3 py-2" placeholder="ex: 80"
                                                        required>
                                                </div>
                                                <div class="flex flex-col justify-center gap-2">
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                                                        Confirm
                                                    </button>
                                                    <button type="button" @click="open = false"
                                                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
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
