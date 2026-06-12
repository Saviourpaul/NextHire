<x-app :title="$job->title . ' - NextHire'">
			<!-- Breadcrumb -->
			<div class="bread-crumb-bar">
				<div class="container">
					<div class="row align-items-center inner-banner">
						<div class="col-md-12 col-12 text-center">
							<div class="breadcrumb-list">
								<h2>Job Details</h2>
								<nav aria-label="breadcrumb" class="page-breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
										<li class="breadcrumb-item" aria-current="page">{{ $job->title }}</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">	
					<div class="row">
						<div class="col-lg-8 col-md-12">
							<div class="company-detail-block pt-0">
								<div class="company-detail">
									<div class="company-detail-image">
										<img src="{{ $job->logoUrl() }}" class="img-fluid" alt="{{ $job->company }} logo">
									</div>
									<div class="company-title">
										<p>{{ $job->company }}</p>
										<h4>{{ $job->title }}</h4>
									</div>
								</div>
								<div class="company-address">
									<ul>
										
										<li>
											<i class="feather-calendar"></i>{{ $job->created_at->format('d F Y') }}
										</li>
										<li>
											<i class="feather-calendar"></i>Due: {{ $job->due_date->format('d F Y') }}
										</li>
										<li>
											<i class="feather-edit-2"></i>Status: {{ ucfirst($job->status) }}
										</li>
									</ul>
								</div>
								<!--div class="project-proposal-detail">
									<ul>
										<li>
											<div class="proposal-detail-img">
												<img src="{{ asset('assets/img/icon/computer-line.svg') }}" alt="icons">
											</div>
											<div class="proposal-detail text-capitalize">
												<span class=" d-block">Freelancer Type</span>
												<p class="mb-0">Full Time</p>
											</div>
										</li>
										<li>
											<div class="proposal-detail-img">
												<img src="{{ asset('assets/img/icon/time-line.svg') }}" alt="icons">
											</div>
											<div class="proposal-detail text-capitalize">
												<span class=" d-block">Project Type</span>
												<p class="mb-0">Hourly</p>
											</div>
										</li>
										<li>
											<div class="proposal-detail-img">
												<img src="{{ asset('assets/img/icon/time-line.svg') }}" alt="icons">
											</div>
											<div class="proposal-detail text-capitalize">
												<span class=" d-block">Project Duration</span>
												<p class="mb-0">10-15 Hours</p>
											</div>
										</li>
										<li>
											<div class="proposal-detail-img">
												<img src="{{ asset('assets/img/icon/user-heart-line.svg') }}" alt="icons">
											</div>
											<div class="proposal-detail text-capitalize">
												<span class=" d-block">Experience</span>
												<p class="mb-0">Basic</p>
											</div>
										</li>
										<li>
											<div class="proposal-detail-img">
												<img src="{{ asset('assets/img/icon/translate-2.svg') }}" alt="icons">
											</div>
											<div class="proposal-detail text-capitalize">
												<span class=" d-block">Languages</span>
												<p class="mb-0">English, Arabic</p>
											</div>
										</li>
										<li>
											<div class="proposal-detail-img">
												<img src="{{ asset('assets/img/icon/translate.svg') }}" alt="icons">
											</div>
											<div class="proposal-detail text-capitalize">
												<span class=" d-block">Language Fluency</span>
												<p class="mb-0">Conversational</p>
											</div>
										</li>
									</ul>
								</div-->
							</div>
							<div class="company-detail-block company-description">
								<h4 class="company-detail-title">Description</h4>
								{!! $job->description !!}
							</div>
							
							
							
						</div>
					
						<!-- Blog Sidebar -->
						<div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar project-client-view">	
							<div class="card budget-widget">
								<div class="login-btn">
									<h6>apply</h6>
									
								</div>
								
							</div>
							
						
						
						</div>
						<!-- /Blog Sidebar -->
						
					</div>
				</div>
			</div>		
			<!-- /Page Content -->
   
</x-app>
