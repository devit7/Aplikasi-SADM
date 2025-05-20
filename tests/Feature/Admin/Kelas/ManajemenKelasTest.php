<?php

it('has admin/kelas/manajemenkelas page', function () {
    $response = $this->get('/admin/kelas/manajemenkelas');

    $response->assertStatus(200);
});
