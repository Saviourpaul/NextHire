<x-admin-layout title="Review Application">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Review Application</h3>
                <p class="text-muted mb-0">{{ $application->reference }} - {{ $application->job->title }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('employer.Applied-Candidates') }}" class="btn btn-outline-secondary">Back to
                    Candidates</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
                        <img class="rounded-circle" src="{{ $application->applicant->profileImageUrl() }}"
                            alt="Profile image" width="120" height="120" style="object-fit: cover;">
                        <div>
                            <h5 class="card-title mb-1">{{ $application->first_name }} {{ $application->last_name }}
                            </h5>
                            <p class="mb-1">{{ $application->email }} - {{ $application->phone }}</p>
                            <span
                                class="badge {{ $application->status->badgeClass() }}">{{ $application->status->label() }}</span>
                            <a class="ms-2"
                                href="{{ route('applicants.profile.show', $application->applicant) }}">View linked
                                profile</a>
                        </div>
                    </div>

                    <h5 class="mb-3">Application Profile</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Middle Name:</strong> {{ $application->middle_name ?: 'Not provided' }}</p>
                            <p><strong>Date of Birth:</strong>
                                {{ $application->date_of_birth?->format('M d, Y') ?: 'Not provided' }}</p>
                            <p><strong>Gender:</strong>
                                {{ $application->gender ? ucfirst($application->gender) : 'Not provided' }}</p>
                            <p><strong>Marital Status:</strong>
                                {{ $application->marital_status ? ucfirst($application->marital_status) : 'Not provided' }}
                            </p>
                            <p><strong>Nationality:</strong> {{ $application->nationality ?: 'Not provided' }}</p>
                            <p><strong>State of Origin:</strong> {{ $application->state_of_origin ?: 'Not provided' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>LGA:</strong> {{ $application->local_government_area ?: 'Not provided' }}</p>
                            <p><strong>Address:</strong> {{ $application->address ?: 'Not provided' }}</p>
                            <p><strong>Zipcode:</strong> {{ $application->zipcode ?: 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title">Uploaded Documents</h5>
                    <div class="table-responsive ">
                        <table class="table table-center table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Number</th>
                                    <th>Status</th>
                                    <th>File</th>
                                    <th>Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($application->documents as $document)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $document->document_name }}</div>
                                            <div class="text-muted small">{{ $document->original_name }}</div>
                                        </td>
                                        <td>{{ $document->maskedDocumentNumber() ?: 'N/A' }}</td>
                                        <td><span
                                                class="badge {{ $document->status->badgeClass() }}">{{ $document->status->label() }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if ($document->canPreviewInline())
                                                    <a href="{{ $document->previewUrl() }}"
                                                        class="btn btn-sm btn-outline-primary" data-document-preview
                                                        data-preview-url="{{ $document->previewUrl() }}"
                                                        data-preview-title="{{ $document->document_name }} - {{ $document->original_name }}"
                                                        data-download-url="{{ $document->downloadUrl() }}">
                                                        Preview
                                                    </a>
                                                @endif
                                                <a href="{{ $document->downloadUrl() }}"
                                                    class="btn btn-sm btn-outline-secondary">Download</a>
                                            </div>
                                        </td>
                                        <td style="min-width: 260px;">
                                            <form
                                                action="{{ route('employer.application-documents.review', $document) }}"
                                                method="POST" class="d-flex flex-column gap-2" data-confirm
                                                data-confirm-title="Update document review?"
                                                data-confirm-text="This document status will be saved."
                                                data-confirm-button="Update Document">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-control form-control-sm">
                                                    @foreach (\App\Enums\ApplicationStatus::cases() as $status)
                                                        <option value="{{ $status->value }}"
                                                            @selected($document->status === $status)>{{ $status->label() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Update
                                                    Document</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Application Decision</h5>
                    <form action="{{ route('employer.applications.review', $application) }}" method="POST"
                        class="d-flex flex-column gap-3" data-confirm data-confirm-title="Save application decision?"
                        data-confirm-text="The applicant's application status will be updated."
                        data-confirm-button="Save Decision">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                @foreach (\App\Enums\ApplicationStatus::cases() as $status)
                                    <option value="{{ $status->value }}" @selected($application->status === $status)>
                                        {{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Decision</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Audit Trail</h5>
                    <div class="list-group">
                        @forelse ($application->statusHistories->sortByDesc('created_at') as $history)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $history->to_status->label() }}</strong>
                                    <small>{{ $history->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-muted small">
                                    From {{ $history->from_status?->label() ?: 'New' }} by
                                    {{ $history->changedBy?->first_name ?: 'System' }}
                                </p>

                            </div>
                        @empty
                            <div class="list-group-item text-muted">No status history yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="document-preview-modal" tabindex="-1" aria-labelledby="document-preview-title"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="document-preview-title">Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="document-preview-frame" title="Document preview" src="about:blank"
                        style="width: 100%; height: 75vh; border: 0;"></iframe>
                </div>
                <div class="modal-footer">
                    <a id="document-preview-download" href="#" class="btn btn-outline-secondary">Download</a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const previewModal = document.getElementById('document-preview-modal');
                const previewFrame = document.getElementById('document-preview-frame');
                const previewTitle = document.getElementById('document-preview-title');
                const previewDownload = document.getElementById('document-preview-download');

                if (!previewModal || !previewFrame || !window.bootstrap) {
                    return;
                }

                const modal = new bootstrap.Modal(previewModal);

                document.querySelectorAll('[data-document-preview]').forEach((trigger) => {
                    trigger.addEventListener('click', function(event) {
                        event.preventDefault();

                        previewFrame.src = trigger.dataset.previewUrl;
                        previewTitle.textContent = trigger.dataset.previewTitle || 'Document Preview';
                        previewDownload.href = trigger.dataset.downloadUrl || trigger.href;

                        modal.show();
                    });
                });

                previewModal.addEventListener('hidden.bs.modal', function() {
                    previewFrame.src = 'about:blank';
                });
            });
        </script>
    @endpush
</x-admin-layout>
