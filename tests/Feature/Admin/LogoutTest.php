<?php

it('has admin/logout page', function () {
    $response = $this->get('/admin/logout');

    $response->assertStatus(200);
});
