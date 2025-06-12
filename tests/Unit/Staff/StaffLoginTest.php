<?php

use App\Models\Staff;

    test('Login sukses bolo sebagai Staff', function () {
    
        $response = $this->post('/staff/login', [
            'nip' => '198012200012313010',
            'password' => 'danu12345'
        ]);

        $response->assertRedirect(route('staff.dashboard'));
    });
?>