@extends('layouts.main-walas')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Siswa</h1>
    <div class="bg-white p-4 shadow-md rounded-lg">
        <x-tables>
            <table class="w-full border-collapse border rounded-md text-sm " id="table" >
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">NISN</th>
                        <th class="border p-2">NIS</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Nama Wali</th>
                        <th class="border p-2">Nomer Wali</th>
                        <th class="border p-2">Jenis Kelamin</th>
                        <th class="border p-2">Tempat Lahir</th>
                        <th class="border p-2">Tgl Lahir</th>
                        <th class="border p-2">Alamat</th>
                        <th class="border p-2">TA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas->siswa->unique('id') as $siswa)
                        <tr class="text-center">
                            <td class="border p-2">{{ $siswa->nisn }}</td>
                            <td class="border p-2">{{ $siswa->nis }}</td>
                            <td class="border p-2">{{ $siswa->nama }}</td>
                            <td class="border p-2">{{ $siswa->nama_bapak }}</td>
                            <td class="border p-2">{{ $siswa->no_hp_bapak }}</td>
                            <td class="border p-2">{{ $siswa->jenis_kelamin }}</td>
                            <td class="border p-2">{{ $siswa->tempat_lahir }}</td>
                            <td class="border p-2">{{ $siswa->tanggal_lahir }}</td>
                            <td class="border p-2">{{ $siswa->alamat }}</td>
                            <td class="border p-2">{{ $kelas->tahun_ajaran }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-tables>
        </div>
    </div>
</div>
@endsection
