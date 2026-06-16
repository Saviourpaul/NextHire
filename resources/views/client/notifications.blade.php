<x-admin-layout title="Notifications">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Notifications</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Recent Notifications</h5>

                    <div class="list-group">
                        <a class="list-group-item list-group-item-action" href="{{ route('client.jobs') }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Job updates</h6>
                                <small>Just now</small>
                            </div>
                            <p class="mb-1">Track applications and new job opportunities from one place.</p>
                        </a>
                        <a class="list-group-item list-group-item-action" href="{{ route('client.documents') }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Documents</h6>
                                <small>Today</small>
                            </div>
                            <p class="mb-1">Upload your documents to complete your applicant profile.</p>
                        </a>
                        <a class="list-group-item list-group-item-action" href="{{ route('client.profile') }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Profile completion</h6>
                                <small>Today</small>
                            </div>
                            <p class="mb-1">Keep your profile details current for better visibility.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
