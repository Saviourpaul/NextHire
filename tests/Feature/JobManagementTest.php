<?php

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('allows an authenticated employer to manage jobs', function () {
    $employer = User::factory()->employer()->create();

    $this->actingAs($employer)
        ->get(route('jobs'))
        ->assertOk()
        ->assertSee('Jobs');

    $description = '<p>Build and maintain <strong>Laravel</strong> services.</p><ul><li>Own APIs</li></ul>';

    $createData = [
        'title' => 'Backend Developer',
        'description' => $description,
        'company' => 'Nexhire Labs',
        'category' => 'Technology',
        'logo' => 'admin/assets/img/company/img-10.png',
        'start_date' => '2026-06-01',
        'due_date' => '2026-06-30',
        'status' => JobStatus::Approved->value,
    ];

    $this->actingAs($employer)
        ->post(route('jobs.store'), $createData)
        ->assertRedirect(route('jobs'));

    $job = Job::query()->firstOrFail();

    expect($job->employer_id)->toBe($employer->id);
    expect($job->description)->toBe($description);
    expect($job->status)->toBe(JobStatus::Pending);
    $this->assertDatabaseHas('job_posts', [
        'id' => $job->id,
        'title' => 'Backend Developer',
        'company' => 'Nexhire Labs',
        'category' => 'Technology',
        'status' => JobStatus::Pending->value,
    ]);

    $this->actingAs($employer)
        ->get(route('jobs'))
        ->assertOk()
        ->assertSee('Backend Developer')
        ->assertSee('Nexhire Labs');

    $job->forceFill(['status' => JobStatus::Approved])->save();

    $this->get(route('job-details', $job->fresh()))
        ->assertOk()
        ->assertSee('Build and maintain Laravel services.')
        ->assertSee('Own APIs')
        ->assertDontSee($description, false)
        ->assertDontSee('<strong>Laravel</strong>', false);

    $this->actingAs($employer)
        ->put(route('jobs.update', $job), [
            ...$createData,
            'title' => 'Senior Backend Developer',
            'status' => JobStatus::Approved->value,
        ])
        ->assertRedirect(route('jobs'));

    expect($job->fresh())
        ->title->toBe('Senior Backend Developer')
        ->status->toBe(JobStatus::Pending);

    $this->actingAs($employer)
        ->delete(route('jobs.destroy', $job))
        ->assertRedirect(route('jobs'));

    $this->assertDatabaseMissing('job_posts', [
        'id' => $job->id,
    ]);
});

it('prevents employers from changing another employers jobs', function () {
    $owner = User::factory()->employer()->create();
    $otherEmployer = User::factory()->employer()->create();
    $job = $owner->jobs()->create([
        'title' => 'Frontend Developer',
        'description' => 'Build polished interfaces.',
        'company' => 'Nexhire Labs',
        'category' => 'Technology',
        'start_date' => '2026-06-01',
        'due_date' => '2026-06-30',
        'status' => JobStatus::Approved,
    ]);

    $this->actingAs($otherEmployer)
        ->put(route('jobs.update', $job), [
            'title' => 'Changed Title',
            'description' => 'Changed description.',
            'company' => 'Changed Company',
            'category' => 'Technology',
            'start_date' => '2026-06-01',
            'due_date' => '2026-06-30',
            'status' => JobStatus::Rejected->value,
        ])
        ->assertForbidden();

    expect($job->fresh()->title)->toBe('Frontend Developer');
});

it('rejects svg job logo uploads', function () {
    Storage::fake('public');

    $employer = User::factory()->employer()->create();

    $this->actingAs($employer)
        ->post(route('jobs.store'), [
            'title' => 'Backend Developer',
            'description' => 'Build secure services.',
            'company' => 'Nexhire Labs',
            'category' => 'Technology',
            'logo' => UploadedFile::fake()->create('logo.svg', 1, 'image/svg+xml'),
            'start_date' => '2026-06-01',
            'due_date' => '2026-06-30',
            'status' => JobStatus::Approved->value,
        ])
        ->assertSessionHasErrors('logo');

    expect(Job::count())->toBe(0);
});

it('prevents applicants from managing jobs', function () {
    $applicant = User::factory()->create();

    $this->actingAs($applicant)
        ->get(route('jobs'))
        ->assertForbidden();
});
