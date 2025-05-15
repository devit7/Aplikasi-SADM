<?php

it('has admin/walikelas/manajemenwalikelas page', function () {
    $response = $this->get('/admin/walikelas/manajemenwalikelas');

    $response->assertStatus(200);
});
