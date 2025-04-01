@extends('layouts.main-walas')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Siswa</h1>
    <div class="bg-white p-4 shadow-md rounded-lg">
        <!-- <div class="flex justify-between items-center mb-4">
            <div>
                <label for="entries" class="text-gray-600">Show</label>
                <select id="entries" class="border rounded p-1 ml-2">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span class="text-gray-600 ml-2">entries per page</span>
            </div>
            <input type="text" placeholder="Search..." class="border rounded p-2" />
        </div> -->
        
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
                    @foreach ($kelas->siswa->unique('id') as $siswa) {{-- Hilangkan duplikat --}}
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
        
        <!-- <div class="flex justify-between items-center mt-4">
            <p class="text-gray-600">Showing 1 to 10 of 57 entries</p>
            <div class="flex space-x-2">
                <button class="p-2 border rounded">&laquo;</button>
                <button class="p-2 border rounded bg-gray-300">1</button>
                <button class="p-2 border rounded">2</button>
                <button class="p-2 border rounded">3</button>
                <button class="p-2 border rounded">4</button>
                <button class="p-2 border rounded">5</button>
                <button class="p-2 border rounded">6</button>
                <button class="p-2 border rounded">&raquo;</button>
            </div> -->
        </div>
    </div>
</div>
@endsection
