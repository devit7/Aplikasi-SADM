<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ortu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard Ortu</h1>
            <form action="{{ route('logoutortu') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Konten Dashboard -->
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Informasi Siswa</h2>

            <!-- Cek session siswa -->
            @if (Session::has('siswa'))
                <div class="space-y-4">
                    <div>
                        <label class="font-semibold">Nama Siswa:</label>
                        <p>{{ Session::get('siswa')->nama }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">NISN:</label>
                        <p>{{ Session::get('siswa')->nisn }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">NIS:</label>
                        <p>{{ Session::get('siswa')->nis }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Tanggal Lahir:</label>
                        <p>{{ Session::get('siswa')->tanggal_lahir }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Jenis Kelamin:</label>
                        <p>{{ Session::get('siswa')->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>

                <hr class="my-6">

                <h2 class="text-xl font-bold mb-4">Informasi Orang Tua</h2>
                <div class="space-y-4">
                    <div>
                        <label class="font-semibold">Nama Ayah:</label>
                        <p>{{ Session::get('siswa')->nama_bapak }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Pekerjaan Ayah:</label>
                        <p>{{ Session::get('siswa')->pekerjaan_bapak }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">No. HP Ayah:</label>
                        <p>{{ Session::get('siswa')->no_hp_bapak }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Nama Ibu:</label>
                        <p>{{ Session::get('siswa')->nama_ibu }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Pekerjaan Ibu:</label>
                        <p>{{ Session::get('siswa')->pekerjaan_ibu }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">No. HP Ibu:</label>
                        <p>{{ Session::get('siswa')->no_hp_ibu }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>