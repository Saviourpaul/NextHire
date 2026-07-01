<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Services\AdminDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AdminDashboardService $adminDashboardService,
    ) {}

    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isSuspended()) {
            return $this->logoutSuspendedUser($request);
        }

        if ($user->isPending()) {
            return view('account.pending-approval', [
                'user' => $user,
            ]);
        }

        return match ($user->role) {
            UserRole::Admin => view('admin.Dashboard', $this->adminDashboardService->getOverview($request)),
            UserRole::Employer => view('employer.Dashboard'),
            UserRole::Applicant => view('client.Dashboard'),
        };
    }

    public function pending(Request $request): View|RedirectResponse
    {
        if ($request->user()->isSuspended()) {
            return $this->logoutSuspendedUser($request);
        }

        if ($request->user()->isActive()) {
            return redirect()->route('dashboard');
        }

        return view('account.pending-approval', [
            'user' => $request->user(),
        ]);
    }

    private function logoutSuspendedUser(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'Your account has been suspended. Please contact support.');
    }
}
