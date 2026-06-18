<x-admin-layout title="Jobs">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Jobs</h3>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="{{ route('jobs.public') }}">Browse Jobs</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Applied Jobs</h5>

                    <div class="table-responsive">
                        <table class="table table-center table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Applied On</th>
                                    <th>Reference ID</th>
                                    <th>Status</th>
                                    <th>Documents</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $application)
                                    <tr>
                                        <td>{{ $application->job->title }}</td>
                                        <td>{{ $application->job->company }}</td>
                                        <td>{{ $application->submitted_at->format('M d, Y') }}</td>
                                        <td>{{ $application->reference }}</td>
                                        <td><span class="badge {{ $application->status->badgeClass() }}">{{ $application->status->label() }}</span></td>
                                        <td>
                                            {{ $application->documents->where('status', \App\Enums\ApplicationStatus::Approved)->count() }}/{{ $application->documents->count() }} approved
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('client.applications.show', $application) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No applied jobs yet</td>
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
        </div>
    </div>
</x-admin-layout>
