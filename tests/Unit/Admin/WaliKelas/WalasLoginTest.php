<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('NIP wajib diisi', function () {
    $response = $this->post(route('loginWalas'), [
        'password' => 'password123'
    ]);

    $response->assertSessionHasErrors(['nip']);
});

test('NIP harus 18 digit', function () {
    $response = $this->post(route('loginWalas'), [
        'nip' => '123456789', // kurang dari 18 digit
        'password' => 'password123'
    ]);

    $response->assertSessionHasErrors(['nip']);
});

test('Password wajib diisi', function () {
    $response = $this->post(route('loginWalas'), [
        'nip' => '123456789012345678'
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('NIP dan password tidak valid', function () {
    $response = $this->post(route('loginWalas'), [
        'nip' => '123456789012345678',
        'password' => 'salah'
    ]);

    $response->assertSessionHasErrors(['login']);
});

test('Berhasil login tetapi bukan wali kelas', function () {
    $user = User::factory()->create([
        'nip' => '123456789012345678',
        'password' => Hash::make('password123'),
        'role' => 'admin', // bukan walikelas
    ]);

    $response = $this->post(route('loginWalas'), [
        'nip' => '123456789012345678',
        'password' => 'password123'
    ]);

    $response->assertSessionHasErrors(['login']);
    $this->assertGuest();
});

test('Login sukses sebagai walikelas', function () {
    $user = User::factory()->create([
        'nip' => '123456789012345678',
        'password' => Hash::make('password123'),
        'role' => 'walikelas',
    ]);

    $response = $this->post(route('loginWalas'), [
        'nip' => '123456789012345678',
        'password' => 'password123'
    ]);

    $response->assertRedirect(route('walas.index'));
    $this->assertAuthenticatedAs($user);
});
