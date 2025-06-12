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
        $waliKelas = User::factory()->create(['role' => 'walikelas']);
        $kelas = Kelas::create([
            'nama_kelas' => 'X IPA ' . mt_rand(1, 9),
            'tahun_ajaran' => '2024/2025',
            'walikelas_id' => $waliKelas->id
        ]);

        $siswa = Siswa::create([
            'nis' => str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT),
            'nisn' => str_pad(mt_rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT),
            'nama' => 'Pratama ' . uniqid(),
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => Carbon::now()->subYears(10)->format('Y-m-d'),
            'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
            'alamat' => 'Jl. Sudirman No. 45, RT 03/RW 04, Kec. Cicendo, Kota Bandung',
            'nama_bapak' => 'Drs. Agus Supriyanto',
            'nama_ibu' => 'Sri Wahyuni, S.E.',
            'pekerjaan_bapak' => 'Pegawai Swasta',
            'pekerjaan_ibu' => 'Wiraswasta',
            'no_hp_bapak' => str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT),
            'no_hp_ibu' => str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT)
        ]);

        $detailKelas = DetailKelas::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id
        ]);

        $absenData = [
            'detail_kelas_id' => $detailKelas->id,
            'tanggal' => '2024-01-15',
            'status' => 'hadir',
        ];

        // Act
        $absen = Absen::create($absenData);

        // Assert
        expect($absen)->toBeInstanceOf(Absen::class);
        expect($absen->detail_kelas_id)->toBe($detailKelas->id);
        expect($absen->tanggal)->toBe('2024-01-15');
        expect($absen->status)->toBe('hadir');

        $this->assertDatabaseHas('absen', [
            'detail_kelas_id' => $detailKelas->id,
            'tanggal' => '2024-01-15',
            'status' => 'hadir'
        ]);
    });

    test('Absen can be updated', function () {
        // Arrange
        $waliKelas = User::factory()->create(['role' => 'walikelas']);
        $kelas = Kelas::create([
            'nama_kelas' => 'X IPA ' . mt_rand(1, 9),
            'tahun_ajaran' => '2024/2025',
            'walikelas_id' => $waliKelas->id
        ]);

        $siswa = Siswa::create([
            'nis' => str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT),
            'nisn' => str_pad(mt_rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT),
            'nama' => 'Yoga ' . uniqid(),
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => Carbon::now()->subYears(10)->format('Y-m-d'),
            'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
            'alamat' => 'Jl. Sudirman No. 45, RT 03/RW 04, Kec. Cicendo, Kota Bandung',
            'nama_bapak' => 'Drs. Agus Supriyanto',
            'nama_ibu' => 'Sri Wahyuni, S.E.',
            'pekerjaan_bapak' => 'Pegawai Swasta',
            'pekerjaan_ibu' => 'Wiraswasta',
            'no_hp_bapak' => str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT),
            'no_hp_ibu' => str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT)
        ]);

        $detailKelas = DetailKelas::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id
        ]);

        $absen = Absen::create([
            'detail_kelas_id' => $detailKelas->id,
            'tanggal' => '2024-01-16',
            'status' => 'hadir'
        ]);

        // Act
        $absen->update([
            'status' => 'izin',
        ]);

        // Assert
        expect($absen->fresh()->status)->toBe('izin');

        $this->assertDatabaseHas('absen', [
            'id' => $absen->id,
            'status' => 'izin',
        ]);
    });
});
