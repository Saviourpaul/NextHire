@php
    $statusTabs = [
        'All Applied' => 'employer.Applied-Candidates',
        'Approved' => 'employer.Approved-Candidates',
        'Rejected' => 'employer.Rejected-Candidate',
    ];
@endphp

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">{{ $title }}</h3>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2 mb-3">
            @foreach ($statusTabs as $label => $tabRoute)
                <a class="btn {{ request()->routeIs($tabRoute) ? 'btn-primary' : 'btn-outline-primary' }}" href="{{ route($tabRoute) }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form action="{{ route($routeName) }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Candidate, job, company, or reference">
            </div>
            <div class="col-md-4">
                <label class="form-label">Job</label>
                <select name="job_id" class="form-control">
                    <option value="">All jobs</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->id }}" @selected((string) request('job_id') === (string) $job->id)>{{ $job->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route($routeName) }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-center table-hover mb-0">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Job</th>
                        <th>Reference</th>
                        <th>Submitted</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $application->first_name }} {{ $application->last_name }}</div>
                                <div class="text-muted small">{{ $application->email }}</div>
                            </td>
                            <td>
                                <div>{{ $application->job->title }}</div>
                                <div class="text-muted small">{{ $application->job->company }}</div>
                            </td>
                            <td>{{ $application->reference }}</td>
                            <td>{{ $application->submitted_at->format('M d, Y') }}</td>
                            <td>
                                {{ $application->documents->where('status', \App\Enums\ApplicationStatus::Approved)->count() }}/{{ $application->documents->count() }} approved
                            </td>
                            <td>
                                <span class="badge {{ $application->status->badgeClass() }}">{{ $application->status->label() }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('employer.applications.show', $application) }}" class="btn btn-sm btn-outline-primary">View</a>

                                    @if ($application->status !== \App\Enums\ApplicationStatus::Approved)
                                        <form action="{{ route('employer.applications.review', $application) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @endif

                                    @if ($application->status !== \App\Enums\ApplicationStatus::Rejected)
                                        <form action="{{ route('employer.applications.review', $application) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    </div>
</div>
