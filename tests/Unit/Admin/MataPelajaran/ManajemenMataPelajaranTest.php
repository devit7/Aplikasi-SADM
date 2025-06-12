<?php
use App\Models\Matapelajaran;
use App\Models\Kelas;
use Livewire\Livewire;
use App\Filament\Resources\MatapelajaranResource\Pages\CreateMatapelajaran;
use App\Filament\Resources\MatapelajaranResource\Pages\EditMatapelajaran;
use App\Filament\Resources\MatapelajaranResource\Pages\ListMatapelajarans;
use Carbon\Carbon;

test('Validasi dapat menambahkan data mata pelajaran', function() {
     // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA'. uniqid(2),
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 6, 
    ]);
    
    $dataMatapelajaran = [
        'nama_mapel' => 'Matematika'. mt_rand(1, 9),
        'kode_mapel' => 'MTK'. uniqid(2), 
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75',
    ];

    // Act & Assert
    Livewire::test(CreateMatapelajaran::class)
        ->fillForm($dataMatapelajaran)
        ->call('create')
        ->assertHasNoFormErrors();

    // Verifikasi data berhasil disimpan ke database
    $this->assertDatabaseHas('matapelajaran', [
        'nama_mapel' => $dataMatapelajaran['nama_mapel'],
        'kode_mapel' => $dataMatapelajaran['kode_mapel'],
        'kelas_id' => $kelas->id,
    ]);
});

test('Admin tidak dapat menambahkan mata pelajaran dengan kode yang sudah ada', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 7',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 6,
    ]);
    
    $existingMatapelajaran = Matapelajaran::create([
        'nama_mapel' => 'Fisika',
        'kode_mapel' => 'FIS001',
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Act & Assert
    $this->assertDatabaseHas('matapelajaran', [
        'kode_mapel' => 'FIS001',
    ]);

    // Coba buat mata pelajaran dengan kode yang sama
    Livewire::test(CreateMatapelajaran::class)
        ->fillForm([
            'nama_mapel' => 'Fisika Lanjutan',
            'kode_mapel' => 'FIS001', 
            'kelas_id' => $kelas->id,
            'semester' => 'genap',
            'kkm' => '80',
        ])
        ->call('create')
        ->assertHasFormErrors(['kode_mapel' => 'unique']);
});


test('Validasi data mata pelajaran tidak bisa di edit di Filament dengan data kosong', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 10',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 6, 
    ]);
    
    // Buat mata pelajaran
    $matapelajaran = Matapelajaran::create([
        'nama_mapel' => 'Bahasa Inggris',
        'kode_mapel' => 'BIG001',
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Data kosong untuk validasi
    $dataMatapelajaranKosong = [
        'nama_mapel' => '',
        'kode_mapel' => '',
        'kelas_id' => '',
        'semester' => '',
        'kkm' => '',
    ];

    // Act & Assert
    Livewire::test(EditMatapelajaran::class, ['record' => $matapelajaran->id])
        ->fillForm($dataMatapelajaranKosong)
        ->call('save')
        ->assertHasFormErrors([
            'nama_mapel' => 'required',
            'kode_mapel' => 'required',
            'kelas_id' => 'required',
            'semester' => 'required',
            'kkm' => 'required',
        ]);
});

test('Admin dapat menghapus data mata pelajran', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 11',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 6, 
    ]);
    
    // Buat mata pelajaran yang akan dihapus
    $matapelajaran = Matapelajaran::create([
        'nama_mapel' => 'Bahasa Indonesia',
        'kode_mapel' => 'BIN001',
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Act & Assert
    Livewire::test(EditMatapelajaran::class, ['record' => $matapelajaran->id])
        ->callAction('delete')
        ->assertHasNoActionErrors();
    
    // Verifikasi data berhasil dihapus dari database
    $this->assertDatabaseMissing('matapelajaran', [
        'id' => $matapelajaran->id,
    ]);
});