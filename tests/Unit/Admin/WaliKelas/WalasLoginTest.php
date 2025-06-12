<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;


test('NIP wajib diisi', function () {
    $response = $this->post(route('loginWalas'), [
        'password' => 'password123'
    ]);

    $response->assertSessionHasErrors(['nip']);
});

test('NIP harus 18 digit', function () {
    $response = $this->post(route('loginWalas'), [
        'nip' => '12346', // kurang dari 18 digit
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


test('Login sukses sebagai walikelas', function () {
 

    $response = $this->post(route('loginWalas'), [
        'nip' => '123456789012345578',
        'password' => 'password123'
    ]);

    $response->assertRedirect(route('walas.index'));
});
