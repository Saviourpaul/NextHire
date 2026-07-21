@use('Illuminate\Support\Str')

<x-admin-layout :title="$title">
    @php
        $pageTitle = $title;
        $sortIcon = fn ($column) => $sortColumn === $column
            ? ($sortDirection === 'asc' ? '&uarr;' : '&darr;')
            : '&harr;';
        $sortUrl = fn ($column) => request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $sortColumn === $column && $sortDirection === 'asc' ? 'desc' : 'asc',
        ]);
        $tabQuery = request()->except(['status', 'page']);
        $statusTabs = [
            [
                'label' => 'All Jobs',
                'url' => route('admin.jobs.index', $tabQuery),
                'active' => request()->routeIs('admin.jobs.index') && blank($filterValues['status']),
                'count' => $statusCounts['all'],
                'class' => 'bg-info-light',
            ],
            [
                'label' => 'Approved Jobs',
                'url' => route('approved-jobs', $tabQuery),
                'active' => request()->routeIs('approved-jobs') || $filterValues['status'] === 'approved',
                'count' => $statusCounts['approved'],
                'class' => 'bg-success-light',
            ],
            [
                'label' => 'Pending Jobs',
                'url' => route('pending-jobs', $tabQuery),
                'active' => request()->routeIs('pending-jobs') || $filterValues['status'] === 'pending',
                'count' => $statusCounts['pending'],
                'class' => 'bg-warning-light',
            ],
            [
                'label' => 'Rejected Jobs',
                'url' => route('rejected-jobs', $tabQuery),
                'active' => request()->routeIs('rejected-jobs') || $filterValues['status'] === 'rejected',
                'count' => $statusCounts['rejected'],
                'class' => 'bg-danger-light',
            ],
        ];
    @endphp

    <div class="page-header subscribe-head">
        <div class="row align-items-center g-3">
            <div class="col">
                <h3 class="page-title">{{ $pageTitle }}</h3>
                <p class="mb-0 text-muted">
                    {{ number_format($jobs->total()) }} {{ Str::plural('job', $jobs->total()) }} found
                </p>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach ($statusTabs as $tab)
            <div class="col-xl-3 col-md-6 d-flex">
                <a href="{{ $tab['url'] }}" class="card flex-fill text-decoration-none {{ $tab['active'] ? 'border-primary' : '' }}">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">{{ $tab['label'] }}</p>
                            <h3 class="mb-0">{{ number_format($tab['count']) }}</h3>
                        </div>
                        <span class="badge {{ $tab['class'] }}">{{ $tab['label'] }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card filter-card mb-4" id="filter_inputs">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <input type="hidden" name="sort" value="{{ $sortColumn }}">
                <input type="hidden" name="direction" value="{{ $sortDirection }}">

                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="feather-search"></i></span>
                            <input class="form-control" name="search" type="search"
                                placeholder="Title, employer, category..."
                                value="{{ $filterValues['search'] }}">
                        </div>
                    </div>
                    @unless ($statusConstraint)
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-control form-select" name="status">
                                <option value="">All statuses</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" @selected($filterValues['status'] === $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endunless
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Category</label>
                        <select class="form-control form-select" name="category">
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected($filterValues['category'] === $category)>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Submitted From</label>
                        <input class="form-control" name="submitted_from" type="date"
                            value="{{ $filterValues['submitted_from'] }}">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Submitted To</label>
                        <input class="form-control" name="submitted_to" type="date"
                            value="{{ $filterValues['submitted_to'] }}">
                    </div>
                    <div class="col-lg-1 col-md-6">
                        <label class="form-label">Rows</label>
                        <select class="form-control form-select" name="per_page">
                            @foreach ($perPageOptions as $option)
                                <option value="{{ $option }}" @selected((int) $filterValues['per_page'] === $option)>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 d-flex gap-2">
                        <button class="btn btn-primary flex-fill" type="submit">
                            <i class="feather-filter me-1"></i> Filter
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary flex-fill">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h5 class="mb-1">{{ $pageTitle }}</h5>
                    @if ($jobs->count())
                        <span class="text-muted">
                            Showing {{ number_format($jobs->firstItem()) }}-{{ number_format($jobs->lastItem()) }}
                            of {{ number_format($jobs->total()) }}
                        </span>
                    @else
                        <span class="text-muted">No jobs match the current filters.</span>
                    @endif
                </div>
                @if ($statusConstraint)
                    <span class="badge {{ $statusConstraint->badgeClass() }}">{{ $statusConstraint->label() }}</span>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 jobs-table">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ $sortUrl('created_at') }}" class="text-decoration-none">
                                    #<span class="ms-1">{!! $sortIcon('created_at') !!}</span>
                                </a>
                            </th>
                            <th>
                                <a href="{{ $sortUrl('title') }}" class="text-decoration-none">
                                    Job<span class="ms-1">{!! $sortIcon('title') !!}</span>
                                </a>
                            </th>
                            <th>
                                <a href="{{ $sortUrl('employer') }}" class="text-decoration-none">
                                    Employer<span class="ms-1">{!! $sortIcon('employer') !!}</span>
                                </a>
                            </th>
                            <th class="d-none d-lg-table-cell">
                                <a href="{{ $sortUrl('category') }}" class="text-decoration-none">
                                    Category<span class="ms-1">{!! $sortIcon('category') !!}</span>
                                </a>
                            </th>
                            <th>
                                <a href="{{ $sortUrl('status') }}" class="text-decoration-none">
                                    Status<span class="ms-1">{!! $sortIcon('status') !!}</span>
                                </a>
                            </th>
                            <th class="d-none d-xl-table-cell">
                                <a href="{{ $sortUrl('created_at') }}" class="text-decoration-none">
                                    Submitted<span class="ms-1">{!! $sortIcon('created_at') !!}</span>
                                </a>
                            </th>
                            <th class="d-none d-xxl-table-cell">Applications</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobs as $job)
                            <tr>
                                <td>{{ $jobs->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="rounded border me-2" src="{{ $job->logoUrl() }}" alt="{{ $job->company }} logo"
                                            width="44" height="44" style="object-fit: contain;">
                                        <div>
                                            <h6 class="mb-0">{{ $job->title }}</h6>
                                            <small class="text-muted">{{ $job->company }}</small>
                                            <small class="text-muted d-lg-none d-block">{{ $job->category ?: 'Uncategorized' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">
                                        {{ $job->employer?->first_name }} {{ $job->employer?->last_name }}
                                    </div>
                                    <small class="text-muted">{{ $job->employer?->email ?? 'Employer unavailable' }}</small>
                                </td>
                                <td class="d-none d-lg-table-cell">{{ $job->category ?: 'Uncategorized' }}</td>
                                <td>
                                    <span class="badge {{ $job->status->badgeClass() }}">
                                        {{ $job->status->label() }}
                                    </span>
                                </td>
                                <td class="d-none d-xl-table-cell">{{ $job->created_at?->format('d M Y') }}</td>
                                <td class="d-none d-xxl-table-cell">{{ number_format($job->applications_count) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.jobs.show', $job) }}">
                                                    <i data-feather="eye" class="me-2"></i> View Details
                                                </a>
                                            </li>
                                            @foreach ($statuses as $status)
                                                @continue($job->status === $status)
                                                <li>
                                                    <form action="{{ route('admin.jobs.review', $job) }}" method="POST"
                                                        class="d-grid"
                                                        data-confirm
                                                        data-confirm-title="Update job status?"
                                                        data-confirm-text="This job will be marked as {{ $status->label() }}."
                                                        data-confirm-button="{{ $status->label() }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $status->value }}">
                                                        <button class="dropdown-item" type="submit">
                                                            <i data-feather="check-circle" class="me-2"></i>
                                                            Mark {{ $status->label() }}
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No jobs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jobs->hasPages())
                <div class="mt-4">
                    {{ $jobs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
