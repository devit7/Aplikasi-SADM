<?php
use App\Models\Kelas;
use App\Models\User;
use Livewire\Livewire;
use App\Filament\Resources\KelasResource\Pages\CreateKelas;
use App\Filament\Resources\KelasResource\Pages\EditKelas;
use App\Filament\Resources\KelasResource\Pages\ListKelas;

test('Validasi data kelas saat ditambahkan di Filament', function() {
    //Arrange
    $waliKelas = User::factory()->create([
        'role' => 'walikelas'
    ]);

    $dataKelas = [
        'nama_kelas' => 'X IPA 111',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelas->id
    ];

    //Act & Assert
    Livewire::test(CreateKelas::class)
        ->fillForm($dataKelas)
        ->call('create')
        ->assertHasNoInfolistActionErrors();
});

test('Admin tidak dapat menambahkan kelas dengan nama yang sudah ada di tahun ajaran yang sama', function() {
    //Arrange
    $waliKelas = User::factory()->create([
        'role' => 'walikelas'
    ]);

    // Buat kelas yang sudah ada
    $existingKelas = Kelas::create([
        'nama_kelas' => 'X IPA 2',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelas->id
    ]);

    // Verifikasi kelas berhasil dibuat
    $this->assertDatabaseHas('kelas', [
        'nama_kelas' => 'X IPA 2',
        'tahun_ajaran' => '2023/2024'
    ]);

    // Coba buat kelas dengan nama yang sama
    Livewire::test(CreateKelas::class)
        ->fillForm([
            'nama_kelas' => 'X IPA 2',
            'tahun_ajaran' => '2023/2024',
            'walikelas_id' => $waliKelas->id
        ])
        ->call('create')
        ->assertHasFormErrors(['nama_kelas' => 'unique']);
});

test('Admin dapat melihat daftar kelas', function() {
    // Arrange
    $waliKelas1 = User::factory()->create([
        'role' => 'walikelas'
    ]);

    $kelas1 = Kelas::create([
        'nama_kelas' => 'X IPA 3',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelas1->id
    ]);

    // Act & Assert
    Livewire::test(ListKelas::class)
        ->assertCanSeeTableRecords([$kelas1]);
});

test('Admin dapat memperbarui data kelas', function() {
    //Arrange
    $waliKelasLama = User::factory()->create([
        'role' => 'walikelas'
    ]);

    $kelasCanEdit = Kelas::create([
        'nama_kelas' => 'X IPA 5 New',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelasLama->id
    ]);

    $dataUpdate = [
        'nama_kelas' => 'X IPA 5 New Update',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelasLama->id
    ];

    //Act & Assert
    Livewire::test(EditKelas::class, ['record' => $kelasCanEdit->id])
        ->fillForm($dataUpdate)
        ->call('save')
        ->assertHasNoFormErrors();
    
    $this->assertDatabaseHas('kelas',[
        'id' => $kelasCanEdit->id,
        'nama_kelas' => 'X IPA 5 New Update',
        'walikelas_id' => $waliKelasLama->id
    ]);
});

test('Validasi data kelas tidak bisa di edit di Filament dengan data kosong', function() {
    //Arrange
    $waliKelas = User::factory()->create([
        'role' => 'walikelas'
    ]);

    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 6',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelas->id
    ]);

    $dataKelasKosong = [
        'nama_kelas' => '',
        'tahun_ajaran' => '',
        'walikelas_id' => ''
    ];

    //Act & Assert
    Livewire::test(EditKelas::class, ['record' => $kelas->id])
        ->fillForm($dataKelasKosong)
        ->call('save')
        ->assertHasFormErrors([
            'nama_kelas' => 'required',
            'tahun_ajaran' => 'required',
            'walikelas_id' => 'required'
        ]);
});

test('Admin dapat menghapus data kelas', function() {
    // Arrange
    $waliKelas = User::factory()->create([
        'role' => 'walikelas'
    ]);

    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 8',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => $waliKelas->id
    ]);

    //Act & Assert
    Livewire::test(EditKelas::class, ['record' => $kelas->id])
        ->callAction('delete')
        ->assertHasNoActionErrors();
    
    $this->assertDatabaseMissing('kelas',[
        'id' => $kelas->id
    ]);
});


