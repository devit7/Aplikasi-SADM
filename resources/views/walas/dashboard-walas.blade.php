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
                <div class="bg-red-300 w-[200px] p-6 rounded-lg shadow-md text-center">
                    <h2 class="text-3xl font-bold text-white">3A</h2>
                    <p class="text-black font-semibold mt-2">KELAS 3A<br>S2-2025</p>
                    <p class="text-gray-700 mt-2">27 👥</p>
                </div>
                <div class="bg-green-300 w-[200px] p-6 rounded-lg shadow-md text-center">
                    <h2 class="text-3xl font-bold text-white">3B</h2>
                    <p class="text-black font-semibold mt-2">KELAS 3B<br>S2-2025</p>
                    <p class="text-gray-700 mt-2">27 👥</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>