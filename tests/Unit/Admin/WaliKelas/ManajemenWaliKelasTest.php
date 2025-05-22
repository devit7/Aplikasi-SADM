<?php
// use function Pest\Laravel\{actingAs, get, post, delete};
use App\Models\User;
use Livewire\Livewire;
use App\Filament\Resources\UsersResource\Pages\CreateUsers;
use App\Filament\Resources\UsersResource\Pages\EditUsers;
use App\Filament\Resources\UsersResource\Pages\ListUsers;

test('Validasi data wali kelas saat ditambahkan di Filament', function() {
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
        'password' => 'password',
        'role' => 'walikelas'
    ];

    //Act & Assert
    Livewire::test(CreateUsers::class)
        ->fillForm($dataWaliKelas)
        ->call('create')
        ->assertHasNoInfolistActionErrors();
});

test('Admin tidak dapat menambahkan wali kelas dengan NIP yang sudah ada', function() {
    //Arrange
    $existingWaliKelas = User::factory()->create([
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
    ]);

    $dataWaliKelasDuplicate = [
        'nip' => '135799753113579911', // NIP yang sama dengan wali kelas yang sudah ada
        'name' => 'Wali Kelas Duplicate',
        'email' => 'walikelasduplicate@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Surabaya',
        'tanggal_lahir' => '1990-05-15',
        'no_hp' => '081234567812',
        'alamat' => 'Jl. Contoh No. 123',
        'password' => 'password12',
        'role' => 'walikelas'
    ];

    //Act & Assert
    Livewire::test(CreateUsers::class)
    ->fillForm($dataWaliKelasDuplicate)
    ->call('create')
    ->assertHasFormErrors(['nip' => 'unique']);
});

test('Admin dapat melihat daftar wali kelas', function() {
    // Arrange
    $waliKelas1 = User::factory()->create([
        'nip' => '1357997531135001',
        'name' => 'Wali Kelas Test 1',
        'email' => 'walikelas1@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin1',
        'tanggal_lahir' => '1999-01-01',
        'no_hp' => '085846374755',
        'alamat' => 'JL. rumah wali kelas 1',
        'password' => 'password1',
        'role' => 'walikelas'
    ]);

    $waliKelas2 = User::factory()->create([
        'nip' => '1357997531135002',
        'name' => 'Wali Kelas Test 2',
        'email' => 'walikelas2@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin2',
        'tanggal_lahir' => '1999-02-02',
        'no_hp' => '085846374756',
        'alamat' => 'JL. rumah wali kelas 2',
        'password' => 'password2',
        'role' => 'walikelas'
    ]);

    // Act & Assert
    Livewire::test(ListUsers::class)
        ->assertCanSeeTableRecords([$waliKelas1, $waliKelas2]);
        // ->assertTableRecordsCount(2)
        // ->assertCanSeeTableRecords(function($query) {
        //     return $query->where('role', 'walikelas');
        // }, 2);
});

test('Admin dapat memperbarui data wali kelas', function() {
    //Arrange
    $waliKelasCanEdit = User::factory()->create([
        'nip' => '135799753113501010',
        'name' => 'Wali Kelas Can Edit',
        'email' => 'walikelascanedit@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Surabaya',
        'tanggal_lahir' => '1999-01-01',
        'no_hp' => '085846374769',
        'alamat' => 'JL. rumah wali kelas can edit',
        'password' => 'password-can-edit',
        'role' => 'walikelas'
    ]);

    $dataUpdate = [
        'nip' => '135799753113501010', // NIP tetap sama
        'name' => 'Wali Kelas Update',
        'email' => 'walikelasupdate@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '1985-10-10',
        'no_hp' => '089876543210',
        'alamat' => 'Jl. Wali Kelas Update Baru No. 789',
    ];

    //Act & Assert
    Livewire::test(EditUsers::class, ['record' => $waliKelasCanEdit->id])
        ->fillForm($dataUpdate)
        ->call('save')
        ->assertHasNoFormErrors();
    
    $this->assertDatabaseHas('users',[
        'id' => $waliKelasCanEdit->id,
        'name' => 'Wali Kelas Update',
        'email' => 'walikelasupdate@gmail.com'
    ]);
});

test('Validasi data wali kelas tidak bisa di edit di Filament', function() {
    //Arrange
    $user = User::factory()->create([
        'nip' => '135799753113579929',
        'name' => 'Wali Kelas Baru 222222',
        'email' => 'walikelasbaru222222@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin',
        'tanggal_lahir' => '1998-01-01',
        'no_hp' => '085846374757',
        'alamat' => 'JL. rumah wali kelas baru 2',
        'password' => 'password2',
        'role' => 'walikelas'
    ]);

    $dataWaliKelas = [
        'nip' => '',
        'name' => '',
        'email' => '',
    ];

    //Act & Assert
    livewire::test(EditUsers::class, ['record' => $user->id])
        ->fillForm($dataWaliKelas)
        ->call('save')
        ->assertHasFormErrors([
            'nip' => 'required',
            'name' => 'required',
            'email' => 'required'
        ]);
});

test('Admin dapat menghapus data wali kelas', function() {
    // Arrange
    $waliKelas = User::factory()->create([
        'nip' => '135799753113500303',
        'name' => 'Wali Kelas Test Hapus',
        'email' => 'walikelashapus@gmail.com',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Banjarmasin',
        'tanggal_lahir' => '1998-01-01',
        'no_hp' => '085846374753',
        'alamat' => 'JL. rumah wali kelas hapus',
        'password' => 'password-hapus',
        'role' => 'walikelas'
    ]);

    //Act & Assert
    Livewire::test(EditUsers::class, ['record' => $waliKelas->id])
        ->callAction('delete')
        ->assertHasNoActionErrors();
    
    $this->assertDatabaseMissing('users',[
        'id' => $waliKelas->id
    ]);
});