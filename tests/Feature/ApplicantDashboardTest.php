<?php

use App\Models\User;

test('applicant dashboard shows incomplete profile tracker', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Profile Completion')
        ->assertSee('0%')
        ->assertSee('Date of birth')
        ->assertSee('Phone number');
});

test('applicant dashboard shows complete profile tracker', function () {
    $user = User::factory()->completeApplicantProfile()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Profile Completion')
        ->assertSee('100%')
        ->assertSee('Complete');
});

test('user model calculates applicant profile completion', function () {
    $user = User::factory()->create([
        'phone' => '+2348012345678',
        'address' => '12 Market Road',
    ]);

    expect($user->missingApplicantProfileFields())->toHaveKeys([
        'profile_image_path',
        'date_of_birth',
        'country',
        'state',
        'city',
        'zipcode',
    ])
        ->and($user->applicantProfileCompletionPercentage())->toBe(25)
        ->and($user->hasCompletedApplicantProfile())->toBeFalse()
        ->and($user->profileImageUrl())->toContain('avatar-14.jpg');

    $completeUser = User::factory()->completeApplicantProfile()->make();

    expect($completeUser->applicantProfileCompletionPercentage())->toBe(100)
        ->and($completeUser->hasCompletedApplicantProfile())->toBeTrue();
});
