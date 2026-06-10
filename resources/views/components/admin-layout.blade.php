@props(['title' => 'Admin Dashboard'])

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>{{ $title }}</title>

	<link rel="shortcut icon" href="{{ asset('admin/assets/img/favicon.png') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/css/feather.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/datatables/datatables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote-lite.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
	@stack('styles')
</head>
<body>
	<div class="main-wrapper">
		@php
			$currentUser = auth()->user();
		@endphp
		<div class="header">
			<div class="header-left">
				<a href="{{ route('dashboard') }}" class="logo">
					<img src="{{ asset('admin/assets/img/logo.png') }}" alt="Logo">
				</a>
				<a href="{{ route('dashboard') }}" class="logo logo-small">
					<img src="{{ asset('admin/assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
				</a>
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="feather-chevrons-left"></i>
				</a>
				<a class="mobile_btn" id="mobile_btn">
					<i class="feather-chevrons-left"></i>
				</a>
			</div>

			<div class="top-nav-search">
				<form>
					<input type="text" class="form-control" placeholder="Start typing your Search...">
					<button class="btn" type="submit"><i class="feather-search"></i></button>
				</form>
			</div>

			<ul class="nav user-menu">
				<li class="nav-item dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<i class="feather-bell"></i> <span class="badge badge-pill">5</span>
					</a>
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header">
							<span class="notification-title">Notifications</span>
							<a href="javascript:void(0)" class="clear-noti">Clear All</a>
						</div>
						<div class="noti-content">
							<ul class="notification-list">
								<li class="notification-message">
									<a href="javascript:void(0);">
										<div class="media d-flex">
											<span class="avatar avatar-sm flex-shrink-0">
												<img class="avatar-img rounded-circle" alt="Img" src="{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}">
											</span>
											<div class="media-body flex-grow-1">
												<p class="noti-details"><span class="noti-title">New admin notification</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="javascript:void(0);">View all Notifications</a>
						</div>
					</div>
				</li>

				<li class="nav-item dropdown has-arrow main-drop">
					<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<span class="user-img">
							<img src="{{ auth()->user()->profileImageUrl() }}" alt="{{ auth()->user()->first_name }}">
							<span class="status online"></span>
						</span>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-feather="user" class="me-1"></i> Profile</a>
						<a class="dropdown-item" href="javascript:void(0);"><i data-feather="settings" class="me-1"></i> Settings</a>
						<form action="{{ route('logout') }}" method="POST">
							@csrf
							<button type="submit" class="dropdown-item"><i data-feather="log-out" class="me-1"></i> Logout</button>
						</form>
					</div>
				</li>
			</ul>
		</div>

		<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="menu-title"><span>Main</span></li>
						<li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
							<a href="{{ route('dashboard') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
						</li>
						@if ($currentUser?->isAdmin())
							<li class="submenu">
									<a href="javascript:void(0);"><i data-feather="users"></i> <span>User Management</span> <span class="menu-arrow"></span></a>
									<ul>
										<li><a href="{{ route('applicants') }}">Applicants</a></li>
										<li><a href="{{ route('Employers') }}">Employers</a></li>
										<li><a href="{{ route('administrators') }}">Administrators</a></li>
										<li><a href="{{ route('user-verification') }}">Approved Users</a></li>
										<li><a href="{{ route('suspended-accounts') }}">Suspended Accounts</a></li>
									</ul>
							</li>
						@endif
						@if ($currentUser?->isAdmin() || $currentUser?->isEmployer())
							<li class="submenu">
									<a href="javascript:void(0);"><i data-feather="align-justify"></i> <span>Job Management</span> <span class="menu-arrow"></span></a>
									<ul>
										@if ($currentUser?->isEmployer())
											<li><a href="{{ route('jobs') }}">All Jobs</a></li>
										@endif
										@if ($currentUser?->isAdmin())
											<li><a href="{{ route('approved-jobs') }}">Approved Jobs</a></li>
											<li><a href="{{ route('rejected-jobs') }}">Rejected Jobs</a></li>
											<li><a href="{{ route('pending-jobs') }}">Pending Jobs</a></li>
										@endif
									</ul>
								</li>
						@endif
						
						@if ($currentUser?->isAdmin())
							<li class="submenu">
								<a href="javascript:void(0);"><i data-feather="user-check"></i> <span>Recruitment Tools</span><span class="Tmenu-arrow"></span></a>
								<ul>
									<li><a href="{{ route('assessment-templates') }}">Assessment Templates</a></li>
										<li><a href="{{ route('interview-templates') }}">Interview Templates</a></li>
										<li><a href="{{ route('email-templates') }}">Email Templates</a></li>
								</ul>
							</li>
							<li><a href="javascript:void(0);"><i data-feather="pie-chart"></i> <span>Reports</span></a></li>

							<li class="submenu">
								<a href="javascript:void(0);"><i data-feather="settings"></i> <span>Settings</span><span class="menu-arrow"></span></a>
								<ul>
									<li><a href="{{ route('general-settings') }}">General Settings</a></li>
										<li><a href="{{ route('email-configuration') }}">Email Configuration</a></li>
										<li><a href="{{ route('notifications') }}">Notifications</a></li>
										<li><a href="{{ route('permission-management') }}">Permission Management</a></li>
								</ul>
							</li>
						@endif
						
						</ul>
				</div>
			</div>
		</div>

		<div class="page-wrapper">
			<div class="content container-fluid">
				{{ $slot }}
			</div>
		</div>
	</div>

	<script src="{{ asset('admin/assets/js/jquery-3.7.1.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/summernote/dist/summernote-lite.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/script.js') }}"></script>
		
	@stack('scripts')
</body>
</html>
