<?php
// use function Pest\Laravel\{actingAs, get, post, delete};
use App\Models\WaliKelas;
use Livewire\Livewire;
use App\Filament\Resources\UsersResource\Pages\CreateUsers;
use App\Filament\Resources\UsersResource\Pages\EditUsers;
use App\Filament\Resources\UsersResource\Pages\ListUsers;
use App\Models\Kelas;

// ./vendor/bin/pest .\tests\Unit\Admin\WaliKelas\ManajemenWaliKelasTest.php --filter="Validasi data wali kelas saat ditambahkan di Filament"
test('Validasi data wali kelas saat ditambahkan di Filament', function () {
    //Arrange
    $dataWaliKelas = [
        'nip' => '135799753113579999',
        'name' => 'Wali Kelas Baru',
        'email' => 'walikelasbaru@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin',
        'tanggal_lahir' => '1999-01-01',
        'no_hp' => '085846374759',
        'alamat' => 'JL. rumah wali kelas baru',
        'password' => 'password'
    ];

    //Act & Assert
    Livewire::test(CreateUsers::class)
        ->fillForm($dataWaliKelas)
        ->call('create')
        ->assertHasNoInfolistActionErrors();
});

// ./vendor/bin/pest .\tests\Unit\Admin\WaliKelas\ManajemenWaliKelasTest.php --filter="Admin dapat menambahkan wali kelas baru"
test('Admin tidak dapat menambahkan wali kelas dengan NIP yang sudah ada', function () {
    //Arrange
    /* $existingWaliKelas = User::factory()->create([
        'nip' => '135799753113579911',
        'name' => 'Wali Kelas Baru',
        'email' => 'walikelasbaru11@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin',
        'tanggal_lahir' => '1999-11-11',
        'no_hp' => '085846374711',
        'alamat' => 'JL. rumah wali kelas baru 11',
        'password' => 'password11',
        'role' => 'walikelas'
    ]); */

    $dataWaliKelasDuplicate = [
        'nip' => '135799753113579999',
        'name' => 'Wali Kelas Duplicate',
        'email' => 'walikelasduplicate@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Surabaya',
        'tanggal_lahir' => '1990-05-15',
        'no_hp' => '081234567812',
        'alamat' => 'Jl. Contoh No.
         123',
        'password' => 'password12',
        'role' => 'walikelas'
    ];

    //Act & Assert
    Livewire::test(CreateUsers::class)
        ->fillForm($dataWaliKelasDuplicate)
        ->call('create')
        ->assertHasFormErrors(['nip' => 'unique']);
});

// ./vendor/bin/pest .\tests\Unit\Admin\WaliKelas\ManajemenWaliKelasTest.php --filter="Admin dapat memperbarui data wali kelas"
test('Admin dapat memperbarui data wali kelas', function () {
    //Arrange
    
    $dataUpdate = [
        'nip' => '135799753113571111',
        'name' => 'Wali Kelas Update',
        'email' => 'walikelasbaru@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin',
        'tanggal_lahir' => '1999-01-01',
        'no_hp' => '085846374759',
        'alamat' => 'JL. rumah wali kelas baru',
    ];
    
    //Act & Assert
    Livewire::test(EditUsers::class, ['record' => 9])
    ->fillForm($dataUpdate)
    ->call('save')
    ->assertHasNoFormErrors();
    
    $this->assertDatabaseHas('users', [
        'id' => 9,
        'name' => 'Wali Kelas Update',
        'email' => 'walikelasbaru@gmail.com'
    ]);
});


// ./vendor/bin/pest .\tests\Unit\Admin\WaliKelas\ManajemenWaliKelasTest.php --filter="Admin dapat menghapus data wali kelas"
test('Admin dapat menghapus data wali kelas', function () {
    //Act & Assert
    Livewire::test(EditUsers::class, ['record' => 8])
        ->callAction('delete')
        ->assertHasNoActionErrors();

    $this->assertDatabaseMissing('users', [
        'id' => 8
    ]);
});

