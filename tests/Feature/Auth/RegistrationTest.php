<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Job;
use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register as active applicants', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'username' => 'test-user',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('email', 'test@example.com')->firstOrFail();

    expect($user->role)->toBe(UserRole::Applicant)
        ->and($user->status)->toBe(UserStatus::Active)
        ->and($user->approved_at)->not->toBeNull();
});

test('registration redirects applicants back to an intended job application', function () {
    $job = Job::factory()->create();

    $response = $this
        ->withSession(['url.intended' => route('applications.create', $job)])
        ->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'test-user',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('applications.create', $job));
});

test('active applicants can access their dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Applicant Dashboard');
});
