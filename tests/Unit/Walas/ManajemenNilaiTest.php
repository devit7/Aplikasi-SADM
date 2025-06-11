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

uses(RefreshDatabase::class);

test('Input nilai valid berhasil disimpan', function () {
    // Arrange
    $kelas = Kelas::factory()->create();
    $siswa = Siswa::factory()->create();
    $detailKelas = DetailKelas::factory()->create([
        'siswa_id' => $siswa->id,
        'kelas_id' => $kelas->id,
    ]);
    $mapel = Matapelajaran::factory()->create([
        'kelas_id' => $kelas->id,
    ]);

    $request = Request::create('/walas/manajemen-nilai', 'POST', [
        'nama' => $siswa->nama,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
        'uts' => 85,
        'uas' => 90,
    ]);

    // Act
    $controller = new ManajemenNilai();
    $response = $controller->store($request);

    // Assert
    $this->assertDatabaseHas('nilai', [
        'detail_kelas_id' => $detailKelas->id,
        'matapelajaran_id' => $mapel->id,
        'nilai_uts' => 85,
        'nilai_uas' => 90,
    ]);
});

test('Input nilai gagal jika siswa tidak ditemukan', function () {
    // Arrange
    $kelas = Kelas::factory()->create();
    $mapel = Matapelajaran::factory()->create([
        'kelas_id' => $kelas->id,
    ]);

    $request = Request::create('/walas/manajemen-nilai', 'POST', [
        'nama' => 'Nama Tidak Ada',
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
        'uts' => 80,
        'uas' => 85,
    ]);

    // Act
    $controller = new ManajemenNilai();
    $response = $controller->store($request);

    // Assert
    $this->assertEquals(302, $response->getStatusCode());
    $this->assertStringContainsString('Siswa tidak ditemukan', session('error'));
});

test('Input nilai gagal jika nilai UTS/UAS di luar rentang', function () {
    // Arrange
    $kelas = Kelas::factory()->create();
    $siswa = Siswa::factory()->create();
    $detailKelas = DetailKelas::factory()->create([
        'siswa_id' => $siswa->id,
        'kelas_id' => $kelas->id,
    ]);
    $mapel = Matapelajaran::factory()->create([
        'kelas_id' => $kelas->id,
    ]);

    $request = Request::create('/walas/manajemen-nilai', 'POST', [
        'nama' => $siswa->nama,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
        'uts' => 120, // Invalid
        'uas' => -10, // Invalid
    ]);

    // Act & Assert
    $controller = new ManajemenNilai();
    try {
        $controller->store($request);
        $this->fail('Validasi tidak berjalan');
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->assertArrayHasKey('uts', $e->errors());
        $this->assertArrayHasKey('uas', $e->errors());
    }
}
);