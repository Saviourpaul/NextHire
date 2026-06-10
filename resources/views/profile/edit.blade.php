<x-admin-layout title="Profile">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Profile</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">Profile updated.</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @php
                            $requiresApplicantProfile = $user->isApplicant();
                            $requiredMark = $requiresApplicantProfile ? ' *' : '';
                        @endphp
                        <div class="form-group">
                            <label>Profile Image{{ $requiredMark }}</label>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <img class="rounded-circle" src="{{ $user->profileImageUrl() }}" alt="Profile image" width="72" height="72" style="object-fit: cover;">
                                <input type="file" name="profile_image" class="form-control" accept="image/*" @required($requiresApplicantProfile && ! $user->profile_image_path)>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Phone Number{{ $requiredMark }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" @required($requiresApplicantProfile)>
                        </div>
                        <div class="form-group">
                            <label>Address{{ $requiredMark }}</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" @required($requiresApplicantProfile)>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country{{ $requiredMark }}</label>
                                    <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}" @required($requiresApplicantProfile)>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State{{ $requiredMark }}</label>
                                    <input type="text" name="state" class="form-control" value="{{ old('state', $user->state) }}" @required($requiresApplicantProfile)>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City{{ $requiredMark }}</label>
                                    <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" @required($requiresApplicantProfile)>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zipcode{{ $requiredMark }}</label>
                                    <input type="text" name="zipcode" class="form-control" value="{{ old('zipcode', $user->zipcode) }}" @required($requiresApplicantProfile)>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Delete Account</h5>
                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password', 'userDeletion')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
