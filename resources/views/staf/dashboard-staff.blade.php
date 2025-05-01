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
    <x-staf-navbar />
    <div class="flex flex-col min-h-screen bg-gray-100 p-6">
        <div class="flex flex-col items-start mb-6">
            <h1 class="text-2xl font-bold">Kelas List</h1>
            <div class=" flex">
                <form method="GET" action="{{ route('staff.dashboard') }}" class="flex space-x-2">
                    @csrf
                    <select name="semester" class="p-2 border rounded shadow-sm" onchange="this.form.submit()">
                        <option value="">Pilih Semester</option>
                        @foreach ($semester as $sem)
                            <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>
                                {{ $sem }}</option>
                        @endforeach
                    </select>
                </form>
                <form method="GET" action="{{ route('staff.dashboard') }}" class="flex space-x-2">
                    @csrf
                    <select name="tahun_ajaran" class="p-2 border rounded shadow-sm" onchange="this.form.submit()">
                        <option value="">Pilih Tahun Ajar</option>
                        @foreach ($tahun_ajaran as $tahun)
                            <option value="{{ $tahun }}"
                                {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="flex flex-wrap">
            <div class="grid grid-cols-2 gap-4">
                @forelse ($kelas as $kls)
                    @if (
                        (request('tahun_ajaran') == '' || $kls->tahun_ajaran == request('tahun_ajaran')) &&
                            (request('semester') == '' || $kls->matapelajaran->contains('semester', request('semester'))))
                        <a href={{ route('staff.list-siswa', $kls->id) }}>
                            <button class="bg-white w-[200px] h-[250px] rounded-lg shadow-md flex flex-col">
                                <div
                                    class="bg-red-300 h-[150px] p-6 shadow-md text-center flex justify-center items-center w-full">
                                    <h2 class="text-3xl font-bold text-white">{{ $kls->nama_kelas }}</h2>
                                </div>
                                <div class="flex flex-col text-start p-3">
                                    <p class="text-black font-semibold mt-2">KELAS
                                        {{ $kls->nama_kelas }}<br>
                                        @if($kls->matapelajaran->count() > 0 && $kls->matapelajaran->first())
                                            {{ $kls->matapelajaran->first()->semester }}-{{ $kls->tahun_ajaran }}
                                        @else
                                            {{ $kls->tahun_ajaran }}
                                        @endif
                                    </p>
                                    <p class="text-gray-700 mt-2">{{ $kls->siswa_count }} 👥</p>
                                </div>

                            </button>
                        </a>
                    @endif
                @empty
                    <p>Data tidak ada</p>
                @endforelse
            </div>
        </div>
    </div>
</body>

</html>
