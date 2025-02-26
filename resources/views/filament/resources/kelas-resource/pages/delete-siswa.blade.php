<x-filament-panels::page>
    <div>
        <h2 class="text-2xl font-bold">Kelas {{ $nama_kelas }}</h2>
        <p class="text-gray-600 ">Silakan pilih siswa untuk dihapus dari kelas.</p>
        <br>
        <br>
        {{ $this->table }}
    </div>
</x-filament-panels::page>

