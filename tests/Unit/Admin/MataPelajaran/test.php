test('Admin dapat melihat daftar mata pelajaran', function() {
    // Arrange
    $kelas = Kelas::create([
        'nama_kelas' => 'X IPA 8',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 6, 
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
        'nama_kelas' => 'X IPA 11',
        'tahun_ajaran' => '2023/2024',
        'walikelas_id' => 6,
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
