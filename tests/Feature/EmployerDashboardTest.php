<?php

use App\Enums\ApplicationStatus;
use App\Models\ApplicationForm;
use App\Models\Job;
use App\Models\User;

it('renders an employer dashboard scoped to the authenticated employer', function () {
    $employer = User::factory()->employer()->create();
    $otherEmployer = User::factory()->employer()->create();

    $ownJob = Job::factory()->create([
        'employer_id' => $employer->id,
        'title' => 'Senior Laravel Developer',
        'created_at' => now()->startOfMonth()->addDays(1),
    ]);

    $otherJob = Job::factory()->create([
        'employer_id' => $otherEmployer->id,
        'title' => 'Other Employer Job',
        'created_at' => now()->startOfMonth()->addDays(2),
    ]);

    $applicant = User::factory()->applicant()->create();

    ApplicationForm::factory()->create([
        'job_id' => $ownJob->id,
        'user_id' => $applicant->id,
        'status' => ApplicationStatus::Pending,
        'submitted_at' => now()->startOfMonth()->addDays(3),
    ]);

    ApplicationForm::factory()->approved($employer)->create([
        'job_id' => $ownJob->id,
        'user_id' => User::factory()->applicant()->create()->id,
        'submitted_at' => now()->startOfMonth()->addDays(4),
    ]);

    ApplicationForm::factory()->rejected($employer)->create([
        'job_id' => $otherJob->id,
        'user_id' => User::factory()->applicant()->create()->id,
        'submitted_at' => now()->startOfMonth()->addDays(5),
    ]);

    $this->actingAs($employer)
        ->get(route('dashboard', ['period' => 'this_month']))
        ->assertOk()
        ->assertSee('Total Jobs Posted')
        ->assertSee('Total Applicants')
        ->assertSee('Total Applications')
        ->assertSee('Approved Candidates')
        ->assertSee('Rejected Candidates')
        ->assertSee('Pending Applications')
        ->assertSee('Applications Received Over Time')
        ->assertSee('Jobs Posted Over Time')
        ->assertSee('Application Status')
        ->assertSee('Most Applied-To Jobs')
        ->assertSee('Recent Job Applications')
        ->assertSee($ownJob->title)
        ->assertDontSee($otherJob->title);
});
