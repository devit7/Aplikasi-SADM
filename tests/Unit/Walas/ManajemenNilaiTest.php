<?php

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\DetailKelas;
use App\Models\Matapelajaran;
use App\Models\Nilai;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Walas\ManajemenNilai;
use Filament\Forms\Components\Livewire;

uses(RefreshDatabase::class);

// // ./vendor/bin/pest .\tests\Unit\Walas\ManajemenNilaiTest.php
test('Input nilai valid berhasil disimpan', function () {
    $nilai = [
        'nama' => 'Mamat',
        'id_mapel' => 1,
        'id_kelas' => 1,
        'uts' => 80,
        'uas' => 85,
    ];
    // Act
    $response = $this->post('/walas/manajemen-nilai', $nilai);

    // Assert
    $response->assertSessionHasNoErrors(['nama' => 'Mamat',
        'id_mapel',
        'id_kelas',
        'uts',
        'uas',]);
});

test('Input nilai valid Login disimpan', function () {
    $nilai = [
        'nama' => 'Mamat',
        'id_mapel' => 1,
        'id_kelas' => 1,
        'uts' => 120,
        'uas' => 85,
    ];
    // Act
    $response = $this->post('/walas/manajemen-nilai', $nilai);

    // Assert
    $response->assertSessionHasErrors(['nama' => 'Mamat',
        'id_mapel',
        'id_kelas',
        'uts',
        'uas',]);
});