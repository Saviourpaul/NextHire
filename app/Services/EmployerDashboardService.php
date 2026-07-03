<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
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

class EmployerDashboardService
{
    /**
     * @return array<string, mixed>
     */
    public function getOverview(Request $request, User $employer): array
    {
        $dateRange = AdminDashboardDateRange::fromRequest($request);

        $jobsQuery = Job::query()
            ->where('employer_id', $employer->id)
            ->whereBetween('created_at', [$dateRange->start, $dateRange->end]);

        $applicationsQuery = ApplicationForm::query()
            ->forEmployer($employer)
            ->whereBetween('submitted_at', [$dateRange->start, $dateRange->end]);

        return [
            'dateRange' => $dateRange,
            'filterValues' => $dateRange->filterValues(),
            'metrics' => $this->metrics($applicationsQuery, $jobsQuery),
            'charts' => [
                'applicationsOverTime' => $this->applicationsOverTime($applicationsQuery, $dateRange),
                'jobsOverTime' => $this->jobsOverTime($jobsQuery, $dateRange),
                'applicationStatus' => $this->applicationStatusDistribution($applicationsQuery),
            ],
            'mostAppliedJobs' => $this->mostAppliedJobs($applicationsQuery),
            'recentApplications' => $this->recentApplications($applicationsQuery),
        ];
    }

    /**
     * @param  Builder<Model>  $applicationsQuery
     * @param  Builder<Model>  $jobsQuery
     * @return array<string, int>
     */
    private function metrics(Builder $applicationsQuery, Builder $jobsQuery): array
    {
        $applicationCounts = (clone $applicationsQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'total_jobs' => (int) (clone $jobsQuery)->count(),
            'total_applicants' => (int) (clone $applicationsQuery)->distinct('user_id')->count('user_id'),
            'total_applications' => (int) $applicationCounts->sum(),
            'approved_candidates' => (int) ($applicationCounts[ApplicationStatus::Approved->value] ?? 0),
            'rejected_candidates' => (int) ($applicationCounts[ApplicationStatus::Rejected->value] ?? 0),
            'pending_applications' => (int) ($applicationCounts[ApplicationStatus::Pending->value] ?? 0),
        ];
    }

    /**
     * @param  Builder<Model>  $applicationsQuery
     * @return array<string, mixed>
     */
    private function applicationsOverTime(Builder $applicationsQuery, AdminDashboardDateRange $dateRange): array
    {
        $interval = $this->chartInterval($dateRange);
        $counts = $this->groupedCounts($applicationsQuery, 'submitted_at', $interval);

        return $this->buildTimeSeries($dateRange, $interval, $counts, 'Applications Received');
    }

    /**
     * @param  Builder<Model>  $jobsQuery
     * @return array<string, mixed>
     */
    private function jobsOverTime(Builder $jobsQuery, AdminDashboardDateRange $dateRange): array
    {
        $interval = $this->chartInterval($dateRange);
        $counts = $this->groupedCounts($jobsQuery, 'created_at', $interval);

        return $this->buildTimeSeries($dateRange, $interval, $counts, 'Jobs Posted');
    }

    /**
     * @param  Builder<Model>  $applicationsQuery
     * @return array<string, mixed>
     */
    private function applicationStatusDistribution(Builder $applicationsQuery): array
    {
        $counts = (clone $applicationsQuery)
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
     * @param  Builder<Model>  $applicationsQuery
     * @return list<array<string, mixed>>
     */
    private function mostAppliedJobs(Builder $applicationsQuery): array
    {
        return (clone $applicationsQuery)
            ->select('application_forms.job_id', 'job_posts.title', 'job_posts.company')
            ->join('job_posts', 'application_forms.job_id', '=', 'job_posts.id')
            ->groupBy('application_forms.job_id', 'job_posts.title', 'job_posts.company')
            ->selectRaw('COUNT(*) as applications_count')
            ->orderByDesc('applications_count')
            ->limit(5)
            ->get()
            ->map(fn ($row): array => [
                'title' => $row->title,
                'company' => $row->company,
                'applications_count' => (int) $row->applications_count,
            ])
            ->all();
    }

    /**
     * @param  Builder<Model>  $applicationsQuery
     * @return Collection<int, ApplicationForm>
     */
    private function recentApplications(Builder $applicationsQuery): Collection
    {
        return (clone $applicationsQuery)
            ->with(['job:id,title', 'applicant:id,first_name,last_name'])
            ->latest('submitted_at')
            ->limit(5)
            ->get(['id', 'reference', 'job_id', 'user_id', 'status', 'submitted_at']);
    }

    /**
     * @param  Builder<Model>  $query
     * @return array<string, int>
     */
    private function groupedCounts(Builder $query, string $column, string $interval): array
    {
        $query = clone $query;
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
