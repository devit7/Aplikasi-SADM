@extends('layouts.main-staf')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Siswa</h1>
    <div class="bg-white p-4 shadow-md rounded-lg">
        <x-tables>
            <table class="w-full border-collapse border rounded-md text-sm " id="table">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">NISN</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">NIS</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Nama</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Nama Wali</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Nomer Wali</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Jenis Kelamin</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Tempat Lahir</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Tgl Lahir</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">Alamat</th>
                        <th class="border p-3 text-left font-medium text-gray-700 whitespace-wrap">TA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas->siswa->unique('id') as $siswa)
                    <tr class="text-center">
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->nisn }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->nis }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->nama }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->nama_bapak }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->no_hp_bapak }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->jenis_kelamin }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->tempat_lahir }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->tanggal_lahir }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $siswa->alamat }}</td>
                        <td class="border p-3 whitespace-wrap font-medium text-base">{{ $kelas->tahun_ajaran }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-tables>
    </div>
</div>
</div>
@endsection