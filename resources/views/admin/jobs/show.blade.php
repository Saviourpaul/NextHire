<x-admin-layout :title="$job->title">
    <div class="page-header">
        <div class="row align-items-center g-3">
            <div class="col">
                <h3 class="page-title">{{ $job->title }}</h3>
                <p class="mb-0 text-muted">Submitted {{ $job->created_at?->format('d M Y, h:i A') }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ url()->previous() === url()->current() ? route('admin.jobs.index') : url()->previous() }}"
                    class="btn btn-outline-secondary">
                    <i class="feather-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ $job->logoUrl() }}" alt="{{ $job->company }} logo"
                                class="rounded border me-3" width="72" height="72" style="object-fit: contain;">
                            <div>
                                <h4 class="mb-1">{{ $job->title }}</h4>
                                <p class="mb-0 text-muted">{{ $job->company }}</p>
                            </div>
                        </div>
                        <span class="badge {{ $job->status->badgeClass() }}">{{ $job->status->label() }}</span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <span class="text-muted d-block">Category</span>
                            <strong>{{ $job->category ?: 'Uncategorized' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block">Start Date</span>
                            <strong>{{ $job->start_date?->format('d M Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block">Due Date</span>
                            <strong>{{ $job->due_date?->format('d M Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block">Applications</span>
                            <strong>{{ number_format($job->applications_count) }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block">Last Updated</span>
                            <strong>{{ $job->updated_at?->format('d M Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block">Reference</span>
                            <strong>#{{ $job->id }}</strong>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Job Description</h5>
                    <div class="text-muted">
                        {!! nl2br(e(strip_tags($job->description))) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Employer</h5>
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $job->employer?->profileImageUrl() ?? asset('admin/assets/img/Avatar.png') }}"
                            alt="{{ $job->employer?->first_name ?? 'Employer' }}"
                            class="rounded-circle me-3" width="56" height="56" style="object-fit: cover;">
                        <div>
                            <h6 class="mb-0">{{ $job->employer?->first_name }} {{ $job->employer?->last_name }}</h6>
                            <small class="text-muted">{{ $job->employer?->email ?? 'Employer unavailable' }}</small>
                        </div>
                    </div>
                    @if ($job->employer)
                        <dl class="row mb-0">
                            <dt class="col-5">Username</dt>
                            <dd class="col-7">{{ '@'.$job->employer->username }}</dd>
                            <dt class="col-5">Phone</dt>
                            <dd class="col-7">{{ $job->employer->phone ?: 'Not provided' }}</dd>
                            <dt class="col-5">Status</dt>
                            <dd class="col-7">{{ $job->employer->status->label() }}</dd>
                        </dl>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">Review Decision</h5>
                    <p class="text-muted">Current status: <strong>{{ $job->status->label() }}</strong></p>
                    <div class="d-grid gap-2">
                        @foreach ($statuses as $status)
                            @continue($job->status === $status)
                            <form action="{{ route('admin.jobs.review', $job) }}" method="POST"
                                data-confirm
                                data-confirm-title="Update job status?"
                                data-confirm-text="This job will be marked as {{ $status->label() }}."
                                data-confirm-button="{{ $status->label() }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $status->value }}">
                                <button type="submit"
                                    class="btn w-100 {{ $status->value === 'approved' ? 'btn-success' : ($status->value === 'rejected' ? 'btn-danger' : 'btn-warning') }}">
                                    Mark {{ $status->label() }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
