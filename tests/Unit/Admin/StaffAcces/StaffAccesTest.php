<?php

use App\Models\StaffAcces;
use App\Models\Staff;
use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


test('StaffAcces dapat dibuat dengan data yang valid', function () {
    // Arrange
    $waliKelas = User::factory()->create([
        'role' => 'walikelas'
    ]);

    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA ' . mt_rand(1, 9),
        'tahun_ajaran' => '2024/2025',
        'walikelas_id' => $waliKelas->id
    ]);

    $staff = Staff::create([
        'nama' => 'Staff' . uniqid(),
        'nip' => str_pad(mt_rand(100000000000000000, 999999999999999999), 18, '0', STR_PAD_LEFT),
        'email' => 'staff' . uniqid() . '@test.com',
        'password' => bcrypt('password123'),
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '1990-01-01',
        'no_hp' => str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT),
        'alamat' => 'Jl. Test No.' . uniqid()
    ]);

    $matapelajaran = Matapelajaran::create([
        'nama_mapel' => 'Matematika' . uniqid(),
        'kode_mapel' => 'MTK' . strtoupper(uniqid()),
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75'
    ]);

    $staffAccesData = [
        'staff_id' => $staff->id,
        'kelas_id' => $kelas->id,
        'matapelajaran_id' => $matapelajaran->id,
        'akses_nilai' => true,
        'akses_absen' => true,
        // 'akses_alquran_learning' => false,
        // 'akses_extrakurikuler' => true,
        // 'akses_worship_character' => false
    ];

    // Act
    $staffAcces = StaffAcces::create($staffAccesData);

    // Assert
    expect($staffAcces)->toBeInstanceOf(StaffAcces::class);
    expect($staffAcces->staff_id)->toBe($staff->id);
    expect($staffAcces->kelas_id)->toBe($kelas->id);
    expect($staffAcces->matapelajaran_id)->toBe($matapelajaran->id);
    expect($staffAcces->akses_nilai)->toBe(true);
    expect($staffAcces->akses_absen)->toBe(true);
    // expect($staffAcces->akses_alquran_learning)->toBe(false);
    // expect($staffAcces->akses_extrakurikuler)->toBe(true);
    // expect($staffAcces->akses_worship_character)->toBe(false);

    $this->assertDatabaseHas('staff_access', [
        'staff_id' => $staff->id,
        'kelas_id' => $kelas->id,
        'matapelajaran_id' => $matapelajaran->id
    ]);
});

test('StaffAcces dapat dihapus', function () {
    // Arrange
    $waliKelas = User::factory()->create(['role' => 'walikelas']);
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPS ' . mt_rand(1, 9),
        'tahun_ajaran' => '2024/2025',
        'walikelas_id' => $waliKelas->id
    ]);

    $staff = Staff::create([
        'nama' => 'Staff' . uniqid(),
        'nip' => str_pad(mt_rand(100000000000000000, 999999999999999999), 18, '0', STR_PAD_LEFT),
        'email' => 'staff' . uniqid() . '@test.com',
        'password' => bcrypt('password123'),
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '1990-01-01',
        'no_hp' => str_pad(mt_rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT),
        'alamat' => 'Jl. Test No.' . uniqid()
    ]);

    $staffAcces = StaffAcces::create([
        'staff_id' => $staff->id,
        'kelas_id' => $kelas->id,
        'akses_nilai' => true,
        'akses_absen' => true,
        // 'akses_alquran_learning' => false,
        // 'akses_extrakurikuler' => false,
        // 'akses_worship_character' => true
    ]);

    // Act
    $staffAcces->delete();

    // Assert
    $this->assertDatabaseMissing('staff_access', [
        'id' => $staffAcces->id
    ]);
});
