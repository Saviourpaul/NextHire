@props(['bodyClass' => 'home-page bg-one'])

<!DOCTYPE html>
<html lang="en">
<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>{{ $title ?? 'NextHire' }}</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
				
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
		
		
		<!-- Feather CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
		
		<!-- Aos CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/aos/aos.css') }}">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <!-- Date Tine Picker  CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <!-- Datatables CSS -->
		<link rel="stylesheet" href="{{ asset ('assets/plugins/datatables/datatables.min.css') }}">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	</head>	
  <body class="{{ $bodyClass }}">
		
		<!-- Loader -->
		<div id="global-loader"  >
			<div class="whirly-loader"> </div>
			<div class="loader-img">
				<img src="{{ asset('assets/img/load-icon.svg') }}" class="img-fluid" alt="Img">
			</div>
		</div>
		<!-- Loader -->
		
		<!-- Main Wrapper -->
		<div class="main-wrapper">
					
			<!-- Start Navigation -->
			<!-- Header -->
			<div class="header">
			
				<!-- Logo -->
				<div class="header-left">
					<a href="index.html" class="logo">
						<img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
					</a>
					<a href="index.html" class="logo logo-small">
						<img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
					</a>
					<!-- Sidebar Toggle -->
					<a href="javascript:void(0);" id="toggle_btn">
						<i class="feather-chevrons-left"></i>
					</a>
					<!-- /Sidebar Toggle -->
					
					<!-- Mobile Menu Toggle -->
					<a class="mobile_btn" id="mobile_btn">
						<i class="feather-chevrons-left"></i>
					</a>
					<!-- /Mobile Menu Toggle -->
				</div>
				<!-- /Logo -->
				
				<!-- Search -->
				<div class="top-nav-search">
					<form>
						<input type="text" class="form-control" placeholder="Start typing your Search...">
						<button class="btn" type="submit"><i class="feather-search"></i></button>
					</form>
				</div>
				<!-- /Search -->
				
				<!-- Header Menu -->
				<ul class="nav user-menu">

					<!-- Notifications -->
					<li class="nav-item dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<i class="feather-bell"></i> <span class="badge badge-pill">5</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti"> Clear All</a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="javascript:void(0);">
											<div class="media d-flex">
												<span class="avatar avatar-sm flex-shrink-0">
													<img class="avatar-img rounded-circle" alt="Img" src="{{ asset('assets/img/profiles/avatar-02.jpg') }} ">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Brian Johnson</span> paid the invoice <span class="noti-title">#DF65485</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="javascript:void(0);">
											<div class="media d-flex">
												<span class="avatar avatar-sm flex-shrink-0">
													<img class="avatar-img rounded-circle" alt="Img" src="{{ asset('assets/img/profiles/avatar-03.jpg') }}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Marie Canales</span> has accepted your estimate <span class="noti-title">#GTR458789</span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="javascript:void(0);">
											<div class="media d-flex">
												<div class="avatar avatar-sm flex-shrink-0">
													<span class="avatar-title rounded-circle bg-primary-light"><i class="far fa-user"></i></span>
												</div>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">New user registered</span></p>
													<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="javascript:void(0);">
											<div class="media d-flex">
												<span class="avatar avatar-sm flex-shrink-0">
													<img class="avatar-img rounded-circle" alt="Img" src="{{ asset('assets/img/profiles/avatar-04.jpg') }}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Barbara Moore</span> declined the invoice <span class="noti-title">#RDW026896</span></p>
													<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="javascript:void(0);">
											<div class="media d-flex">
												<div class="avatar avatar-sm flex-shrink-0">
													<span class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>
												</div>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">You have received a new message</span></p>
													<p class="noti-time"><span class="notification-time">2 days ago</span></p>
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
					<!-- /Notifications -->
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow main-drop">
						<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<span class="user-img">
								<img src="{{ asset('assets/img/profiles/avatar-07.jpg') }}" alt="Img">
								<span class="status online"></span>
							</span>
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="profile.html"><i data-feather="user" class="me-1"></i> Profile</a>
							<a class="dropdown-item" href="settings.html"><i data-feather="settings" class="me-1"></i> Settings</a>
							<a class="dropdown-item" href="login.html"><i data-feather="log-out" class="me-1"></i> Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Menu -->
				
			</div>

      
			<!-- /Header -->
           
			<!-- /Sidebar -->		

			{{ $slot }}
		
			
		
		</div>		
		<!-- /Main Wrapper -->
		<button class="scroll-top scroll-to-target" data-target="html">
			<span class="ti-angle-up"><img src="{{ asset('assets/img/icon/top-icon.svg') }}" class="img-fluid" alt="Img"></span>
		</button>
		<!-- jQuery -->
		<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		
		<!-- Feather Icon JS -->
		<script src="{{ asset('assets/js/feather.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		
		<!-- Slimscroll JS -->
		<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		
		<!-- Select2 JS -->
		<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		
		<!-- Datatables JS -->
		<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>

		<!-- Sticky Sidebar JS -->
		<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		
		<script src="https://cdn.jsdelivr.net/npm/apexcharts" type="18b84708be462f27f6eca174-text/javascript"></script>

		<!-- Custom JS -->
		<script src="{{ asset('assets/js/script.js') }}" type="18b84708be462f27f6eca174-text/javascript"></script>
		@include('components.sweet-alerts')
		<script src="{{ asset('assets/js/sweetalert.js') }}"></script>
		<script src="{{ asset('assets/js/app-alerts.js') }}"></script>

</body>

</html>
