<?php

use App\Models\StaffAcces;
use App\Models\Staff;
use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


test('StaffAcces dapat dibuat dengan data yang valid', function () {
    // Arrange
    $staffAccesData1 = [
        'staff_id' => 3,
        'kelas_id' => 3,
        'matapelajaran_id' => 3,
        'akses_nilai' => true,
        'akses_absen' => true,
        // 'akses_alquran_learning' => false,
        // 'akses_extrakurikuler' => true,
        // 'akses_worship_character' => false
    ];
    $staffAccesData2 = [
        'staff_id' => 3,
        'kelas_id' => 2,
        'matapelajaran_id' => 2,
        'akses_nilai' => true,
        'akses_absen' => true,
        // 'akses_alquran_learning' => false,
        // 'akses_extrakurikuler' => true,
        // 'akses_worship_character' => false
    ];

    // Act
    $staffAcces1 = StaffAcces::create($staffAccesData1);
    $staffAcces2 = StaffAcces::create($staffAccesData2);

    // Assert StaffAcces 1
    expect($staffAcces1)->toBeInstanceOf(StaffAcces::class);
    expect($staffAcces1->staff_id)->toBe(3);
    expect($staffAcces1->kelas_id)->toBe(3);
    expect($staffAcces1->matapelajaran_id)->toBe(3);
    expect($staffAcces1->akses_nilai)->toBe(true);
    expect($staffAcces1->akses_absen)->toBe(true);

    // Assert StaffAcces 2
    expect($staffAcces2)->toBeInstanceOf(StaffAcces::class);
    expect($staffAcces2->staff_id)->toBe(3);
    expect($staffAcces2->kelas_id)->toBe(2);
    expect($staffAcces2->matapelajaran_id)->toBe(2);
    expect($staffAcces2->akses_nilai)->toBe(true);
    expect($staffAcces2->akses_absen)->toBe(true);

    $this->assertDatabaseHas('staff_access', [
        'staff_id' => [3, 3],
        'kelas_id' => [3, 2],
        'matapelajaran_id' => [3, 2],
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

test('StaffAcces tidak dapat dibuat dengan staff_id yang tidak valid', function () {
    // Arrange
    $waliKelas = User::factory()->create(['role' => 'walikelas']);
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA ' . mt_rand(1, 9),
        'tahun_ajaran' => '2024/2025',
        'walikelas_id' => $waliKelas->id
    ]);

    $staffAccesData = [
        'staff_id' => 999999, // Invalid staff_id
        'kelas_id' => $kelas->id,
        'akses_nilai' => true,
        'akses_absen' => true,
    ];

    // Act & Assert
    expect(function () use ($staffAccesData) {
        StaffAcces::create($staffAccesData);
    })->toThrow(Exception::class);
});

test('StaffAcces tidak dapat diupdate dengan kelas_id yang tidak valid', function () {
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
    ]);

    // Act & Assert
    expect(function () use ($staffAcces) {
        $staffAcces->update([
            'kelas_id' => 999999 // Invalid kelas_id
        ]);
    })->toThrow(Exception::class);
});
