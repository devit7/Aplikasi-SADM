<?php

use App\Http\Controllers\Walas\ManajemenAbsen;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\DetailKelas;
use App\Models\Presensi;
use App\Models\DetailPresensi;
use App\Models\Absen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

describe('Absensi Unit Tests', function () {

    test('Absen can be created with valid data', function () {
        // Arrange
        $absenData = [
            'detail_kelas_id' => 1,
            'tanggal' => '2025-06-13',
            'status' => 'hadir',
        ];

        // Act
        $absen = Absen::create($absenData);

        // Assert
        expect($absen)->toBeInstanceOf(Absen::class);
        expect($absen->detail_kelas_id)->toBe(1);
        expect($absen->tanggal)->toBe('2025-06-13');
        expect($absen->status)->toBe('hadir');

        $this->assertDatabaseHas('absen', [
            'detail_kelas_id' => 1,
            'tanggal' => '2025-06-13',
            'status' => 'hadir'
        ]);
    });

    test('Absen can be updated', function () {
        // Arrange
        $absen = Absen::create([
            'detail_kelas_id' => 1,
            'tanggal' => '2025-06-13',
            'status' => 'hadir'
        ]);

        // Act
        $absen->update([
            'status' => 'izin',
        ]);

        // Assert
        $this->assertDatabaseHas('absen', [
            'id' => $absen->id,
            'status' => 'izin',
        ]);
    });

    test('Absen creation fails with invalid status', function () {
        // Arrange
        $invalidAbsenData = [
            'detail_kelas_id' => 1,
            'tanggal' => '2024-01-15',
            'status' => 'invalid_status',
        ];

        // Act & Assert
        expect(function () use ($invalidAbsenData) {
            Absen::create($invalidAbsenData);
        })->toThrow(Exception::class);
    });

    test('Absen update fails with invalid status', function () {
        // Arrange
        $absen = Absen::create([
            'detail_kelas_id' => 7,
            'tanggal' => '2025-06-13',
            'status' => 'hadir'
        ]);

        // Act & Assert
        expect(function () use ($absen) {
            $absen->update(['status' => 'invalid_status']);
        })->toThrow(Exception::class);
    });
});
