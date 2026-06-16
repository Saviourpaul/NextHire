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
                    @php
                        $requiresApplicantProfile = $user->isApplicant();
                        $requiredMark = $requiresApplicantProfile ? ' *' : '';
                        $originalProfile = [
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'username' => $user->username,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'date_of_birth' => $user->date_of_birth?->format('Y-m-d'),
                            'address' => $user->address,
                            'country' => $user->country,
                            'state' => $user->state,
                            'city' => $user->city,
                            'zipcode' => $user->zipcode,
                            'profile_image_src' => $user->profileImageUrl(),
                            'profile_image_path' => $user->profile_image_path,
                        ];
                    @endphp

                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="col-md-12 col-lg-12">
                            <div class="pro-form-img">
                                <div class="profile-pic">
                                    
                                    <img id="profile-image-preview" class="rounded-circle" src="{{ $user->profileImageUrl() }}" alt="Profile image" width="100" height="100" style="object-fit: cover;">
                                </div>

                                <div class="upload-files">
                                    <label class="file-upload image-upbtn">
                                        <i class="feather-upload me-2"></i>Upload Photo
                                        <input id="profile-image-input" type="file" name="profile_image" class="form-control mt-2" accept="image/*" @required($requiresApplicantProfile && ! $user->profile_image_path) disabled>
                                    </label>
                                    <span>For better preview recommended size is 450px x 450px. Max size 5mb.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Phone Number{{ $requiredMark }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" @required($requiresApplicantProfile) readonly>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth{{ $requiredMark }}</label>
                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" @required($requiresApplicantProfile) readonly>
                        </div>
                        <div class="form-group">
                            <label>Address{{ $requiredMark }}</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" @required($requiresApplicantProfile) readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country{{ $requiredMark }}</label>
                                    <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}" @required($requiresApplicantProfile) readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State{{ $requiredMark }}</label>
                                    <input type="text" name="state" class="form-control" value="{{ old('state', $user->state) }}" @required($requiresApplicantProfile) readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City{{ $requiredMark }}</label>
                                    <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" @required($requiresApplicantProfile) readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zipcode{{ $requiredMark }}</label>
                                    <input type="text" name="zipcode" class="form-control" value="{{ old('zipcode', $user->zipcode) }}" @required($requiresApplicantProfile) readonly>
                                </div>
                            </div>
                        </div>

                        <button id="edit-profile-button" type="button" class="btn btn-primary">Update Profile</button>
                        <div id="profile-actions" class="d-none mt-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button id="cancel-profile-edit" type="button" class="btn btn-secondary ms-2">Cancel</button>
                        </div>
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

    @push('scripts')
        <script>
            (function () {
                const form = document.getElementById('profile-form');
                const editButton = document.getElementById('edit-profile-button');
                const cancelButton = document.getElementById('cancel-profile-edit');
                const profileActions = document.getElementById('profile-actions');
                const profileImageInput = document.getElementById('profile-image-input');
                const profileImagePreview = document.getElementById('profile-image-preview');
                const originalProfile = @json($originalProfile);

                if (!form) {
                    return;
                }

                const setReadonly = (readonly) => {
                    form.querySelectorAll('input').forEach((field) => {
                        if (field.name === 'profile_image') {
                            field.disabled = readonly;
                            return;
                        }

                        field.readOnly = readonly || field.name === 'email';
                    });
                };

                const resetToOriginalValues = () => {
                    form.querySelectorAll('input').forEach((field) => {
                        if (!originalProfile.hasOwnProperty(field.name)) {
                            return;
                        }

                        field.value = originalProfile[field.name] || '';
                    });

                    if (profileImageInput) {
                        profileImageInput.value = '';
                    }

                    if (profileImagePreview) {
                        profileImagePreview.src = originalProfile.profile_image_src;
                    }
                };

                setReadonly(true);

                editButton?.addEventListener('click', () => {
                    editButton.classList.add('d-none');
                    profileActions?.classList.remove('d-none');
                    setReadonly(false);
                    profileImageInput?.focus();
                });

                cancelButton?.addEventListener('click', () => {
                    resetToOriginalValues();
                    setReadonly(true);
                    editButton?.classList.remove('d-none');
                    profileActions?.classList.add('d-none');
                });

                profileImageInput?.addEventListener('change', () => {
                    const file = profileImageInput.files?.[0];

                    if (!file || !profileImagePreview) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = () => {
                        profileImagePreview.src = reader.result;
                    };

                    reader.readAsDataURL(file);
                });
            })();
        </script>
    @endpush
</x-admin-layout>
