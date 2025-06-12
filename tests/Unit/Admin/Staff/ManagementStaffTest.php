<?php

use App\Models\User;
use App\Models\Staff;
use Livewire\Livewire;
use Carbon\Carbon;
use App\Filament\Resources\StaffResource\Pages\CreateStaff;
use App\Filament\Resources\StaffResource\Pages\EditStaff;
use App\Filament\Resources\StaffResource\Pages\ListStaff;

test('Validasi form staff berhasil tanpa error', function () {
    // Arrange
    $dataStaff = [
        'nama' => 'Budi Santoso',
        'nip' => '198012200012313090',
        'email' => 'budigaming@gmail.com',
        'password' => 'password123',
    ];

    // Act & Assert
    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasNoFormErrors(); 
});

test('Validasi gagal karena nama kosong', function () {
    $dataStaff = [
        'nama' => '',
        'nip' => '198012200012313011',
        'email' => 'budi.santoso@example.com',
        'password' => 'password123',
    ];

    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasFormErrors(['nama' => 'required']);
});


test('Validasi gagal karena email tidak valid', function () {
    $dataStaff = [
        'nama' => 'Budi Santoso',
        'nip' => '198012200012313011',
        'email' => 'budisantosoexample.com',
        'password' => 'password123',
    ];

    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasFormErrors(['email' => 'email']);
});

test('Validasi gagal karena password kurang dari 6 karakter', function () {
    $dataStaff = [
        'nama' => 'Budi Santoso',
        'nip' => '198012200012313011',
        'email' => 'budi.santoso@example.com',
        'password' => '123',
    ];

    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasFormErrors(['password' => 'min']);
});
