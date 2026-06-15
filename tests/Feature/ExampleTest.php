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

it('returns the custom 404 page for unknown routes', function () {
    $response = $this->get('/unknown-route');

    $response->assertStatus(404);
    $response->assertViewIs('404');
    $response->assertSee('Page not found');
    $response->assertSee(route('home'), false);
});

it('renders the 404 back link from the previous page', function () {
    $previousUrl = url('/find-jobs');

    $response = $this->withHeaders([
        'referer' => $previousUrl,
    ])->get('/unknown-route');

    $response->assertStatus(404);
    $response->assertSee($previousUrl, false);
});
