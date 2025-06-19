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

    test('Absen dapat dibuat dengan data yang valid', function () {
        // Arrange
        $absenData = [
            'detail_kelas_id' => 1,
            'tanggal' => now()->format('Y-m-d'), // Menggunakan tanggal saat ini
            'status' => 'hadir',
        ];

        // Act
        $absen = Absen::create($absenData);

        // Assert
        expect($absen)->toBeInstanceOf(Absen::class);
        expect($absen->detail_kelas_id)->toBe(1);
        expect($absen->tanggal)->toBe(now()->format('Y-m-d'));
        expect($absen->status)->toBe('hadir');

        $this->assertDatabaseHas('absen', [
            'detail_kelas_id' => 1,
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'hadir'
        ]);
    });

    test('Absen dapat diupdate dengan data yang valid', function () {
        // Arrange
        $absen = Absen::create([
            'detail_kelas_id' => 1,
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'hadir'
        ]);

        // Act
        $absen->update([
            'tanggal' => now()->addDay()->format('Y-m-d'),
            'status' => 'izin',
        ]);

        // Assert
        $this->assertDatabaseHas('absen', [
            'id' => $absen->id,
            'status' => 'izin',
        ]);
    });

    test('Absen tidak dapat dibuat dengan data yang tidak valid', function () {
        // Arrange
        $invalidAbsenData = [
            'detail_kelas_id' => 1,
            'tanggal' => '2025-06-18',
            'status' => 'hadir',
        ];

        // Act & Assert
        expect(function () use ($invalidAbsenData) {
            Absen::create($invalidAbsenData);
        })->toThrow(Exception::class);
        
        // // Act
        // $absenUpdate = Absen::create($invalidAbsenData);
        // // Assert
        // expect($absenUpdate)->toBeInstanceOf(Absen::class);
        // expect($absenUpdate->detail_kelas_id)->toBe(1);
        // expect($absenUpdate->tanggal)->toBe(now()->format('Y-m-d'));
        // expect($absenUpdate->status)->toBe('hadir');

    });

    test('Absen tidak dapat diupdate dengan status yang tidak valid', function () {
        // Arrange
        $invalidAbsenData = Absen::create([
            'detail_kelas_id' => 7,
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'hadir'
        ]);
        // Act & Assert
        expect(function () use ($invalidAbsenData) {
            $invalidAbsenData->update(['status' => 'invalid_status']);
        })->toThrow(Exception::class);

        // // Act
        // $absenUpdate = $invalidAbsenData->update(['status' => 'invalid_status']);
        // // Assert
        // expect($absenUpdate)->toBeInstanceOf(Absen::class);
        // expect($absenUpdate->detail_kelas_id)->toBe(7);
        // expect($absenUpdate->tanggal)->toBe(now()->format('Y-m-d'));
        // expect($absenUpdate->status)->toBe('hadir');
    });
});
