<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APLIKASI - SADM</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-walas-navbar/>
    <div class=" flex flex-col min-h-screen bg-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Kelas List</h1>
            <div class="flex space-x-2">
                <select class="p-2 border rounded shadow-sm">
                    <option>Pilih Tahun Ajar</option>
                </select>
                <select class="p-2 border rounded shadow-sm">
                    <option>Pilih Semester</option>
                </select>
            </div>
        </div>

        <div class=" flex flex-wrap">
            <div class="grid grid-cols-2 gap-4">
            @forelse ($kelas as $kelas)
            <a href={{ route('List-Siswa',$kelas->id) }}>
                <button class=" bg-white w-[200px] h-[250px] rounded-lg shadow-md flex flex-col">
                    <div class="bg-red-300 h-[150px] p-6 shadow-md text-center flex justify-center items-center">
                        <h2 class="text-3xl font-bold text-white">{{ $kelas->nama_kelas }}</h2>
                    </div>
                    @foreach ($kelas->matapelajaran as $mp)
                    <div class=" flex flex-col text-start p-3">
                        <p class="text-black font-semibold mt-2">KELAS {{ $kelas->nama_kelas }}<br>{{ $mp->semester }}-{{ $kelas->tahun_ajaran }}</p>
                        <p class="text-gray-700 mt-2">{{ $kelas->siswa_count }} 👥</p>
                    </div>
                    @endforeach
                </button>
            </a>
            @empty
                <p>data tidak ada</p>
            @endforelse
                
            </div>
        </div>
    </div>
</body>
</html>