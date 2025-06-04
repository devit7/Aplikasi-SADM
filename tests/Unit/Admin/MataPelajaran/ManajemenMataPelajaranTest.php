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
        'nama_kelas' => 'X IPA 6',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 2, 
    ]);
    
    $dataMatapelajaran = [
        'nama_mapel' => 'Matematika',
        'kode_mapel' => 'MTK001',
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
        'nama_mapel' => 'Matematika',
        'kode_mapel' => 'MTK001',
        'kelas_id' => $kelas->id,
    ]);
});

test('Admin tidak dapat menambahkan mata pelajaran dengan kode yang sudah ada', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 7',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 2,
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

test('Admin dapat melihat daftar mata pelajaran', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 8',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 2, 
    ]);
    
    // Buat mata pelajaran
    $matapelajaran = Matapelajaran::create([
        'nama_mapel' => 'Biologi',
        'kode_mapel' => 'BIO001',
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Act & Assert
    Livewire::test(ListMatapelajarans::class)
        ->assertCanSeeTableRecords([$matapelajaran]);
});

test('Admin dapat memperbarui data mata pelajaran', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 9',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 2,
    ]);
    
    // Buat mata pelajaran yang akan diupdate
    $matapelajaranCanEdit = Matapelajaran::create([
        'nama_mapel' => 'Kimia',
        'kode_mapel' => 'KIM001',
        'kelas_id' => $kelas->id,
        'semester' => 'ganjil',
        'kkm' => '75',
    ]);

    // Data untuk update
    $dataUpdate = [
        'nama_mapel' => 'Kimia Lanjutan',
        'kode_mapel' => 'KIM001',
        'kelas_id' => $kelas->id,
        'semester' => 'genap',
        'kkm' => '80',
    ];

    // Act & Assert
    Livewire::test(EditMatapelajaran::class, ['record' => $matapelajaranCanEdit->id])
        ->fillForm($dataUpdate)
        ->call('save')
        ->assertHasNoFormErrors();
    
    // Verifikasi data berhasil diupdate di database
    $this->assertDatabaseHas('matapelajaran', [
        'id' => $matapelajaranCanEdit->id,
        'nama_mapel' => 'Kimia Lanjutan',
        'semester' => 'genap',
        'kkm' => '80',
    ]);
});

test('Validasi data mata pelajaran tidak bisa di edit di Filament dengan data kosong', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 10',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 2, 
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
        'walikelas_id' => 2, 
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