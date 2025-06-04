<?php

use App\Models\Siswa;
use Livewire\Livewire;
use Carbon\Carbon;
use App\Filament\Resources\SiswaResource\Pages\CreateSiswa;
use App\Filament\Resources\SiswaResource\Pages\EditSiswa;
use App\Filament\Resources\SiswaResource\Pages\ListSiswas;

test('Validasi dapat menambahkan data siswa', function() {
    //Arrange
    $dataSiswa = [
        'nis' => '12345',
        'nisn' => '0123456789',
        'nama' => 'Anisa Putri',
        'jenis_kelamin' => 'P',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => Carbon::now()->subYears(10)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Sudirman No. 45, RT 03/RW 04, Kec. Cicendo, Kota Bandung',
        'nama_bapak' => 'Drs. Agus Supriyanto',
        'nama_ibu' => 'Sri Wahyuni, S.E.',
        'pekerjaan_bapak' => 'Pegawai Swasta',
        'pekerjaan_ibu' => 'Wiraswasta',
        'no_hp_bapak' => '081234567890',
        'no_hp_ibu' => '085678901234'
    ];

    //Act & Assert
    Livewire::test(CreateSiswa::class)
        ->fillForm($dataSiswa)
        ->call('create')
        ->assertHasNoInfolistActionErrors();
});

test('Admin tidak dapat menambahkan siswa dengan NIS yang sudah ada', function() {
    //Arrange
    // Buat siswa yang sudah ada
    $existingSiswa = Siswa::create([
        'nis' => '54321',
        'nisn' => '9876543210',
        'nama' => 'Budi Santoso',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => Carbon::now()->subYears(12)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Gatot Subroto No. 10, Jakarta Selatan',
        'nama_bapak' => 'Bambang Santoso',
        'nama_ibu' => 'Dewi Sartika',
        'pekerjaan_bapak' => 'Wiraswasta',
        'pekerjaan_ibu' => 'Guru',
        'no_hp_bapak' => '081234567891',
        'no_hp_ibu' => '085678901235'
    ]);

    // Verifikasi siswa berhasil dibuat
    $this->assertDatabaseHas('siswa', [
        'nis' => '54321',
        'nisn' => '9876543210'
    ]);

    // Coba buat siswa dengan NIS yang sama
    Livewire::test(CreateSiswa::class)
        ->fillForm([
            'nis' => '54321',
            'nisn' => '9876543210',
            'nama' => 'Citra Dewi',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => Carbon::now()->subYears(11)->format('Y-m-d'),
            'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
            'alamat' => 'Jl. Pahlawan No. 15, Surabaya',
            'nama_bapak' => 'Hendra Wijaya',
            'nama_ibu' => 'Ratna Sari',
            'pekerjaan_bapak' => 'Dokter',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'no_hp_bapak' => '081234567892',
            'no_hp_ibu' => '085678901236'
        ])
        ->call('create')
        ->assertHasFormErrors(['nis' => 'unique', 'nisn' => 'unique']);
});

test('Admin dapat melihat daftar siswa', function() {
    // Arrange
    $siswa1 = Siswa::create([
        'nis' => '33333',
        'nisn' => '3333333333',
        'nama' => 'Faisal Rahman',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Yogyakarta',
        'tanggal_lahir' => Carbon::now()->subYears(12)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Malioboro No. 25, Yogyakarta',
        'nama_bapak' => 'Ahmad Rahman',
        'nama_ibu' => 'Nurul Hidayah',
        'pekerjaan_bapak' => 'Dosen',
        'pekerjaan_ibu' => 'Dokter',
        'no_hp_bapak' => '081234567895',
        'no_hp_ibu' => '085678901239'
    ]);

    // Act & Assert
    Livewire::test(ListSiswas::class)
        ->assertCanSeeTableRecords([$siswa1]);
});

test('Admin dapat memperbarui data siswa', function() {
    //Arrange
    $siswaCanEdit = Siswa::create([
        'nis' => '44444',
        'nisn' => '4444444444',
        'nama' => 'Gita Nirmala',
        'jenis_kelamin' => 'P',
        'tempat_lahir' => 'Surakarta',
        'tanggal_lahir' => Carbon::now()->subYears(11)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Slamet Riyadi No. 40, Surakarta',
        'nama_bapak' => 'Budi Santoso',
        'nama_ibu' => 'Rina Wati',
        'pekerjaan_bapak' => 'Pengusaha',
        'pekerjaan_ibu' => 'Guru',
        'no_hp_bapak' => '081234567896',
        'no_hp_ibu' => '085678901240'
    ]);

    $dataUpdate = [
        'nis' => '44444',
        'nisn' => '4444444444',
        'nama' => 'Gita Nirmala Update',
        'jenis_kelamin' => 'P',
        'tempat_lahir' => 'Surakarta',
        'tanggal_lahir' => Carbon::now()->subYears(11)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Slamet Riyadi No. 50, Surakarta',
        'nama_bapak' => 'Budi Santoso',
        'nama_ibu' => 'Rina Wati',
        'pekerjaan_bapak' => 'Pengusaha',
        'pekerjaan_ibu' => 'Guru',
        'no_hp_bapak' => '081234567896',
        'no_hp_ibu' => '085678901240'
    ];

    //Act & Assert
    Livewire::test(EditSiswa::class, ['record' => $siswaCanEdit->id])
        ->fillForm($dataUpdate)
        ->call('save')
        ->assertHasNoFormErrors();
    
    $this->assertDatabaseHas('siswa',[
        'id' => $siswaCanEdit->id,
        'nama' => 'Gita Nirmala Update',
        'alamat' => 'Jl. Slamet Riyadi No. 50, Surakarta'
    ]);
});

test('Validasi data siswa tidak bisa di edit di Filament dengan data kosong ', function() {
    //Arrange
    $siswa = Siswa::create([
        'nis' => '55555',
        'nisn' => '5555555555',
        'nama' => 'Hendra Wijaya',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Medan',
        'tanggal_lahir' => Carbon::now()->subYears(12)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Diponegoro No. 35, Medan',
        'nama_bapak' => 'Wijaya Kusuma',
        'nama_ibu' => 'Sinta Dewi',
        'pekerjaan_bapak' => 'Pengacara',
        'pekerjaan_ibu' => 'Akuntan',
        'no_hp_bapak' => '081234567897',
        'no_hp_ibu' => '085678901241'
    ]);

    $dataSiswaKosong = [
        'nis' => '',
        'nisn' => '',
        'nama' => '',
        'jenis_kelamin' => '',
        'tempat_lahir' => '',
        'tanggal_lahir' => '',
        'tanggal_masuk' => '',
        'alamat' => '',
        'nama_bapak' => '',
        'nama_ibu' => '',
        'pekerjaan_bapak' => '',
        'pekerjaan_ibu' => '',
        'no_hp_bapak' => '',
        'no_hp_ibu' => ''
    ];

    //Act & Assert
    Livewire::test(EditSiswa::class, ['record' => $siswa->id])
        ->fillForm($dataSiswaKosong)
        ->call('save')
        ->assertHasFormErrors([
            'nis' => 'required',
            'nisn' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'tanggal_masuk' => 'required',
            'alamat' => 'required',
            'nama_bapak' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_bapak' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_hp_bapak' => 'required',
            'no_hp_ibu' => 'required'
        ]);
});


test('Admin dapat menghapus data siswa', function() {
     // Arrange
    $siswa = Siswa::create([
        'nis' => '66666',
        'nisn' => '6666666666',
        'nama' => 'Indra Lesmana',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Palembang',
        'tanggal_lahir' => Carbon::now()->subYears(11)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Sudirman No. 60, Palembang',
        'nama_bapak' => 'Lesmana Putra',
        'nama_ibu' => 'Dina Mardiana',
        'pekerjaan_bapak' => 'Pengusaha',
        'pekerjaan_ibu' => 'Dokter',
        'no_hp_bapak' => '081234567898',
        'no_hp_ibu' => '085678901242'
    ]);

    //Act & Assert
    Livewire::test(EditSiswa::class, ['record' => $siswa->id])
        ->callAction('delete')
        ->assertHasNoActionErrors();
    
    $this->assertDatabaseMissing('siswa',[
        'id' => $siswa->id
    ]);
});