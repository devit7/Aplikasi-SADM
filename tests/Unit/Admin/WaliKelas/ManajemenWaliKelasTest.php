<?php
// use function Pest\Laravel\{actingAs, get, post, delete};
use App\Models\User;
use Livewire\Livewire;
use App\Filament\Resources\UsersResource\Pages\CreateUsers;
use App\Filament\Resources\UsersResource\Pages\EditUsers;


test('Validasi data wali kelas saat ditambahkan di Filmanet', function() {
    //Arrange
    $dataWaliKelas = [
        'nip' => '135799753113579999',
        'name' => 'Wali Kelas Baru',
        'email' => 'walikelasbaru12@gmail.com',
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