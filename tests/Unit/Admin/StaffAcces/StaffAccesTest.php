<?php

use App\Models\StaffAcces;
// use App\Models\Staff;
// use App\Models\Kelas;
// use App\Models\Matapelajaran;
// use App\Models\User;

test('StaffAcces dapat dibuat dengan data yang valid', function () {
    // Arrange
    $staffAccesData1 = [
        'staff_id' => 3,
        'kelas_id' => 3,
        'matapelajaran_id' => 4,
        'akses_nilai' => true,
        'akses_absen' => true,
    ];

    // Act
    $staffAcces1 = StaffAcces::create($staffAccesData1);

    // Assert StaffAcces 1
    expect($staffAcces1)->toBeInstanceOf(StaffAcces::class);
    expect($staffAcces1->staff_id)->toBe(3);
    expect($staffAcces1->kelas_id)->toBe(3);
    expect($staffAcces1->matapelajaran_id)->toBe(4);
    expect($staffAcces1->akses_nilai)->toBe(true);
    expect($staffAcces1->akses_absen)->toBe(true);

    $this->assertDatabaseHas('staff_access', [
        'staff_id' => 3,
        'kelas_id' => 3,
        'matapelajaran_id' => 4,
    ]);
});

test('StaffAcces dapat diupdate dengan data yang valid', function () {
    // Arrange
    $staffAcces = StaffAcces::create([
        'staff_id' => 3,
        'kelas_id' => 5,
        'matapelajaran_id' => 9,
        'akses_nilai' => true,
        'akses_absen' => true,
    ]);

    // Act
    $staffAccesUpdate = $staffAcces->update(['kelas_id' => 10]);

    // Assert
    expect($staffAccesUpdate)->toBeTrue();
    expect($staffAcces->fresh()->kelas_id)->toBe(10);
});

test('StaffAcces tidak dapat dibuat dengan staff_id yang tidak valid', function () {
    // Arrange
    $staffAccesData = [
        'staff_id' => 99999,
        'kelas_id' => 5,
        'matapelajaran_id' => 9,
        'akses_nilai' => true,
        'akses_absen' => true,
    ];
    // Act & Assert
    expect(function () use ($staffAccesData) {
        StaffAcces::create($staffAccesData);
    })->toThrow(Exception::class);

    // // Act
    // $staffAccesResult = StaffAcces::create($staffAccesData);
    // // Assert
    // expect($staffAccesResult->fresh()->staff_id)->toBe(99999);
});

test('StaffAcces tidak dapat diupdate dengan kelas_id yang tidak valid', function () {
    // Arrange
    $staffAcces = StaffAcces::create([
        'staff_id' => 3,
        'kelas_id' => 5,
        'matapelajaran_id' => 4,
        'akses_nilai' => true,
        'akses_absen' => true,
    ]);
    // Act & Assert
    expect(function () use ($staffAcces) {
        $staffAcces->update([
            'kelas_id' => 999999
        ]);
    })->toThrow(Exception::class);

    // // Act
    // $staffAccesUpdate = $staffAcces->update(['kelas_id' => 99999]);
    // // Assert
    // expect($staffAccesUpdate->fresh()->kelas_id)->toBe(99999);
});
