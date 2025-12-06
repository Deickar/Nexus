<?php

test('Se encontro las Vista la respuesta fue exitosa', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
