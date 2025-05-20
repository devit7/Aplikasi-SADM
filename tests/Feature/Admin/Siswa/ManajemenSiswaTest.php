<?php

it('has admin/siswa/manajemensiswa page', function () {
    $response = $this->get('/admin/siswa/manajemensiswa');

    $response->assertStatus(200);
});
