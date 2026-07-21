<?php

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;

it('lets admins browse search filter and sort all employer job postings', function () {
    $admin = User::factory()->admin()->create();
    $alphaEmployer = User::factory()->employer()->create([
        'first_name' => 'Ada',
        'last_name' => 'Recruiter',
        'email' => 'ada@example.com',
    ]);
    $betaEmployer = User::factory()->employer()->create([
        'first_name' => 'Bola',
        'last_name' => 'Hiring',
        'email' => 'bola@example.com',
    ]);

    $approved = Job::factory()->approved()->for($alphaEmployer, 'employer')->create([
        'title' => 'Civil Engineer',
        'company' => 'Acme Works',
        'category' => 'Engineering',
        'created_at' => now()->subDays(3),
    ]);

    $pending = Job::factory()->for($betaEmployer, 'employer')->create([
        'title' => 'Finance Analyst',
        'company' => 'Beta Finance',
        'category' => 'Finance',
        'created_at' => now()->subDay(),
    ]);

    $rejected = Job::factory()->rejected()->for($alphaEmployer, 'employer')->create([
        'title' => 'Clinic Administrator',
        'company' => 'Care Group',
        'category' => 'Healthcare',
        'created_at' => now()->subDays(2),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.jobs.index'))
        ->assertOk()
        ->assertSee('All Jobs')
        ->assertSee('Approved Jobs')
        ->assertSee('Pending Jobs')
        ->assertSee('Rejected Jobs')
        ->assertSee($approved->title)
        ->assertSee($pending->title)
        ->assertSee($rejected->title)
        ->assertSee($alphaEmployer->email)
        ->assertSee($betaEmployer->email);

    $this->actingAs($admin)
        ->get(route('pending-jobs'))
        ->assertOk()
        ->assertSee($pending->title)
        ->assertDontSee($approved->title)
        ->assertDontSee($rejected->title);

    $this->actingAs($admin)
        ->get(route('admin.jobs.index', ['search' => 'Bola']))
        ->assertOk()
        ->assertSee($pending->title)
        ->assertDontSee($approved->title);

    $this->actingAs($admin)
        ->get(route('admin.jobs.index', ['category' => 'Engineering']))
        ->assertOk()
        ->assertSee($approved->title)
        ->assertDontSee($pending->title);

    $this->actingAs($admin)
        ->get(route('admin.jobs.index', [
            'sort' => 'employer',
            'direction' => 'asc',
            'per_page' => 25,
        ]))
        ->assertOk()
        ->assertSee('Showing 1-3')
        ->assertSee('of 3');
});

it('lets admins review complete job details and change job status', function () {
    $admin = User::factory()->admin()->create();
    $employer = User::factory()->employer()->create([
        'first_name' => 'Chika',
        'last_name' => 'Employer',
        'email' => 'chika@example.com',
    ]);
    $job = Job::factory()->for($employer, 'employer')->create([
        'title' => 'Senior Nurse',
        'company' => 'Care Point',
        'category' => 'Healthcare',
        'description' => '<p>Review patient intake and lead ward operations.</p>',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.jobs.show', $job))
        ->assertOk()
        ->assertSee('Senior Nurse')
        ->assertSee('Care Point')
        ->assertSee('Healthcare')
        ->assertSee('chika@example.com')
        ->assertSee('Review patient intake and lead ward operations.')
        ->assertDontSee('<p>Review patient intake', false);

    $this->actingAs($admin)
        ->patch(route('admin.jobs.review', $job), [
            'status' => JobStatus::Approved->value,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($job->fresh()->status)->toBe(JobStatus::Approved);

    $this->get(route('jobs.public'))
        ->assertOk()
        ->assertSee('Senior Nurse');

    $this->actingAs($admin)
        ->patch(route('admin.jobs.review', $job), [
            'status' => JobStatus::Rejected->value,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($job->fresh()->status)->toBe(JobStatus::Rejected);
});

it('prevents non-admin users from managing jobs through admin routes', function () {
    $employer = User::factory()->employer()->create();
    $applicant = User::factory()->applicant()->create();
    $job = Job::factory()->for($employer, 'employer')->create();

    $this->actingAs($employer)
        ->get(route('admin.jobs.index'))
        ->assertForbidden();

    $this->actingAs($applicant)
        ->get(route('admin.jobs.show', $job))
        ->assertForbidden();

    $this->actingAs($employer)
        ->patch(route('admin.jobs.review', $job), [
            'status' => JobStatus::Approved->value,
        ])
        ->assertForbidden();

    expect($job->fresh()->status)->toBe(JobStatus::Pending);
});
