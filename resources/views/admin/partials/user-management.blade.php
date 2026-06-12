@php
    $pageTitle = 'All ' . $title;
    $statusClasses = [
        'active' => 'bg-success-light',
        'pending' => 'bg-warning-light',
        'suspended' => 'bg-danger-light',
    ];

    $sortIcon = fn($column) => $sortColumn === $column ? ($sortDirection === 'asc' ? '↑' : '↓') : '↕';
    $sortUrl = fn($column) => request()->fullUrlWithQuery([
        'sort' => $column,
        'direction' => $sortColumn === $column && $sortDirection === 'asc' ? 'desc' : 'asc',
    ]);
@endphp

<div class="page-header subscribe-head">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">{{ $pageTitle }}</h3>
        </div>
        @if ($showCreate)
            <div class="col-auto">
                <button class="btn add-user" type="button" data-bs-toggle="modal" data-bs-target="#create-user">
                    <i class="fas fa-plus"></i> Add User
                </button>
                <br>
                <br>
                <div class="dt-search">
                    <form action="{{ url()->current() }}" method="GET">
                        <input type="search" class="dt-input" id="dt-search-0" name="name"
                            placeholder="Search users..." value="{{ request('name') }}"
                            aria-controls="DataTables_Table_0">
                        <button class="btn" type="submit"><i class="feather-search"></i></button>
                    </form>
                </div>

            </div>
        @endif
    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <div class="subscribe-employe users-list">
            <ul>
                <li class="active">{{ $pageTitle }}</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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

        <div class="card filter-card" id="filter_inputs">
            <div class="card-body pb-0">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Name / Keyword</label>
                                <input class="form-control" name="search" type="text"
                                    value="{{ request('search', request('name')) }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ request('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ request('email') }}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ request('phone') }}">
                        </div>
                    </div>
                    @unless ($roleConstraint)
                        <div class="col-sm-6 col-md-2">
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control form-select" name="role">
                                    <option value="">All</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->value }}" @selected(request('role') === $role->value)>
                                            {{ $role->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endunless
                    @unless ($statusConstraint)
                        <div class="col-sm-6 col-md-2">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control form-select" name="status">
                                    <option value="">All</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                                            {{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endunless
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-block">Clear</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Filter</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0 user-table">
                    <thead>
                        <tr>
                            <th class="align-middle">
                                <a href="{{ $sortUrl('created_at') }}" class="text-decoration-none">
                                    #<span class="ms-1">{{ $sortIcon('created_at') }}</span>
                                </a>
                            </th>
                            <th class="align-middle">
                                <a href="{{ $sortUrl('first_name') }}" class="text-decoration-none">
                                    Name<span class="ms-1">{{ $sortIcon('first_name') }}</span>
                                </a>
                            </th>
                            <th class="align-middle d-none d-sm-table-cell">
                                <a href="{{ $sortUrl('username') }}" class="text-decoration-none">
                                    Username<span class="ms-1">{{ $sortIcon('username') }}</span>
                                </a>
                            </th>
                            <th class="align-middle d-none d-md-table-cell">
                                <a href="{{ $sortUrl('email') }}" class="text-decoration-none">
                                    Email<span class="ms-1">{{ $sortIcon('email') }}</span>
                                </a>
                            </th>
                            <th class="align-middle d-none d-lg-table-cell">
                                <a href="{{ $sortUrl('phone') }}" class="text-decoration-none">
                                    Phone<span class="ms-1">{{ $sortIcon('phone') }}</span>
                                </a>
                            </th>
                            <th class="align-middle d-none d-xl-table-cell">Role</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle d-none d-xxl-table-cell">
                                <a href="{{ $sortUrl('created_at') }}" class="text-decoration-none">
                                    Joined<span class="ms-1">{{ $sortIcon('created_at') }}</span>
                                </a>
                            </th>
                            <th class="align-middle text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td class="align-middle">{{ $users->firstItem() + $loop->index }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img class="avatar-img rounded-circle me-2 d-none d-sm-inline-block"
                                            src="{{ $user->profileImageUrl() }}" alt="{{ $user->first_name }}"
                                            width="32" height="32" style="object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}
                                            </h6>
                                            <small class="text-muted d-sm-none">{{ $user->username }}</small>
                                            <small class="text-muted d-md-none">{{ $user->email }}</small>
                                            <small
                                                class="text-muted d-lg-none">{{ $user->phone ?: 'Not provided' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle d-none d-sm-table-cell">{{ $user->username }}</td>
                                <td class="align-middle d-none d-md-table-cell">{{ $user->email }}</td>
                                <td class="align-middle d-none d-lg-table-cell">
                                    {{ $user->phone ?: 'Not provided' }}</td>
                                <td class="align-middle d-none d-xl-table-cell">{{ $user->role->label() }}</td>
                                <td class="align-middle">
                                    <span class="badge {{ $statusClasses[$user->status->value] ?? 'bg-secondary' }}">
                                        {{ $user->status->label() }}
                                    </span>
                                </td>
                                <td class="align-middle d-none d-xxl-table-cell">
                                    {{ $user->created_at?->format('d M Y') }}</td>
                                <td class="align-middle text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if ($user->isApplicant() && auth()->user()->hasRole('admin', 'employer'))
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('applicants.profile.show', $user) }}">
                                                        <i data-feather="eye" class="me-2"></i> View Profile
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#edit-user-{{ $user->id }}">
                                                    <i data-feather="edit" class="me-2"></i> Edit
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.password-reset', $user) }}"
                                                    method="POST" class="d-grid">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">
                                                        <i data-feather="key" class="me-2"></i> Reset Password
                                                    </button>
                                                </form>
                                            </li>
                                            @if (!$user->is(auth()->user()) && !$user->isSuspended())
                                                <li>
                                                    <form action="{{ route('admin.users.suspend', $user) }}"
                                                        method="POST" class="d-grid">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="dropdown-item text-danger" type="submit">
                                                            <i data-feather="slash" class="me-2"></i> Suspend
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if ($user->isSuspended() || $user->isPending())
                                                <li>
                                                    <form action="{{ route('admin.users.activate', $user) }}"
                                                        method="POST" class="d-grid">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="dropdown-item text-success" type="submit">
                                                            <i data-feather="check-circle" class="me-2"></i>
                                                            Activate
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if (!$user->is(auth()->user()))
                                                <li>
                                                    <button class="dropdown-item text-danger mb-0" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete-user-{{ $user->id }}">
                                                        <i data-feather="trash-2" class="me-2"></i> Delete
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="mt-4">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

@if ($showCreate)
    <div class="modal fade custom-modal" id="create-user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-wrap">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control form-select" name="role" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->value }}" @selected($defaultRole === $role)>
                                        {{ $role->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control form-select" name="status" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" @selected($defaultStatus === $status)>
                                        {{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@foreach ($users as $user)
    <div class="modal fade custom-modal" id="edit-user-{{ $user->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-wrap">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $user->first_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $user->last_name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control"
                                value="{{ $user->username }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            @if ($user->is(auth()->user()))
                                <input type="hidden" name="role" value="{{ $user->role->value }}">
                            @endif
                            <select class="form-control form-select" name="role" @disabled($user->is(auth()->user()))
                                required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->value }}" @selected($user->role === $role)>
                                        {{ $role->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            @if ($user->is(auth()->user()))
                                <input type="hidden" name="status" value="{{ $user->status->value }}">
                            @endif
                            <select class="form-control form-select" name="status" @disabled($user->is(auth()->user()))
                                required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" @selected($user->status === $status)>
                                        {{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (!$user->is(auth()->user()))
        <div class="modal custom-modal fade" id="delete-user-{{ $user->id }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure you want to delete this user?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-primary continue-btn w-100">Delete</button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <button type="button" data-bs-dismiss="modal"
                                        class="btn btn-primary cancel-btn w-100">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
</div>
