<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use App\Enums\UserRole;
use App\Models\ApplicationForm;
use App\Models\Job;
use App\Models\User;
use App\Support\AdminDashboardDateRange;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    /**
     * @return array<string, mixed>
     */
    public function getOverview(Request $request): array
    {
        $dateRange = AdminDashboardDateRange::fromRequest($request);

        return [
            'dateRange' => $dateRange,
            'filterValues' => $dateRange->filterValues(),
            'metrics' => $this->metrics($dateRange),
            'charts' => [
                'jobsOverTime' => $this->jobsOverTime($dateRange),
                'applicationStatus' => $this->applicationStatusDistribution($dateRange),
                'userRegistrations' => $this->userRegistrations($dateRange),
                'mostAppliedJobs' => $this->mostAppliedJobs($dateRange),
            ],
            'recentActivities' => $this->recentActivities(),
        ];
    }

    /**
     * @return array<string, int>
     */
    private function metrics(AdminDashboardDateRange $dateRange): array
    {
        $applicationCounts = ApplicationForm::query()
            ->whereBetween('submitted_at', [$dateRange->start, $dateRange->end])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'total_applicants' => $this->countUsersByRole(UserRole::Applicant, $dateRange),
            'total_employers' => $this->countUsersByRole(UserRole::Employer, $dateRange),
            'total_jobs' => Job::query()
                ->whereBetween('created_at', [$dateRange->start, $dateRange->end])
                ->count(),
            'total_applications' => (int) $applicationCounts->sum(),
            'approved_candidates' => (int) ($applicationCounts[ApplicationStatus::Approved->value] ?? 0),
            'rejected_candidates' => (int) ($applicationCounts[ApplicationStatus::Rejected->value] ?? 0),
            'pending_candidates' => (int) ($applicationCounts[ApplicationStatus::Pending->value] ?? 0),
        ];
    }

    private function countUsersByRole(UserRole $role, AdminDashboardDateRange $dateRange): int
    {
        return User::query()
            ->role($role)
            ->whereBetween('created_at', [$dateRange->start, $dateRange->end])
            ->count();
    }

    /**
     * @return array<string, mixed>
     */
    private function jobsOverTime(AdminDashboardDateRange $dateRange): array
    {
        $interval = $this->chartInterval($dateRange);
        $counts = $this->groupedCounts(
            Job::query()->whereBetween('created_at', [$dateRange->start, $dateRange->end]),
            'created_at',
            $interval,
        );

        return $this->buildTimeSeries($dateRange, $interval, $counts, 'Jobs Posted');
    }

    /**
     * @return array<string, mixed>
     */
    private function applicationStatusDistribution(AdminDashboardDateRange $dateRange): array
    {
        $counts = ApplicationForm::query()
            ->whereBetween('submitted_at', [$dateRange->start, $dateRange->end])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = [];
        $series = [];
        $colors = [];

        foreach (ApplicationStatus::cases() as $status) {
            $labels[] = $status->label();
            $series[] = (int) ($counts[$status->value] ?? 0);
            $colors[] = match ($status) {
                ApplicationStatus::Pending => '#ffc107',
                ApplicationStatus::Approved => '#28a745',
                ApplicationStatus::Rejected => '#dc3545',
            };
        }

        return [
            'labels' => $labels,
            'series' => $series,
            'colors' => $colors,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function userRegistrations(AdminDashboardDateRange $dateRange): array
    {
        $interval = $this->chartInterval($dateRange);

        $applicantCounts = $this->groupedCounts(
            User::query()
                ->role(UserRole::Applicant)
                ->whereBetween('created_at', [$dateRange->start, $dateRange->end]),
            'created_at',
            $interval,
        );

        $employerCounts = $this->groupedCounts(
            User::query()
                ->role(UserRole::Employer)
                ->whereBetween('created_at', [$dateRange->start, $dateRange->end]),
            'created_at',
            $interval,
        );

        $categories = [];
        $applicantSeries = [];
        $employerSeries = [];

        foreach ($this->periodBuckets($dateRange, $interval) as $bucket) {
            $categories[] = $bucket['label'];
            $applicantSeries[] = $applicantCounts[$bucket['key']] ?? 0;
            $employerSeries[] = $employerCounts[$bucket['key']] ?? 0;
        }

        return [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Applicants',
                    'data' => $applicantSeries,
                ],
                [
                    'name' => 'Employers',
                    'data' => $employerSeries,
                ],
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function mostAppliedJobs(AdminDashboardDateRange $dateRange): array
    {
        $start = $dateRange->start;
        $end = $dateRange->end;

        return Job::query()
            ->select(['job_posts.id', 'job_posts.title', 'job_posts.company'])
            ->leftJoin('application_forms', function ($join) use ($start, $end): void {
                $join->on('job_posts.id', '=', 'application_forms.job_id')
                    ->whereBetween('application_forms.submitted_at', [$start, $end]);
            })
            ->groupBy('job_posts.id', 'job_posts.title', 'job_posts.company')
            ->selectRaw('COUNT(application_forms.id) as applications_count')
            ->having('applications_count', '>', 0)
            ->orderByDesc('applications_count')
            ->limit(8)
            ->get()
            ->map(fn (Job $job): array => [
                'title' => $job->title,
                'company' => $job->company,
                'applications_count' => (int) $job->applications_count,
            ])
            ->all();
    }

    /**
     * @return array<string, Collection<int, mixed>>
     */
    private function recentActivities(): array
    {
        return [
            'users' => User::query()
                ->whereIn('role', [UserRole::Applicant->value, UserRole::Employer->value])
                ->latest()
                ->limit(5)
                ->get(['id', 'first_name', 'last_name', 'email', 'role', 'created_at']),
            'jobs' => Job::query()
                ->latest()
                ->limit(5)
                ->get(['id', 'title', 'company', 'employer_id', 'status', 'created_at']),
            'applications' => ApplicationForm::query()
                ->with(['job:id,title', 'applicant:id,first_name,last_name'])
                ->latest('submitted_at')
                ->limit(5)
                ->get(['id', 'reference', 'job_id', 'user_id', 'status', 'submitted_at']),
        ];
    }

    /**
     * @param  Builder<Model>  $query
     * @return array<string, int>
     */
    private function groupedCounts(Builder $query, string $column, string $interval): array
    {
        $expression = $this->periodExpression($column, $interval);

        return $query
            ->selectRaw("{$expression} as period_key, COUNT(*) as total")
            ->groupBy('period_key')
            ->orderBy('period_key')
            ->pluck('total', 'period_key')
            ->map(fn ($total): int => (int) $total)
            ->all();
    }

    /**
     * @param  array<string, int>  $counts
     * @return array<string, mixed>
     */
    private function buildTimeSeries(
        AdminDashboardDateRange $dateRange,
        string $interval,
        array $counts,
        string $label,
    ): array {
        $categories = [];
        $series = [];

        foreach ($this->periodBuckets($dateRange, $interval) as $bucket) {
            $categories[] = $bucket['label'];
            $series[] = $counts[$bucket['key']] ?? 0;
        }

        return [
            'label' => $label,
            'categories' => $categories,
            'series' => $series,
        ];
    }

    /**
     * @return list<array{key: string, label: string}>
     */
    private function periodBuckets(AdminDashboardDateRange $dateRange, string $interval): array
    {
        $buckets = [];

        if ($interval === 'month') {
            $period = CarbonPeriod::create(
                $dateRange->start->copy()->startOfMonth(),
                '1 month',
                $dateRange->end->copy()->startOfMonth(),
            );

            foreach ($period as $date) {
                /** @var Carbon $date */
                $buckets[] = [
                    'key' => $date->format('Y-m'),
                    'label' => $date->format('M Y'),
                ];
            }

            return $buckets;
        }

        $period = CarbonPeriod::create(
            $dateRange->start->copy()->startOfDay(),
            '1 day',
            $dateRange->end->copy()->startOfDay(),
        );

        foreach ($period as $date) {
            /** @var Carbon $date */
            $buckets[] = [
                'key' => $date->format('Y-m-d'),
                'label' => $date->format('M j'),
            ];
        }

        return $buckets;
    }

    private function chartInterval(AdminDashboardDateRange $dateRange): string
    {
        $days = $dateRange->start->diffInDays($dateRange->end) + 1;

        return $days > 62 ? 'month' : 'day';
    }

    private function periodExpression(string $column, string $interval): string
    {
        $driver = DB::connection()->getDriverName();

        if ($interval === 'month') {
            return match ($driver) {
                'sqlite' => "strftime('%Y-%m', {$column})",
                'pgsql' => "to_char({$column}, 'YYYY-MM')",
                default => "DATE_FORMAT({$column}, '%Y-%m')",
            };
        }

        return match ($driver) {
            'sqlite' => "strftime('%Y-%m-%d', {$column})",
            'pgsql' => "to_char({$column}, 'YYYY-MM-DD')",
            default => "DATE({$column})",
        };
    }
}
