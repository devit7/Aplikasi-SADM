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
        'nip' => '198012200012313011',
        'email' => 'budi.santoso@example.com',
        'password' => 'password123',
    ];

    // Act & Assert
    Livewire::test(CreateStaff::class)
        ->fillForm($dataStaff)
        ->call('create')
        ->assertHasNoFormErrors(); 
});