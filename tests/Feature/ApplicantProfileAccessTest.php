<?php

use App\Models\User;

test('admins and employers can view active applicant profiles read only', function () {
    $admin = User::factory()->admin()->create();
    $employer = User::factory()->employer()->create();
    $applicant = User::factory()->completeApplicantProfile()->create();

    $this->actingAs($admin)
        ->get(route('applicants.profile.show', $applicant))
        ->assertOk()
        ->assertSee('Applicant Profile')
        ->assertSee('This profile is read-only.');

    $this->actingAs($employer)
        ->get(route('applicants.profile.show', $applicant))
        ->assertOk()
        ->assertSee($applicant->email);
});

test('applicants can not view other applicant profiles through the read only route', function () {
    $viewer = User::factory()->create();
    $applicant = User::factory()->completeApplicantProfile()->create();

    $this->actingAs($viewer)
        ->get(route('applicants.profile.show', $applicant))
        ->assertForbidden();
});

test('non applicant profile ids are not shown through applicant profile route', function () {
    $admin = User::factory()->admin()->create();
    $employer = User::factory()->employer()->create();

    $this->actingAs($admin)
        ->get(route('applicants.profile.show', $employer))
        ->assertNotFound();
});

test('employers can not view suspended applicant profiles', function () {
    $employer = User::factory()->employer()->create();
    $applicant = User::factory()->completeApplicantProfile()->suspended()->create();

    $this->actingAs($employer)
        ->get(route('applicants.profile.show', $applicant))
        ->assertForbidden();
});
