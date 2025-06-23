<?php
use Livewire\Livewire;
use App\Models\Siswa;
use App\Filament\Resources\SiswaResource\Pages\ListSiswas;
use Carbon\Carbon;
use App\Filament\Resources\SiswaResource\Pages\EditSiswa;
use App\Filament\Resources\SiswaResource\Pages\CreateSiswa;


test('Validasi dapat menambahkan data siswa', function() {
    //Arrange
    $dataSiswa = [
        'nis' => '12360',
        'nisn' => '0123456384',
        'nama' => 'Anisa Putri',
        'jenis_kelamin' => 'P',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2025-05-15',
        'tanggal_masuk' => '2010-05-15',
        'alamat' => 'Jl. Sudirman No. 45, RT 03/RW 04, Kec. Cicendo, Kota Bandung',
        'nama_bapak' => 'Drs. Agus Supriyanto',
        'nama_ibu' => 'Sri Wahyuni, S.E.',
        'pekerjaan_bapak' => 'asjd',
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

    $dataUpdate = [
        'nis' => '55555',
        'nisn' => '5555555555',
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
    Livewire::test(EditSiswa::class, ['record' => 2])
        ->fillForm($dataUpdate)
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('siswa',[
        'id' => 2,
        'nama' => 'Gita Nirmala Update',
        'alamat' => 'Jl. Slamet Riyadi No. 50, Surakarta'
    ]);
});


test('Validasi data siswa tidak bisa di edit di filament dengan data kosong', function() {
    //Arrange

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
    Livewire::test(EditSiswa::class, ['record' => 2])
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

test('Validasi data siswa tidak bisa di create di Filament dengan data kosong', function() {
        //Arrange
    $dataSiswa = [
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
    Livewire::test(CreateSiswa::class)
        ->fillForm($dataSiswa)
        ->call('create')
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

test('Admin tidak dapat menambahkan siswa dengan NIS duplikat', function() {
    $existingSiswa = Siswa::create([
        'nis' => '22222',
        'nisn' => '2222222222',
        'nama' => 'Budi Santoso Wijayanto',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Surabaya',
        'tanggal_lahir' => Carbon::now()->subYears(12)->format('Y-m-d'),
        'tanggal_masuk' => Carbon::now()->format('Y-m-d'),
        'alamat' => 'Jl. Gatot Subroto No. 10, Jakarta Selatan',
        'nama_bapak' => 'Bambang Santoso Wijayanto',
        'nama_ibu' => 'Dewi Sartikawati',
        'pekerjaan_bapak' => 'Pilot',
        'pekerjaan_ibu' => 'Guru',
        'no_hp_bapak' => '081234567891',
        'no_hp_ibu' => '085678901235'
    ]);

    // Verifikasi siswa berhasil dibuat
    $this->assertDatabaseHas('siswa', [
        'nis' => '22222',
        'nisn' => '2222222222'
    ]);

    // Coba buat siswa dengan NIS yang sama
    Livewire::test(CreateSiswa::class)
        ->fillForm([
            'nis' => '22222',
            'nisn' => '2222222222',
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