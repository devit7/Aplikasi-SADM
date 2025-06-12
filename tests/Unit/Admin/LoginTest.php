<?php
use App\Models\User;
use Livewire\Livewire;
use Filament\Pages\Auth\Login;


test('admin/login', function () {
    expect(true)->toBeTrue();
});

// ./vendor/bin/pest .\tests\Unit\Admin\LoginTest.php --filter="admin dapat login dengan kredensial yang valid"
test('admin dapat login dengan kredensial yang valid', function () {
    // Arrange
    /* $admin = User::factory()->create([
        'email' => 'admin@test.com',
        'password' => bcrypt('password123'),
        'role' => 'admin'
    ]); */

    // Act & Assert
    Livewire::test(Login::class)
        ->fillForm([
            'email' => 'admin@test.com',
            'password' => 'passwodwadd123',
        ])
        ->call('authenticate')
        ->assertHasNoFormErrors()
        ->assertRedirect('/admin');
});

// ./vendor/bin/pest .\tests\Unit\Admin\LoginTest.php --filter="admin tidak dapat login dengan email yang salah"
test('admin tidak dapat login dengan email yang salah', function () {
    // Arrange
    /* $admin = User::factory()->create([
        'email' => 'admin@test.com',
        'password' => bcrypt('password123'),
        'role' => 'admin'
    ]); */

    // Act & Assert
    Livewire::test(Login::class)
        ->fillForm([
            'email' => 'wrong@test.com',
            'password' => 'password123',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);
});

test('admin tidak dapat login dengan password yang salah', function () {
    // Arrange
    /* $admin = User::factory()->create([
        'email' => 'admin@test.com',
        'password' => bcrypt('password123'),
        'role' => 'admin'
    ]); */

    // Act & Assert
    Livewire::test(Login::class)
        ->fillForm([
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);
});

test('form login memerlukan email dan password', function () {
    // Act & Assert
    Livewire::test(Login::class)
        ->fillForm([
            'email' => '',
            'password' => '',
        ])
        ->call('authenticate')
        ->assertHasFormErrors([
            'email' => 'required',
            'password' => 'required'
        ]);
});

test('email harus dalam format yang valid', function () {
    // Act & Assert
    Livewire::test(Login::class)
        ->fillForm([
            'email' => 'invalid-email',
            'password' => 'password123',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);
});