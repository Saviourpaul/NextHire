<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;

it('casts roles and statuses and exposes transition helpers', function () {
    $user = User::factory()->pending()->create();

    expect($user->role)->toBe(UserRole::Applicant)
        ->and($user->status)->toBe(UserStatus::Pending)
        ->and($user->isApplicant())->toBeTrue()
        ->and($user->isPending())->toBeTrue();

    $user->activate();

    expect($user->fresh())
        ->status->toBe(UserStatus::Active)
        ->approved_at->not->toBeNull()
        ->suspended_at->toBeNull();

    $user->suspend();

    expect($user->fresh())
        ->status->toBe(UserStatus::Suspended)
        ->suspended_at->not->toBeNull();
});

it('allows only admins to access admin user management', function () {
    $admin = User::factory()->admin()->create();
    $employer = User::factory()->employer()->create();
    $applicant = User::factory()->create();

    $this->actingAs($admin)
        ->get(route('applicants'))
        ->assertOk();

    $this->actingAs($employer)
        ->get(route('applicants'))
        ->assertForbidden();

    $this->actingAs($applicant)
        ->get(route('applicants'))
        ->assertForbidden();
});

it('redirects pending users away from active-only routes', function () {
    $pendingEmployer = User::factory()->employer()->pending()->create();

    $this->actingAs($pendingEmployer)
        ->get(route('jobs'))
        ->assertRedirect(route('account.pending'));
});

it('logs suspended sessions out of protected routes', function () {
    $suspendedAdmin = User::factory()->admin()->suspended()->create();

    $this->actingAs($suspendedAdmin)
        ->get(route('applicants'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});
