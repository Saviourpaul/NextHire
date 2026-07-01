
<x-admin-layout title="Dashboard">
	@php
		$periodOptions = \App\Enums\DashboardPeriod::cases();
	@endphp

	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-md-7">
				<h3 class="page-title">Dashboard</h3>
				<p class="text-muted mb-0">
					Recruitment insights for <strong>{{ $dateRange->label() }}</strong>
				</p>
			</div>
			<div class="col-md-5">
				<form method="GET" action="{{ route('dashboard') }}" id="dashboard-filter-form" class="dashboard-filter-form">
					<div class="row g-2 align-items-end">
						<div class="col-sm-6">
							<label for="period" class="form-label mb-1">Period</label>
							<select name="period" id="period" class="form-select">
								@foreach ($periodOptions as $option)
									<option value="{{ $option->value }}" @selected($filterValues['period'] === $option->value)>
										{{ $option->label() }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-3 custom-date-field {{ $filterValues['period'] === 'custom' ? '' : 'd-none' }}">
							<label for="date_from" class="form-label mb-1">From</label>
							<input type="date" name="date_from" id="date_from" class="form-control" value="{{ $filterValues['date_from'] }}">
						</div>
						<div class="col-sm-3 custom-date-field {{ $filterValues['period'] === 'custom' ? '' : 'd-none' }}">
							<label for="date_to" class="form-label mb-1">To</label>
							<input type="date" name="date_to" id="date_to" class="form-control" value="{{ $filterValues['date_to'] }}">
						</div>
						<div class="col-sm-12 col-md-auto">
							<button type="submit" class="btn btn-primary w-100">
								<i class="fas fa-filter me-1"></i> Apply
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-md-4 d-flex">
			<div class="card w-100">
				<div class="card-body pt-0">
					<div class="card-header border-0 pb-0">
						<div class="row align-items-center">
							<div class="col-8">
								<p class="mb-1 text-muted">Welcome back,</p>
								<h6 class="text-primary mb-0">
									<strong>{{ auth()->user()->first_name }}</strong>
								</h6>
							</div>
							<div class="col-4 text-end">
								<span class="welcome-dash-icon bg-1">
									<i class="fas fa-user-shield"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-4 col-md-6 d-flex">
			<div class="card wizard-card flex-fill">
				<div class="card-body">
					<p class="text-primary mt-0 mb-2">Total Applicants</p>
					<h3>{{ number_format($metrics['total_applicants']) }}</h3>
					<p><a href="{{ route('applicants') }}">View applicants</a></p>
					<span class="dash-widget-icon bg-1"><i class="fas fa-user-graduate"></i></span>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6 d-flex">
			<div class="card wizard-card flex-fill">
				<div class="card-body">
					<p class="text-primary mt-0 mb-2">Total Employers</p>
					<h3>{{ number_format($metrics['total_employers']) }}</h3>
					<p><a href="{{ route('Employers') }}">View employers</a></p>
					<span class="dash-widget-icon bg-1"><i class="fas fa-building"></i></span>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6 d-flex">
			<div class="card wizard-card flex-fill">
				<div class="card-body">
					<p class="text-primary mt-0 mb-2">Total Jobs Posted</p>
					<h3>{{ number_format($metrics['total_jobs']) }}</h3>
					<p class="text-muted mb-0">Within selected period</p>
					<span class="dash-widget-icon bg-1"><i class="fas fa-briefcase"></i></span>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6 d-flex">
			<div class="card wizard-card flex-fill">
				<div class="card-body">
					<p class="text-primary mt-0 mb-2">Total Applications</p>
					<h3>{{ number_format($metrics['total_applications']) }}</h3>
					<p class="text-muted mb-0">{{ number_format($metrics['pending_candidates']) }} pending</p>
					<span class="dash-widget-icon bg-1"><i class="fas fa-file-alt"></i></span>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6 d-flex">
			<div class="card wizard-card flex-fill">
				<div class="card-body">
					<p class="text-primary mt-0 mb-2">Approved Candidates</p>
					<h3>{{ number_format($metrics['approved_candidates']) }}</h3>
					<p class="text-muted mb-0">Applications approved</p>
					<span class="dash-widget-icon bg-1"><i class="fas fa-user-check"></i></span>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-md-6 d-flex">
			<div class="card wizard-card flex-fill">
				<div class="card-body">
					<p class="text-primary mt-0 mb-2">Rejected Candidates</p>
					<h3>{{ number_format($metrics['rejected_candidates']) }}</h3>
					<p class="text-muted mb-0">Applications rejected</p>
					<span class="dash-widget-icon bg-1"><i class="fas fa-user-times"></i></span>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-8 d-flex">
			<div class="card w-100">
				<div class="card-body">
					<div class="card-header border-0 px-0 pt-0">
						<h5 class="card-title mb-0">Jobs Posted Over Time</h5>
					</div>
					<div id="jobs-over-time-chart" class="mt-3"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 d-flex">
			<div class="card w-100">
				<div class="card-body">
					<div class="card-header border-0 px-0 pt-0">
						<h5 class="card-title mb-0">Application Status</h5>
					</div>
					<div id="application-status-chart" class="mt-3"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-7 d-flex">
			<div class="card w-100">
				<div class="card-body">
					<div class="card-header border-0 px-0 pt-0">
						<h5 class="card-title mb-0">New User Registrations</h5>
					</div>
					<div id="user-registrations-chart" class="mt-3"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-5 d-flex">
			<div class="card w-100">
				<div class="card-body">
					<div class="card-header border-0 px-0 pt-0 d-flex justify-content-between align-items-center">
						<h5 class="card-title mb-0">Most Applied-To Jobs</h5>
					</div>
					<div class="table-responsive mt-3">
						<table class="table table-hover table-center mb-0">
							<thead>
								<tr>
									<th>Job</th>
									<th>Company</th>
									<th class="text-end">Applications</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($charts['mostAppliedJobs'] as $job)
									<tr>
										<td>{{ $job['title'] }}</td>
										<td>{{ $job['company'] }}</td>
										<td class="text-end">
											<span class="badge bg-primary-light">{{ number_format($job['applications_count']) }}</span>
										</td>
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
	</div>

	<div class="row">
		<div class="col-lg-4 d-flex">
			<div class="card w-100">
				<div class="card-body">
					<div class="card-header border-0 px-0 pt-0">
						<h5 class="card-title mb-0">Recent Registrations</h5>
					</div>
					<div class="table-responsive mt-3">
						<table class="table table-hover mb-0">
							<thead>
								<tr>
									<th>User</th>
									<th>Role</th>
									<th>Registered</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($recentActivities['users'] as $user)
									<tr>
										<td>
											<div class="fw-medium">{{ $user->first_name }} {{ $user->last_name }}</div>
											<small class="text-muted">{{ $user->email }}</small>
										</td>
										<td><span class="badge bg-info-light">{{ $user->role->label() }}</span></td>
										<td class="text-nowrap">{{ $user->created_at->diffForHumans() }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="3" class="text-center text-muted py-4">No recent registrations.</td>
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
						<h5 class="card-title mb-0">Recently Posted Jobs</h5>
					</div>
					<div class="table-responsive mt-3">
						<table class="table table-hover mb-0">
							<thead>
								<tr>
									<th>Job</th>
									<th>Status</th>
									<th>Posted</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($recentActivities['jobs'] as $job)
									<tr>
										<td>
											<div class="fw-medium">{{ $job->title }}</div>
											<small class="text-muted">{{ $job->company }}</small>
										</td>
										<td>
											<span class="badge {{ $job->status === 'active' ? 'bg-success-light' : 'bg-secondary-light' }}">
												{{ ucfirst($job->status) }}
											</span>
										</td>
										<td class="text-nowrap">{{ $job->created_at->diffForHumans() }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="3" class="text-center text-muted py-4">No jobs posted yet.</td>
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
						<h5 class="card-title mb-0">Latest Applications</h5>
					</div>
					<div class="table-responsive mt-3">
						<table class="table table-hover mb-0">
							<thead>
								<tr>
									<th>Applicant</th>
									<th>Job</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($recentActivities['applications'] as $application)
									<tr>
										<td>
											<div class="fw-medium">
												{{ $application->applicant?->first_name }} {{ $application->applicant?->last_name }}
											</div>
											<small class="text-muted">{{ $application->reference }}</small>
										</td>
										<td>{{ $application->job?->title ?? '—' }}</td>
										<td>
											<span class="badge {{ $application->status->badgeClass() }}">
												{{ $application->status->label() }}
											</span>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="3" class="text-center text-muted py-4">No applications yet.</td>
									</tr>
								@endforelse
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
				const customDateFields = document.querySelectorAll('.custom-date-field');

				if (periodSelect) {
					periodSelect.addEventListener('change', function () {
						const showCustom = this.value === 'custom';
						customDateFields.forEach(function (field) {
							field.classList.toggle('d-none', !showCustom);
						});

						if (this.value !== 'custom') {
							document.getElementById('dashboard-filter-form').submit();
						}
					});
				}

				const jobsOverTime = @json($charts['jobsOverTime']);
				const applicationStatus = @json($charts['applicationStatus']);
				const userRegistrations = @json($charts['userRegistrations']);

				if (document.querySelector('#jobs-over-time-chart')) {
					new ApexCharts(document.querySelector('#jobs-over-time-chart'), {
						chart: { type: 'area', height: 320, toolbar: { show: false } },
						series: [{ name: jobsOverTime.label, data: jobsOverTime.series }],
						colors: ['#0073b1'],
						dataLabels: { enabled: false },
						stroke: { curve: 'smooth', width: 2 },
						fill: {
							type: 'gradient',
							gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 },
						},
						xaxis: { categories: jobsOverTime.categories },
						yaxis: { labels: { formatter: (value) => Math.round(value) } },
						tooltip: { y: { formatter: (value) => value + ' jobs' } },
					}).render();
				}

				if (document.querySelector('#application-status-chart')) {
					new ApexCharts(document.querySelector('#application-status-chart'), {
						chart: { type: 'donut', height: 320 },
						series: applicationStatus.series,
						labels: applicationStatus.labels,
						colors: applicationStatus.colors,
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

				if (document.querySelector('#user-registrations-chart')) {
					new ApexCharts(document.querySelector('#user-registrations-chart'), {
						chart: { type: 'bar', height: 320, stacked: false, toolbar: { show: false } },
						series: userRegistrations.series,
						colors: ['#0073b1', '#feb019'],
						plotOptions: {
							bar: { horizontal: false, columnWidth: '55%', borderRadius: 4 },
						},
						dataLabels: { enabled: false },
						xaxis: { categories: userRegistrations.categories },
						yaxis: { labels: { formatter: (value) => Math.round(value) } },
						legend: { position: 'top' },
					}).render();
				}
			});
		</script>
	@endpush
</x-admin-layout>
