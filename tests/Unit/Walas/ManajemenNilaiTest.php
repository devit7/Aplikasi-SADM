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

// // ./vendor/bin/pest .\tests\Unit\Walas\ManajemenNilaiTest.php
test('Input nilai valid berhasil disimpan', function () {
    $nilai = [
        'nama' => '',
        'id_mapel' => 0,
        'id_kelas' => 0,
        'uts' => 0,
        'uas' => 0,
    ];
    // Act
    $response = $this->post(route('walas.manajemen-nilai.store'), $nilai);

    // Assert
    $response->assertSessionHasNoErrors(['nama']);
    
    $response->assertSessionHasErrors(['nama']);
    $this->assertGreaterThan($nilai['uts'], 100);
    $this->assertGreaterThan($nilai['uas'], 100);
});

// test('Input nilai UTS gagal disimpan', function () {
//     $nilai = [
//         'nama' => 'Mamat',
//         'id_mapel' => 1,
//         'id_kelas' => 1,
//         'uts' => 120,
//         'uas' => 85,
//     ];

//     // Assert
//     $this->assertGreaterThan(100, $nilai['uts']);
// });

// test('Input nilai UAS gagal disimpan', function () {
//     $nilai = [
//         'nama' => 'Mamat',
//         'id_mapel' => 1,
//         'id_kelas' => 1,
//         'uts' => 80,
//         'uas' => 120,
//     ];

//     // Assert
//     $this->assertGreaterThan(100, $nilai['uas']);
// });
