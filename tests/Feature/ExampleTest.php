<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('returns a successful response for public jobs page', function () {
    $response = $this->get(route('jobs.public'));

    $response->assertStatus(200);
    $response->assertSee('All Jobs');
});
