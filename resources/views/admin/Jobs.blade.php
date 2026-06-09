<x-admin-layout title="Jobs">
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
                        <table class="table table-center table-hover mb-0 datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Logo</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Company</th>
                                    <th>Start date</th>
                                    <th>Due date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    @php
                                        $logoPath = $job->logo ?: 'admin/assets/img/company/img-10.png';
                                        $logoUrl = filter_var($logoPath, FILTER_VALIDATE_URL) ? $logoPath : asset($logoPath);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="form-check form-checkbox">
                                                <input type="checkbox" class="form-check-input" id="job-check-{{ $job->id }}">
                                                <label class="form-check-label" for="job-check-{{ $job->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <img class="me-2 rounded-circle" src="{{ $logoUrl }}" alt="{{ $job->company }} logo" width="40" height="40">
                                            </h2>
                                        </td>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ Illuminate\Support\Str::limit(strip_tags($job->description), 80) }}</td>
                                        <td>{{ $job->company }}</td>
                                        <td>{{ $job->start_date->format('d-m-Y') }}</td>
                                        <td>{{ $job->due_date->format('d-m-Y') }}</td>
                                        <td>
                                            <span class="badge {{ $job->status === 'active' ? 'bg-success-light' : 'bg-danger-light' }}">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#edit-job-{{ $job->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-job-{{ $job->id }}">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="create-job" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create job</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('jobs.store') }}" method="POST">
                        @csrf
                        @include('admin.partials.job-form', ['job' => null])
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Create job</button>
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
                        <h4 class="modal-title">Edit job</h4>
                        <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('jobs.update', $job) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @include('admin.partials.job-form', ['job' => $job])
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-block">Save changes</button>
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
