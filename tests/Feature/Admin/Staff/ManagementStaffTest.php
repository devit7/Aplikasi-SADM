<?php

it('has admin/staff/create page', function () {
    $response = $this->get('/admin/staff/create');

    $response->assertStatus(200);
});
