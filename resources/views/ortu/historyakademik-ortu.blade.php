<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.2/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

  <div class="flex flex-col mb-8">
    <span class="text-lg font-bold">Selamat Datang Siti!</span>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-lg shadow-md p-4 flex items-center">
      <div class="flex flex-col items-start flex-1">
        <span class="text-gray-600 text-sm">Nilai Rata-Rata Seluruh</span>
        <span class="text-2xl font-bold mt-1">95.0</span>
      </div>
      <img src="/img/1.png" alt="Graduation Icon" class="w-12 h-12 rounded-lg">
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 flex items-center">
      <div class="flex flex-col items-start flex-1">
        <span class="text-gray-600 text-sm">Peringkat Nilai Dari Tahun Lalu</span>
        <span class="text-2xl font-bold mt-1">+10.0</span>
      </div>
      <img src="/img/2.png" alt="Medal Icon" class="w-12 h-12 rounded-lg">
    </div>
    <div class="bg-white rounded-lg shadow-md p-4 flex items-center">
      <div class="flex flex-col items-start flex-1">
        <span class="text-gray-600 text-sm">Persentase Kehadiran Tahun Ini</span>
        <span class="text-2xl font-bold mt-1">90%</span>
      </div>
      <img src="/img/3.png" alt="Attendance Icon" class="w-12 h-12 rounded-lg">
    </div>
  </div>

  <div class="mt-16"></div>
  <h2 class="text-2xl font-bold mb-8 text-center">Histori Akademik</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-xs w-full flex flex-col group">
      <div class="h-40 relative">
        <img
          src="logo.png"
          alt="Kelas 1B"
          class="w-full h-full object-cover rounded-t-lg transition-transform duration-300 group-hover:scale-105"
        >
      </div>
      <!-- <div class="p-4 flex-1 flex flex-col">
        <div class="mb-4">
          <span class="text-gray-600 text-sm text-center block">KELAS 1B 2023</span>
          <div class="border-b border-gray-200 mt-2"></div>
        </div>
        <div class="space-y-2 mb-4">
          <p class="text-sm flex justify-between">
            <span>Peringkat</span>
            <span class="font-semibold">5 dari 30</span>
          </p>
          <p class="text-sm flex justify-between">
            <span>Kehadiran</span>
            <span class="font-semibold">80%</span>
          </p>
        </div>
        <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded mt-auto focus:outline-none hover:bg-blue-600 transition duration-300">
          Lihat Detail
        </button>
      </div> -->
      <div class="p-4 flex-1 flex flex-col">
  <div class="mb-4">
    <span class="text-gray-600 text-sm text-center block">KELAS 1B 2023</span>
    <div class="border-b border-gray-200 mt-2"></div>
  </div>
  <div class="space-y-2 mb-4">
    <p class="text-sm flex justify-between">
      <span>Peringkat</span>
      <span class="font-semibold">5 dari 30</span>
    </p>
    <p class="text-sm flex justify-between">
      <span>Kehadiran</span>
      <span class="font-semibold">80%</span>
    </p>
  </div>
  <button class="bg-blue-500 text-white text-xs font-semibold py-1 px-3 rounded focus:outline-none hover:bg-blue-600 transition duration-300 self-end">
    Lihat Detail
  </button>
</div>

    </div>
  </div>
</body>
</html>
