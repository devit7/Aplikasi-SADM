<?php

it('has admin/login page', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});
