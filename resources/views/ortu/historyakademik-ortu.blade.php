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
    <x-ortu-navbar />

    <div class="bg-gray-100 p-8">
        <div class="mb-8">
            <span class="text-lg font-bold">Selamat Datang {{ $ortu->nama ?? 'Orang Tua' }}!</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4 flex items-center">
                <div class="flex flex-col items-start flex-1">
                    <span class="text-gray-600 text-sm">Nilai Rata-Rata Seluruh</span>
                    <span class="text-2xl font-bold mt-1">{{ $rataRata ?? '-' }}</span>
                </div>
                <img src="/img/1.png" alt="Graduation Icon" class="w-12 h-12 rounded-lg">
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 flex items-center">
                <div class="flex flex-col items-start flex-1">
                    <span class="text-gray-600 text-sm">Peringkat Nilai Dari Tahun Lalu</span>
                    <span class="text-2xl font-bold mt-1">{{ $peringkat ?? '-' }}</span>
                </div>
                <img src="/img/2.png" alt="Medal Icon" class="w-12 h-12 rounded-lg">
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 flex items-center">
                <div class="flex flex-col items-start flex-1">
                    <span class="text-gray-600 text-sm">Persentase Kehadiran Tahun Ini</span>
                    <span class="text-2xl font-bold mt-1">{{ $kehadiran ?? '-' }}</span>
                </div>
                <img src="/img/3.png" alt="Attendance Icon" class="w-12 h-12 rounded-lg">
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8 text-center">Histori Akademik</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($histories as $history)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-xs w-full flex flex-col group">
                        <div class="h-40 relative bg-blue-500 flex items-center justify-center rounded-t-lg">
                            <h3 class="text-white text-2xl font-bold">{{ $history->kelas }}</h3>
                        </div>
                        <div class="text-xl  text-center mb-2">
                        {{ strtoupper(session('siswa')->detailKelas->first()?->kelas->nama_kelas ?? '-') }}
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="mb-4">
                                <span class="text-gray-600 text-sm text-center block">{{ $history->kelas }} {{ $history->tahun }}</span>
                                <div class="border-b border-gray-200 mt-2"></div>
                            </div>

                            <div class="space-y-2 mb-4">
                                <p class="text-sm flex justify-between">
                                    <span>Peringkat</span>
                                    <span class="font-semibold">{{ $history->peringkat }} dari {{ $history->total_siswa }}</span>
                                </p>
                                <p class="text-sm flex justify-between">
                                    <span>Kehadiran</span>
                                    <span class="font-semibold">{{ $history->kehadiran }}%</span>
                                </p>
                            </div>

                            <a href="{{ route('ortu.nilai') }}"
                                class="bg-blue-500 text-white text-xs font-semibold py-1 px-3 rounded focus:outline-none hover:bg-blue-600 transition duration-300 self-end">
                                Lihat Detail
                            </a>

                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Tidak ada data histori akademik.</p>
                @endforelse
            </div>
        </div>
    </div>
</body>

</html>
