@props(['bodyClass' => 'home-page bg-one', 'title' => 'NextHire'])
<!DOCTYPE html>
<html lang="en">
<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>{{ $title ?? 'NextHire' }}</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon" height="32" width="32">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
				
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
		
		<!-- Slick CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick-theme.css') }}">
		
		<link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

		<!-- Feather CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
		
		<!-- Aos CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/aos/aos.css') }}">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	</head>	
  <body class="{{ $bodyClass }}">
		
		<!-- Loader -->
		<!--div id="global-loader"  >
			<div class="whirly-loader"> </div>
			<div class="loader-img">
				<img src="{{ asset('assets/img/load-icon.svg') }}" class="img-fluid" alt="Img">
			</div>
		</div-->
		<!-- Loader -->
		
		<!-- Main Wrapper -->
		<div class="main-wrapper">
					
			<!-- Start Navigation -->
			<!-- Header -->
			<header class="header">
				<div class="container">
					<nav class="navbar navbar-expand-lg header-nav p-0">
						<div class="navbar-header">
							<a id="mobile_btn" href="javascript:void(0);">
								<span class="bar-icon">
									<span></span>
									<span></span>
									<span></span>
								</span>
							</a>
							<a href="/" class="navbar-brand logo">
								<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo" height="40" width="60">
							</a>
							
						</div>
						<div class="main-menu-wrapper">
							<div class="menu-header">
								<a href="/" class="menu-logo">
									<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo" height="30" width="60">
								</a>
								<a id="menu_close" class="menu-close" href="javascript:void(0);">
									<i class="fas fa-times"></i>
								</a>
							</div>
							<ul class="main-nav">
								<li class="{{ request()->is('/') ? 'active' : '' }}">
									<a href="/">Home</a>
								</li>
								<li class="{{ request()->is('find-jobs') ? 'active' : '' }}">
									<a href="{{ route('jobs.public') }}">Jobs</a>
								</li>
								<li class="{{ request()->is('about') ? 'active' : '' }}">
									<a href="/about">About</a>
								</li>
								<li class="{{ request()->is('contact') ? 'active' : '' }}">
									<a href="/contact">Contact</a>
								</li>
								
							
							</ul>
						</div>		 
						<ul class="nav header-navbar-rht reg-head">												
							@guest
							<li><a href="/login" class="log-btn"><img src="{{ asset('assets/img/icon/lock.svg') }}" class="me-1" alt="img"> Login</a></li>
							@endguest
							@auth
							<li class="nav-item dropdown ">
							<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
								<span class="user-img">
									<img src="{{ auth()->user()->profileImageUrl() }}" alt="{{ auth()->user()->first_name }}">
									<span class="status online"></span>
								</span>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-feather="user" class="me-1"></i> Profile</a>
								<form
									action="{{ route('logout') }}"
									method="POST"
									data-confirm
									data-confirm-title="Sign out?"
									data-confirm-text="Are you Sure You Want to Logout."
									data-confirm-button="Logout"
								>
									@csrf
									<button type="submit" class="dropdown-item"><i data-feather="log-out" class="me-1"></i> Logout</button>
								</form>
							</div>
				            </li>
							@endauth
            	         <li><a href="/register" class="login-btn"><img src="{{ asset('assets/img/icon/users.svg') }}" class="me-1" alt="img">Get Started</a></li>

						</ul>
					</nav>
				</div>
				
			</header>

      
			<!-- /Header -->		

			{{ $slot }}
		
			
			<!-- Footer -->	
			<footer class="footer">
				<div class="footer-top ">
					<div class="container">

						<div class="row">
							<div class=" col-lg-4 col-md-12">
								<div class="footer-bottom-logo">
									<a href="/" class="menu-logo">
										<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo" height="50" width="90">
									</a>
									<p>We’re always in search for talented and motivated people. Don’t be shy introduce yourself!</p>
									<ul>
										<li>
											<a href="javascript:void(0);"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="fa-brands fa-twitter" aria-hidden="true"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
										</li>
									</ul>
									<a href="javascript:void(0);" class="btn btn-connectus">Contact with us</a>
								</div>
							</div>
							<div class=" col-lg-8 col-md-12">
								<div class="row">
									<div class="col-xl-3 col-md-6">
										<div class="footer-widget footer-menu">
											<h2 class="footer-title">Useful Links</h2>
											<ul>
												<li><a href="about.html"><i class="fas fa-angle-right me-1"></i>About Us</a></li>
												<li><a href="blog-list.html"><i class="fas fa-angle-right me-1"></i>Blog</a></li>
												<li><a href="login.html"><i class="fas fa-angle-right me-1"></i>Login</a></li>
												<li><a href="register.html"><i class="fas fa-angle-right me-1"></i>Register</a></li>
												<li><a href="forgot-password.html"><i class="fas fa-angle-right me-1"></i>Forgot Password</a></li>
											</ul>
										</div>
									</div>
									<div class="col-xl-3 col-md-6">
										<div class="footer-widget footer-menu">
											<h2 class="footer-title">Help & Support</h2>
											<ul>
												<li><a href="javascript:void(0);"><i class="fas fa-angle-right me-1"></i>Browse Candidates</a></li>
												<li><a href="javascript:void(0);"><i class="fas fa-angle-right me-1"></i>Employers Dashboard</a></li>
												<li><a href="javascript:void(0);"><i class="fas fa-angle-right me-1"></i>Job Packages</a></li>
												<li><a href="javascript:void(0);"><i class="fas fa-angle-right me-1"></i>Jobs Featured</a></li>
												<li><a href="javascript:void(0);"><i class="fas fa-angle-right me-1"></i>Post A Job</a></li>
											</ul>
										</div>
									</div>
									<div class="col-xl-3 col-md-6">
										<div class="footer-widget footer-menu">
											<h2 class="footer-title">Other Links</h2>
											<ul>
												<li><a href="freelancer-dashboard.html"><i class="fas fa-angle-right me-1"></i>Freelancers</a></li>
												<li><a href="freelancer-portfolio.html"><i class="fas fa-angle-right me-1"></i>Freelancer Details</a></li>
												<li><a href="project.html"><i class="fas fa-angle-right me-1"></i>Project</a></li>
												<li><a href="project-details.html"><i class="fas fa-angle-right me-1"></i>Project Details</a></li>
												<li><a href="post-project.html"><i class="fas fa-angle-right me-1"></i>Post Project</a></li>
											</ul>
										</div>
									</div>
									<div class="col-xl-3 col-md-6">
										<div class="footer-widget footer-menu">
											<h2 class="footer-title">Connect With Us</h2>
											<ul>
												<li><a href="freelancer-chats.html"><i class="fas fa-angle-right me-1"></i>Chat</a></li>
												<li><a href="faq.html"><i class="fas fa-angle-right me-1"></i>Faq</a></li>
												<li><a href="freelancer-review.html"><i class="fas fa-angle-right me-1"></i>Reviews</a></li>
												<li><a href="privacy-policy.html"><i class="fas fa-angle-right me-1"></i>Privacy Policy</a></li>
												<li><a href="term-condition.html"><i class="fas fa-angle-right me-1"></i>Terms of use</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-12">
									<div class="copyright-text text-center">
										<script>document.write(new Date().getFullYear());</script> &copy; NextHire. All rights reserved.
									</div>
								</div>
							</div>
						</div>
						<!-- /Copyright -->						
					</div>
				</div>
				<!-- /Footer Bottom -->				
			</footer>
			<!-- /Footer -->
		
		</div>		
		<!-- /Main Wrapper -->
		<button class="scroll-top scroll-to-target" data-target="html">
			<span class="ti-angle-up"><img src="{{ asset('assets/img/icon/top-icon.svg') }}" class="img-fluid" alt="Img"></span>
		</button>
		<!-- jQuery -->
		<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
		
		<!-- Bootstrap Bundle JS -->
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

		<!-- counterup JS -->
		<script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
		
		<!-- Aos -->
		<script src="{{ asset('assets/plugins/aos/aos.js') }}"></script>
		
		<!-- Select2 JS -->
		<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/summernote/dist/summernote-lite.min.js') }}"></script>
		<!-- Slick JS -->
		<script src="{{ asset('assets/js/slick.js') }}"></script>

		<!-- Sticky Sidebar JS -->
		<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
		<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
		
		<!-- Custom JS -->
		<script src="{{ asset('assets/js/script.js') }}"></script>
		@include('components.sweet-alerts')
		<script src="{{ asset('assets/js/sweetalert.js') }}"></script>
		<script src="{{ asset('assets/js/app-alerts.js') }}"></script>
	</body>

</html>
