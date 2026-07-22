@php
    $percentage = $user->applicantProfileCompletionPercentage();
    $missingFields = $user->missingApplicantProfileFields();
@endphp
<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
            <h5 class="card-title mb-0">Profile Completion</h5>
            <strong>{{ $percentage }}%</strong>
        </div>
        <div class="progress mb-3" style="height: 10px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @if ($missingFields)
            <p class="text-muted mb-2">Missing profile details:</p>
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach ($missingFields as $label)
                    <span class="badge bg-warning-light">{{ $label }}</span>
                @endforeach
            </div>
            <a class="btn btn-primary" href="{{ route('profile.edit') }}">Complete Profile</a>
        @else
            <span class="badge bg-success-light">Complete</span>
        @endif
    </div>
</div>
