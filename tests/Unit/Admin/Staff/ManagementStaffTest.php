<?php

use App\Models\User;
use App\Models\Staff;
use Livewire\Livewire;
use Carbon\Carbon;
use App\Filament\Resources\StaffResource\Pages\CreateStaff;
use App\Filament\Resources\StaffResource\Pages\EditStaff;
use App\Filament\Resources\StaffResource\Pages\ListStaff;


test('Tambah staff berhasil tanpa error', function () {
    // Arrange
    $dataStaff = [
        'nama' => 'Danu kusuma',
        'nip' => '19801220001231411',
        'email' => 'danuku99@gmail.com',
        'password' => 'password123',
    ];

    // Act & Assert
    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasNoFormErrors(); 
});

test('Tambah Staff gagal karena nama kosong', function () {
    $dataStaff = [
        'nama' => '',
        'nip' => '198012200012313011',
        'email' => 'budi.santoso@example.com',
        'password' => 'password123',
    ];

    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasNoFormErrors();
});

test('Edit staff berhasil tanpa error', function () {
    $staff = Staff::create([
        'nama' => 'WahyurinataAja',
        'nip' => '198012200012399039',
        'email' => 'danu.wijaya14@example.com',
        'password' => 'password123',
    ]);

    $updatedData = [
        'nama' => 'Danu Kusuma Wijaya',
        'nip' => '198012200012399018',
        'email' => 'danu.wijaya77@example.com',
        'password' => 'newpassword123',
    ];

    Livewire::test(EditStaff::class, ['record' => $staff->id])
        ->fillForm($updatedData)
        ->call('save')
        ->assertHasNoFormErrors();

});

test('Hapus staff berhasil ', function () {
    // Membuat staff secara manual
    $staff = Staff::create([
        'nama' => 'Danu Renata',
        'nip' => '198012200012345678',
        'email' => 'danukun@example.com',
        'password' => 'password123',
    ]);

    // Menjalankan test Livewire
    Livewire::test(EditStaff::class, ['record' => $staff->id])
        ->callAction('delete')
        ->assertHasNoActionErrors();
    
    $this->assertDatabaseMissing('staff',[
        'id' => $staff->id
    ]);
});


