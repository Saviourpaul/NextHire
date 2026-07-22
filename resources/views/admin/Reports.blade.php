@use('App\Enums\DashboardPeriod')

@php
    $metrics = $report['metrics'];
    $charts = $report['charts'];
    $number = fn (int|float $value): string => is_float($value) ? number_format($value, 1) : number_format($value);
    $percent = fn (int|float $value): string => number_format((float) $value, 1).'%';
@endphp

<x-admin-layout title="Administrative Reports">
    <div class="page-header">
        <div class="row align-items-center g-3">
            <div class="col-xl-5 col-lg-12">
                <h3 class="page-title">Administrative Reports</h3>
                <p class="text-muted mb-0">
                    Platform performance, recruitment activity, moderation, security, and configuration status for
                    <strong>{{ $report['dateRange']->label() }}</strong>.
                </p>
            </div>
            <div class="col-xl-7 col-lg-12">
                <form method="GET" action="{{ route('Reports') }}" id="report-filter-form" class="row g-2 align-items-end justify-content-xl-end">
                    <div class="col-sm-6 col-md-3">
                        <label for="period" class="form-label mb-1">Period</label>
                        <select name="period" id="period" class="form-select">
                            @foreach (DashboardPeriod::cases() as $option)
                                <option value="{{ $option->value }}" @selected($report['filterValues']['period'] === $option->value)>
                                    {{ $option->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 report-custom-date {{ $report['filterValues']['period'] === 'custom' ? '' : 'd-none' }}">
                        <label for="date_from" class="form-label mb-1">From</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $report['filterValues']['date_from'] }}">
                    </div>
                    <div class="col-sm-6 col-md-3 report-custom-date {{ $report['filterValues']['period'] === 'custom' ? '' : 'd-none' }}">
                        <label for="date_to" class="form-label mb-1">To</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $report['filterValues']['date_to'] }}">
                    </div>
                    <div class="col-sm-6 col-md-auto">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Apply
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-auto">
                        <a class="btn btn-outline-primary w-100" href="{{ route('Reports.export', $report['filterValues']) }}">
                            <i class="fas fa-file-csv me-1"></i> Export CSV
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card wizard-card flex-fill">
                <div class="card-body">
                    <p class="text-primary mt-0 mb-2">Registered Users</p>
                    <h3>{{ $number($metrics['total_registered_users']) }}</h3>
                    <p class="text-muted mb-0">{{ $number($metrics['new_users_in_period']) }} new in period</p>
                    <span class="dash-widget-icon bg-1"><i class="fas fa-users"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card wizard-card flex-fill">
                <div class="card-body">
                    <p class="text-primary mt-0 mb-2">Active Job Posts</p>
                    <h3>{{ $number($metrics['active_job_postings']) }}</h3>
                    <p class="text-muted mb-0">{{ $number($metrics['pending_job_reviews']) }} awaiting review</p>
                    <span class="dash-widget-icon bg-1"><i class="fas fa-briefcase"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card wizard-card flex-fill">
                <div class="card-body">
                    <p class="text-primary mt-0 mb-2">Applications</p>
                    <h3>{{ $number($metrics['new_applications_in_period']) }}</h3>
                    <p class="text-muted mb-0">{{ $number($metrics['total_applications']) }} all time</p>
                    <span class="dash-widget-icon bg-1"><i class="fas fa-file-alt"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 d-flex">
            <div class="card wizard-card flex-fill">
                <div class="card-body">
                    <p class="text-primary mt-0 mb-2">Conversion Rate</p>
                    <h3>{{ $percent($metrics['application_conversion_rate']) }}</h3>
                    <p class="text-muted mb-0">{{ $percent($metrics['hiring_success_rate']) }} hiring success</p>
                    <span class="dash-widget-icon bg-1"><i class="fas fa-chart-line"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">User Growth And Applications</h5>
                    </div>
                    <div id="report-growth-chart" class="mt-3"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Candidate Pipeline</h5>
                    </div>
                    <div id="report-pipeline-chart" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Platform Statistics</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr><th>Total applicants</th><td class="text-end">{{ $number($metrics['total_applicants']) }}</td></tr>
                                <tr><th>Total employers</th><td class="text-end">{{ $number($metrics['total_employers']) }}</td></tr>
                                <tr><th>Active users in period</th><td class="text-end">{{ $number($metrics['active_users_in_period']) }}</td></tr>
                                <tr><th>Submitted jobs in period</th><td class="text-end">{{ $number($metrics['submitted_jobs_in_period']) }}</td></tr>
                                <tr><th>Pending applications</th><td class="text-end">{{ $number($metrics['pending_applications']) }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Recruitment Analytics</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr><th>Total applications</th><td class="text-end">{{ $number($metrics['total_applications']) }}</td></tr>
                                <tr><th>New applications</th><td class="text-end">{{ $number($metrics['new_applications_in_period']) }}</td></tr>
                                <tr><th>Application conversion</th><td class="text-end">{{ $percent($metrics['application_conversion_rate']) }}</td></tr>
                                <tr><th>Hiring success</th><td class="text-end">{{ $percent($metrics['hiring_success_rate']) }}</td></tr>
                                <tr><th>Avg time to hire</th><td class="text-end">{{ $number($metrics['average_time_to_hire_days']) }} days</td></tr>
                                <tr><th>Avg time to decision</th><td class="text-end">{{ $number($metrics['average_time_to_decision_days']) }} days</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Job Moderation</h5>
                    </div>
                    <div id="report-job-moderation-chart" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Most Applied Jobs</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Job</th>
                                    <th>Company</th>
                                    <th class="text-end">Applications</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($report['mostAppliedJobs'] as $job)
                                    <tr>
                                        <td>{{ $job['title'] }}</td>
                                        <td>{{ $job['company'] }}</td>
                                        <td class="text-end">{{ $number($job['applications_count']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No applications in this period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Applications Per Job</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Job</th>
                                    <th>Status</th>
                                    <th class="text-end">Applications</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($report['applicationsPerJob'] as $job)
                                    <tr>
                                        <td>
                                            <div class="fw-medium">{{ $job['title'] }}</div>
                                            <small class="text-muted">{{ $job['company'] }}</small>
                                        </td>
                                        <td>{{ $job['status'] }}</td>
                                        <td class="text-end">{{ $number($job['applications_count']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No jobs available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Jobs By Category</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse ($report['jobsByCategory'] as $category)
                                    <tr>
                                        <th>{{ $category['category'] }}</th>
                                        <td class="text-end">{{ $number($category['total_jobs']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted py-4">No job categories available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Top Employers</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Employer</th>
                                    <th class="text-end">Jobs</th>
                                    <th class="text-end">Applications</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($report['topEmployers'] as $employer)
                                    <tr>
                                        <td>{{ $employer['name'] }}</td>
                                        <td class="text-end">{{ $number($employer['jobs_count']) }}</td>
                                        <td class="text-end">{{ $number($employer['applications_count']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No employers available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Operational Metrics</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @foreach ($report['operationalMetrics'] as $metric)
                                    <tr>
                                        <th>{{ $metric['label'] }}</th>
                                        <td class="text-end">{{ is_numeric($metric['value']) ? $number((int) $metric['value']) : $metric['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Security And Rate Limits</h5>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <div class="border rounded p-3 h-100">
                                <p class="text-muted mb-1">Active accounts</p>
                                <h4 class="mb-0">{{ $number($report['securityMetrics']['activeAccounts']) }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="border rounded p-3 h-100">
                                <p class="text-muted mb-1">Suspended accounts</p>
                                <h4 class="mb-0">{{ $number($report['securityMetrics']['suspendedAccounts']) }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="border rounded p-3 h-100">
                                <p class="text-muted mb-1">Logins in period</p>
                                <h4 class="mb-0">{{ $number($report['securityMetrics']['newLoginsInPeriod']) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Limiter</th>
                                    <th>Threshold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report['securityMetrics']['rateLimiters'] as $limiter)
                                    <tr>
                                        <td>{{ $limiter['name'] }}</td>
                                        <td>{{ $limiter['threshold'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Platform Configuration</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @foreach ($report['configuration'] as $setting)
                                    <tr>
                                        <th>{{ $setting['label'] }}</th>
                                        <td class="text-end">{{ $setting['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Applicant Geography</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse ($report['geography']['applicantsByState'] as $state)
                                    <tr>
                                        <th>{{ $state['state'] }}</th>
                                        <td class="text-end">{{ $number($state['total']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted py-4">No applicant location data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-header border-0 px-0 pt-0">
                        <h5 class="card-title mb-0">Report Coverage</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Area</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report['dataAvailability'] as $item)
                                    <tr>
                                        <td>{{ $item['label'] }}</td>
                                        <td><span class="badge bg-warning-light">{{ $item['status'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const periodSelect = document.getElementById('period');
                const customDateFields = document.querySelectorAll('.report-custom-date');

                periodSelect?.addEventListener('change', function () {
                    const showCustom = this.value === 'custom';
                    customDateFields.forEach((field) => field.classList.toggle('d-none', !showCustom));

                    if (!showCustom) {
                        document.getElementById('report-filter-form')?.submit();
                    }
                });

                const userGrowth = @json($charts['userGrowth']);
                const applicationTrend = @json($charts['applicationTrend']);
                const pipeline = @json($charts['pipeline']);
                const jobModeration = @json($charts['jobModeration']);

                if (document.querySelector('#report-growth-chart')) {
                    new ApexCharts(document.querySelector('#report-growth-chart'), {
                        chart: { type: 'area', height: 320, toolbar: { show: false } },
                        series: [
                            ...userGrowth.series,
                            applicationTrend.series[0],
                        ],
                        colors: ['#0073b1', '#feb019', '#28a745'],
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 2 },
                        fill: {
                            type: 'gradient',
                            gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 },
                        },
                        xaxis: { categories: userGrowth.categories },
                        yaxis: { labels: { formatter: (value) => Math.round(value) } },
                    }).render();
                }

                if (document.querySelector('#report-pipeline-chart')) {
                    new ApexCharts(document.querySelector('#report-pipeline-chart'), {
                        chart: { type: 'donut', height: 320 },
                        labels: pipeline.labels,
                        series: pipeline.series,
                        colors: pipeline.colors,
                        legend: { position: 'bottom' },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '68%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Applications',
                                            formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0),
                                        },
                                    },
                                },
                            },
                        },
                    }).render();
                }

                if (document.querySelector('#report-job-moderation-chart')) {
                    new ApexCharts(document.querySelector('#report-job-moderation-chart'), {
                        chart: { type: 'bar', height: 260, toolbar: { show: false } },
                        labels: jobModeration.labels,
                        series: [{ name: 'Jobs', data: jobModeration.series }],
                        colors: ['#0073b1'],
                        plotOptions: {
                            bar: { horizontal: true, borderRadius: 4 },
                        },
                        dataLabels: { enabled: false },
                        xaxis: { categories: jobModeration.labels, labels: { formatter: (value) => Math.round(value) } },
                    }).render();
                }
            });
        </script>
    @endpush
</x-admin-layout>
