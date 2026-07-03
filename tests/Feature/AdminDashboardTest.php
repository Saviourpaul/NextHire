<?php

use App\Enums\ApplicationStatus;
use App\Models\ApplicationForm;
use App\Models\Job;
use App\Models\User;

it('renders admin dashboard with live recruitment metrics', function () {
    $admin = User::factory()->admin()->create();

    $employer = User::factory()->employer()->create([
        'created_at' => now()->startOfMonth()->addDay(),
    ]);

    $applicant = User::factory()->applicant()->create([
        'created_at' => now()->startOfMonth()->addDays(2),
    ]);

    $job = Job::factory()->create([
        'employer_id' => $employer->id,
        'created_at' => now()->startOfMonth()->addDays(3),
    ]);

    ApplicationForm::factory()->create([
        'job_id' => $job->id,
        'user_id' => $applicant->id,
        'status' => ApplicationStatus::Pending,
        'submitted_at' => now()->startOfMonth()->addDays(4),
    ]);

    ApplicationForm::factory()->approved($employer)->create([
        'job_id' => $job->id,
        'user_id' => User::factory()->applicant()->create()->id,
        'submitted_at' => now()->startOfMonth()->addDays(5),
    ]);

    ApplicationForm::factory()->rejected($employer)->create([
        'job_id' => $job->id,
        'user_id' => User::factory()->applicant()->create()->id,
        'submitted_at' => now()->startOfMonth()->addDays(6),
    ]);

    $this->actingAs($admin)
        ->get(route('dashboard', ['period' => 'this_month']))
        ->assertOk()
        ->assertSee('Total Applicants')
        ->assertSee('Total Employers')
        ->assertSee('Total Jobs Posted')
        ->assertSee('Total Applications')
        ->assertSee('Approved Candidates')
        ->assertSee('Rejected Candidates')
        ->assertSee('Jobs and Applicants Over Time')
        ->assertSee('Application Status')
        ->assertSee('Recent Registrations')
        ->assertSee('Recently Posted Jobs')
        ->assertSee('Latest Applications')
        ->assertSee($job->title)
        ->assertSee($applicant->email);
});

it('filters admin dashboard metrics by custom date range', function () {
    $admin = User::factory()->admin()->create();

    User::factory()->employer()->create([
        'created_at' => now()->subMonths(2),
    ]);

    User::factory()->employer()->create([
        'created_at' => now()->subDays(2),
    ]);

    $from = now()->subWeek()->toDateString();
    $to = now()->toDateString();

    $this->actingAs($admin)
        ->get(route('dashboard', [
            'period' => 'custom',
            'date_from' => $from,
            'date_to' => $to,
        ]))
        ->assertOk()
        ->assertSee('Recruitment insights for')
        ->assertSee('1', false);
});

it('does not expose admin dashboard metrics to non-admin users', function () {
    $employer = User::factory()->employer()->create();

    $this->actingAs($employer)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee('Jobs Posted Over Time');
});

it('auto-submits dashboard filter when a preset period is selected', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('id="period"', false)
        ->assertSee('value="today"', false)
        ->assertSee('value="this_week"', false)
        ->assertSee('value="this_month"', false)
        ->assertSee('value="this_year"', false)
        ->assertSee('value="custom"', false);
});
