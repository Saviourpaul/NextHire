<x-admin-layout title="Jobs">
    @php
        $sortIcon = fn ($column) => $sortColumn === $column
            ? ($sortDirection === 'asc' ? '↑' : '↓')
            : '↕';
        $sortUrl = fn ($column) => request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => ($sortColumn === $column && $sortDirection === 'asc') ? 'desc' : 'asc',
        ]);
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-white projects-card">
                <div class="card-body pt-0">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title">Jobs</h5>
                        <button class="btn add-user" type="button" data-bs-toggle="modal" data-bs-target="#create-job" style="background-color: #1e1e2d; color: #fff;">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>

                    <div class="p-3 bg-light border-bottom">
                        <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <label class="form-label small text-muted">Search Jobs</label>
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Title, company, or description..." value="{{ request('search') }}">
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit">Search</button>
                            <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                        </form>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mt-3 mb-0">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-0">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive mt-3">
                        <table class="table table-hover mb-0 jobs-table">
                            <thead>
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Logo</th>
                                    <th class="align-middle">
                                        <a href="{{ $sortUrl('title') }}" class="text-decoration-none">
                                            Title<span class="ms-1">{{ $sortIcon('title') }}</span>
                                        </a>
                                    </th>
                                    <th class="align-middle d-none d-md-table-cell">
                                        <a href="{{ $sortUrl('company') }}" class="text-decoration-none">
                                            Company<span class="ms-1">{{ $sortIcon('company') }}</span>
                                        </a>
                                    </th>
                                    <th class="align-middle d-none d-lg-table-cell">
                                        <a href="{{ $sortUrl('start_date') }}" class="text-decoration-none">
                                            Start Date<span class="ms-1">{{ $sortIcon('start_date') }}</span>
                                        </a>
                                    </th>
                                    <th class="align-middle d-none d-lg-table-cell">
                                        <a href="{{ $sortUrl('due_date') }}" class="text-decoration-none">
                                            Due Date<span class="ms-1">{{ $sortIcon('due_date') }}</span>
                                        </a>
                                    </th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobs as $index => $job)
                                    <tr>
                                        <td class="align-middle">{{ $jobs->firstItem() + $loop->index }}</td>
                                        <td class="align-middle">
                                            <img class="me-2 rounded-circle border" src="{{ $job->logoUrl() }}" alt="{{ $job->company }} logo" width="36" height="36" style="object-fit: contain;">
                                        </td>
                                        <td class="align-middle">
                                            <div>
                                                <h6 class="mb-0">{{ $job->title }}</h6>
                                                <small class="text-muted d-md-none">{{ $job->company }}</small>
                                                <small class="text-muted d-lg-none">{{ $job->start_date->format('d-m-Y') }} - {{ $job->due_date->format('d-m-Y') }}</small>
                                            </div>
                                        </td>
                                        <td class="align-middle d-none d-md-table-cell">{{ $job->company }}</td>
                                        <td class="align-middle d-none d-lg-table-cell">{{ $job->start_date->format('d-m-Y') }}</td>
                                        <td class="align-middle d-none d-lg-table-cell">{{ $job->due_date->format('d-m-Y') }}</td>
                                        <td class="align-middle">
                                            <span class="badge {{ $job->status === 'active' ? 'bg-success-light' : 'bg-danger-light' }}">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#edit-job-{{ $job->id }}">
                                                            <i data-feather="edit" class="me-2"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger mb-0" type="button" data-bs-toggle="modal" data-bs-target="#delete-job-{{ $job->id }}">
                                                            <i data-feather="trash-2" class="me-2"></i> Delete
                                                        </button>
                                                    </li>
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
        </div>
    </div>

    <div class="modal fade custom-modal" id="create-job" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Job</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.partials.job-form', ['job' => null])
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Create Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($jobs as $job)
        <div class="modal fade custom-modal" id="edit-job-{{ $job->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Job</h4>
                        <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('jobs.update', $job) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.partials.job-form', ['job' => $job])
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal custom-modal fade" id="delete-job-{{ $job->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure you want to delete this job?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ route('jobs.destroy', $job) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary continue-btn w-100">Delete</button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary cancel-btn w-100">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-admin-layout>
