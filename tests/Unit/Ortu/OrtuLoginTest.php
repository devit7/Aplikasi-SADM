<?php

use App\Models\Siswa;

    test('Login sukses sebagai Ortu', function () {
    
        $response = $this->post('/ortu/login', [
            'nisn' => '1234567890',
            'nis' => '12345'
        ]);

        $response->assertRedirect(route('ortu.index'));
    });
    test('Login Gagal', function () {
    
        $response = $this->post('/ortu/login', [
            'nisn' => '1111111111',
            'nis' => '12345'
        ]);

        $response->assertRedirect(route('ortu.index'));
    });
?>