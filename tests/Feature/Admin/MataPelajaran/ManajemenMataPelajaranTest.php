<?php

it('has admin/matapelajaran/manajemenmatapelajaran page', function () {
    $response = $this->get('/admin/matapelajaran/manajemenmatapelajaran');

    $response->assertStatus(200);
});
