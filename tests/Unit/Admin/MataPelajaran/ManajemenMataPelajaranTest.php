<?php

use App\Models\Matapelajaran;
use App\Models\Kelas;
use Livewire\Livewire;
use App\Filament\Resources\MatapelajaranResource\Pages\CreateMatapelajaran;
use App\Filament\Resources\MatapelajaranResource\Pages\EditMatapelajaran;
use App\Filament\Resources\MatapelajaranResource\Pages\ListMatapelajarans;
use Carbon\Carbon;

test('Validasi dapat menambahkan data mata pelajaran', function () {

    $dataMatapelajaran = [
        'nama_mapel' => 'Matematika',
        'kode_mapel' => 'MTK001',
        'kelas_id' => '10',
        'semester' => 'ganjil',
        'kkm' => '75',
    ];

    // Act & Assert
    Livewire::test(CreateMatapelajaran::class)
        ->fillForm($dataMatapelajaran)
        ->call('create')
        ->assertHasNoFormErrors();

    // Verifikasi data berhasil disimpan ke database
    $this->assertDatabaseHas('matapelajaran', [
        'nama_mapel' => $dataMatapelajaran['nama_mapel'],
        'kode_mapel' => $dataMatapelajaran['kode_mapel'],
    ]);
});

test('Admin tidak dapat menambahkan mata pelajaran dengan kode yang sudah ada', function () {
    // Arrange

    Matapelajaran::create([
        'nama_mapel' => 'Fisika',
        'kode_mapel' => 'FIS001',
        'kelas_id' => '10',
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Act & Assert
    $this->assertDatabaseHas('matapelajaran', [
        'kode_mapel' => 'FIS001',
    ]);

    // Coba buat mata pelajaran dengan kode yang sama
    Livewire::test(CreateMatapelajaran::class)
        ->fillForm([
            'nama_mapel' => 'Fisika Lanjutan',
            'kode_mapel' => 'FIS001',
            'kelas_id' => '10',
            'semester' => 'genap',
            'kkm' => '80',
        ])
        ->call('create')
        ->assertHasFormErrors(['kode_mapel' => 'unique']);
});

test('Validasi data mata pelajaran tidak bisa di edit di Filament dengan data kosong', function () {
    // Buat mata pelajaran
    $matapelajaran = Matapelajaran::create([
        'nama_mapel' => 'Bahasa Inggris',
        'kode_mapel' => 'BIG001',
        'kelas_id' => '10',
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Data kosong untuk validasi
    $dataMatapelajaranKosong = [
        'nama_mapel' => '',
        'kode_mapel' => '',
        'kelas_id' => '',
        'semester' => '',
        'kkm' => '',
    ];

    // Act & Assert
    Livewire::test(EditMatapelajaran::class, ['record' => $matapelajaran->id])
        ->fillForm($dataMatapelajaranKosong)
        ->call('save')
        ->assertHasFormErrors([
            'nama_mapel' => 'required',
            'kode_mapel' => 'required',
            'kelas_id' => 'required',
            'semester' => 'required',
            'kkm' => 'required',
        ]);
});
