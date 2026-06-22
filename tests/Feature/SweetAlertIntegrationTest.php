<?php

use App\Models\Job;
use App\Models\User;

it('renders sweetalert assets, flash payloads, and auth confirmations', function () {
    $this->withSession(['success' => 'Welcome back.'])
        ->get(route('login'))
        ->assertOk()
        ->assertSee('window.NexHireAlerts', false)
        ->assertSee('Welcome back.', false)
        ->assertSee('assets/js/sweetalert.js', false)
        ->assertSee('assets/js/app-alerts.js', false)
        ->assertSee('data-confirm-title="Login now?"', false);
});

it('marks job and user management mutations for sweetalert confirmation', function () {
    $employer = User::factory()->employer()->create();
    $job = Job::factory()->for($employer, 'employer')->create();

    $this->actingAs($employer)
        ->get(route('jobs'))
        ->assertOk()
        ->assertSee('data-confirm-title="Create job?"', false)
        ->assertSee('data-confirm-title="Update job?"', false)
        ->assertSee('data-confirm-title="Delete job?"', false)
        ->assertSee($job->title);

    $admin = User::factory()->admin()->create();
    User::factory()->create();

    $this->actingAs($admin)
        ->get(route('applicants'))
        ->assertOk()
        ->assertSee('data-confirm-title="Create user?"', false)
        ->assertSee('data-confirm-title="Suspend user?"', false)
        ->assertSee('data-confirm-title="Delete user?"', false);
});
