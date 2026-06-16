<x-admin-layout title="My Profile">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">My Profile</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @include('profile.partials.completion-tracker', ['user' => auth()->user()])

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Applicant Profile</h5>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input class="form-control" value="{{ trim(auth()->user()->first_name.' '.auth()->user()->last_name) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" value="{{ auth()->user()->phone }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location</label>
                                <input class="form-control" value="{{ collect([auth()->user()->city, auth()->user()->state, auth()->user()->country])->filter()->implode(', ') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary mt-3" href="{{ route('profile.edit') }}">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
