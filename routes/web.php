<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jobs = Job::active()->latest()->take(3)->get();

    return view('Home', [
        'jobs' => $jobs,
    ]);
});

Route::get('find-jobs', function () {
    $jobs = Job::active()->latest()->paginate(12);

    return view('Jobs', [
        'jobs' => $jobs,
    ]);
})->name('jobs.public');

Route::get('job-details/{job}', [JobController::class, 'show'])->name('job-details');
Route::get('about', function () {
    return view('about');
});

Route::get('Dashboard', DashboardController::class)
    ->middleware('auth')
    ->name('dashboard');

Route::get('account/pending-approval', [DashboardController::class, 'pending'])
    ->middleware('auth')
    ->name('account.pending');

Route::middleware(['auth', 'active.account'])->group(function () {
    Route::get('applicants/{user}/profile', [ProfileController::class, 'showApplicant'])
        ->middleware('role:admin,employer')
        ->name('applicants.profile.show');

    Route::middleware('role:employer')->group(function () {
        Route::get('jobs', [JobController::class, 'index'])->name('jobs');
        Route::post('jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::put('jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('Employers', [UserManagementController::class, 'employers'])->name('Employers');
        Route::get('administrators', [UserManagementController::class, 'administrators'])->name('administrators');
        Route::get('applicants', [UserManagementController::class, 'applicants'])->name('applicants');
        Route::get('user-verification', [UserManagementController::class, 'approved'])->name('user-verification');
        Route::get('suspended-accounts', [UserManagementController::class, 'suspended'])->name('suspended-accounts');

        Route::post('admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
        Route::put('admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::patch('admin/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('admin.users.suspend');
        Route::patch('admin/users/{user}/activate', [UserManagementController::class, 'activate'])->name('admin.users.activate');
        Route::delete('admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('admin/users/{user}/password-reset', [UserManagementController::class, 'sendPasswordReset'])->name('admin.users.password-reset');

        Route::get('approved-jobs', fn () => view('admin/approved-jobs'))->name('approved-jobs');
        Route::get('rejected-jobs', fn () => view('admin/rejected-jobs'))->name('rejected-jobs');
        Route::get('pending-jobs', fn () => view('admin/pending-jobs'))->name('pending-jobs');
        Route::get('assessment-templates', fn () => view('admin/assessment-templates'))->name('assessment-templates');
        Route::get('interview-templates', fn () => view('admin/interview-templates'))->name('interview-templates');
        Route::get('email-templates', fn () => view('admin/email-templates'))->name('email-templates');
        Route::get('general-settings', fn () => view('admin/general-settings'))->name('general-settings');
        Route::get('email-configuration', fn () => view('admin/email-configuration'))->name('email-configuration');
        Route::get('notifications', fn () => view('admin/notifications'))->name('notifications');
        Route::get('permission-management', fn () => view('admin/permission-management'))->name('permission-management');
    });
});

Route::middleware(['auth', 'active.account'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
