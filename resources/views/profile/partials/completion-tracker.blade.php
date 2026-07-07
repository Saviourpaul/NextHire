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
            <a class="btn btn-primary" href="{{ route('profile.edit') }}">Complete Profile</a>
        @else
            <span class="badge bg-success-light">Complete</span>
        @endif
    </div>
</div>
