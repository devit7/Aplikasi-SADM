@extends('layouts.main-ortu')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto my-10 bg-white p-8 rounded-xl shadow-md">
        <div class="flex flex-col items-center">
            <img class="w-32 h-32 rounded-full object-cover" src="https://via.placeholder.com/150" alt="Profile Picture">
            <h2 class="text-xl font-semibold mt-4">Student Profile</h2>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div>
                <label class="block text-gray-600">Nama</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">NISN</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">NIS</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Jenis Kelamin</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Tanggal Lahir</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Alamat</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Nama Bapak</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Nama Ibu</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Pekerjaan Bapak</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Pekerjaan Ibu</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Nomer Bapak</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
            <div>
                <label class="block text-gray-600">Nomer Ibu</label>
                <input type="text" class="w-full px-4 py-2 mt-1 border rounded-md" readonly placeholder="Your First Name">
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
