@use('Illuminate\Support\Str')

<x-app title="NextHire - Professional Job Recruitment Portal">
	<section class="section home-banner row-middle">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-8 col-lg-7">
					<div class="banner-content aos" data-aos="fade-up" data-aos-duration="3000">
						<div class="rating">
							<i class="fas fa-star checked"></i>
							<i class="fas fa-star checked"></i>
							<i class="fas fa-star checked"></i>
							<i class="fas fa-star checked"></i>
							<i class="fas fa-star checked"></i>
							<h5>Trusted by organizations nationwide</h5>
						</div>
						<h1>Find Your Next <span class="orange-text"><br>Career Opportunity</span></h1>
						<p>NextHire connects government agencies, private organizations, and employers with qualified professionals through a secure, modern recruitment platform.</p>
						<form class="form" method="get" action="{{ route('jobs.public') }}">
							<div class="form-inner">
								<div class="input-group">
									<span class="drop-detail">
										<select class="form-control select" name="category">
											<option value="">All Categories</option>
											<option value="government">Government</option>
											<option value="private">Private Sector</option>
											<option value="contract">Contract</option>
											<option value="freelance">Freelance</option>
										</select>
									</span>
									<input type="text" class="form-control" name="search" placeholder="Job title, keyword, or organization">
									<button class="btn btn-primary sub-btn" type="submit">Search Jobs</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-4 col-lg-5">
					<div class="banner-img aos" data-aos="zoom-in" data-aos-duration="3000">
						<img src="{{ asset('assets/img/banner-img.svg') }}" class="img-fluid" alt="NextHire recruitment platform">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section news">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-header text-center aos" data-aos="fade-up">
						<h2 class="header-title">Latest Job Openings</h2>
					</div>
				</div>
			</div>
			<div class="row blog-grid-row g-4">
				@forelse($jobs->take(3) as $job)
				<div class="col-xl-4 col-md-6 col-sm-12 d-flex">
					<div class="blog grid-blog aos flex-fill w-100" data-aos="fade-up">
						<div class="blog-image">
							<a href="{{ route('job-details', $job) }}"><img class="img-fluid w-100" src="{{ $job->logoUrl() }}" alt="{{ $job->company }} logo" style="height: 220px; object-fit: contain;"></a>
						</div>
						<div class="blog-content d-flex flex-column h-100">
							<ul class="entry-meta meta-item mb-2">
								<li class="mb-0">
									<div class="post-author">
										<a href="{{ route('job-details', $job) }}"><span>{{ $job->company }}</span></a>
									</div>
								</li>
								<li><i class="feather-calendar me-1"></i> {{ $job->created_at->format('d M Y') }}</li>
							</ul>
							<div class="blog-read mt-auto">
								<a href="{{ route('job-details', $job) }}">Apply Now <i class="fas fa-arrow-right ms-1"></i></a>
							</div>
							<h3 class="blog-title"><a href="{{ route('job-details', $job) }}">{{ $job->title }}</a></h3>
							<p class="mb-0 flex-grow-1">{{ Str::limit(strip_tags($job->description), 150) }}</p>
						</div>
					</div>
				</div>
				@empty
				<div class="col-12 text-center">
					<p>No active job listings at the moment. Check back soon or register to be notified when new roles are posted.</p>
				</div>
				@endforelse
			</div>
			<div class="row mt-4">
				<div class="col-12 text-center">
					<a href="{{ route('jobs.public') }}" class="btn btn-primary">View All Jobs</a>
				</div>
			</div>
		</div>
	</section>

	<section class="section review">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12 mx-auto text-center">
					<div class="section-header aos" data-aos="fade-up">
						<h2 class="header-title">Recruitment Categories</h2>
						<p>Opportunities across public, private, and contract-based employment</p>
					</div>
				</div>
				<div class="row">
					@foreach([
						['icon' => 'categories1.svg', 'title' => 'Government & Public Sector', 'count' => '120+ Open Roles'],
						['icon' => 'categories7.svg', 'title' => 'Private Organizations', 'count' => '350+ Open Roles'],
						['icon' => 'categories3.svg', 'title' => 'Healthcare & Education', 'count' => '85+ Open Roles'],
						['icon' => 'categories4.svg', 'title' => 'Finance & Administration', 'count' => '95+ Open Roles'],
						['icon' => 'categories5.svg', 'title' => 'Engineering & Technical', 'count' => '70+ Open Roles'],
						['icon' => 'categories6.svg', 'title' => 'Contract & Project Roles', 'count' => '60+ Open Roles'],
						['icon' => 'categories7.svg', 'title' => 'IT & Digital Services', 'count' => '110+ Open Roles'],
						['icon' => 'categories8.svg', 'title' => 'Freelance & Consultancy', 'count' => '45+ Open Roles'],
					] as $index => $category)
					<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="{{ 1000 + ($index * 500) }}">
						<div class="popular-catergories">
							<div class="popular-catergories-img">
								<span><img src="{{ asset('assets/img/icon/'.$category['icon']) }}" alt="{{ $category['title'] }}"></span>
							</div>
							<div class="popular-catergories-content">
								<h5>{{ $category['title'] }}</h5>
								<a href="{{ route('jobs.public') }}">{{ $category['count'] }}<i class="feather-arrow-right ms-2"></i></a>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>

	<section class="section news pt-0 review-set">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="work-box bg1" data-aos="zoom-in" data-aos-duration="1000">
						<div class="work-content">
							<h2>Hiring for Your <span>Organization?</span></h2>
							<p>Post vacancies, manage applications, and shortlist qualified candidates through a streamlined recruitment workflow.</p>
							<a href="{{ route('services') }}#employers" class="btn btn-primary">Employer Solutions</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="work-box aos bg2" data-aos="zoom-in" data-aos-duration="2000">
						<div class="work-content">
							<h2>Looking for Your <span>Next Role?</span></h2>
							<p>Create your profile, apply to verified jobs, and track your application status from one secure portal.</p>
							<a href="{{ route('register') }}" class="btn btn-primary">Start Applying</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section projects pt-0">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12 mx-auto text-center">
					<div class="section-header aos" data-aos="fade-up">
						<h2 class="header-title">Platform at a Glance</h2>
						<p>At NextHire, we believe that talent is borderless and opportunity should be too.</p>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="1000">
					<div class="feature-item freelance-count">
						<div class="feature-icon">
							<img src="{{ asset('assets/img/icon/achievement-1.svg') }}" class="img-fluid" alt="Registered applicants">
						</div>
						<div class="feature-content course-count">
							<h3 class="counter-up">50000</h3>
							<p>Registered Applicants</p>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="1500">
					<div class="feature-item">
						<div class="feature-icon">
							<img src="{{ asset('assets/img/icon/achievement-2.svg') }}" class="img-fluid" alt="Shortlisted candidates">
						</div>
						<div class="feature-content course-count">
							<h3><span class="counter-up">8368</span></h3>
							<p>Shortlisted Candidates</p>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="2000">
					<div class="feature-item comp-project">
						<div class="feature-icon">
							<img src="{{ asset('assets/img/icon/achievement-3.svg') }}" class="img-fluid" alt="Approved jobs">
						</div>
						<div class="feature-content course-count">
							<h3 class="counter-up">9198</h3>
							<p>Approved Jobs</p>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="2500">
					<div class="feature-item comp-project">
						<div class="feature-icon">
							<img src="{{ asset('assets/img/icon/achievement-4.svg') }}" class="img-fluid" alt="Registered organizations">
						</div>
						<div class="feature-content course-count">
							<h3 class="counter-up">998</h3>
							<p>Registered Organizations</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section review">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="work-set-image">
						<div class="work-set">
							<div class="recent-pro-img aos" data-aos="zoom-in" data-aos-duration="1000">
								<img src="{{ asset('assets/img/work1.jpg') }}" alt="Recruitment professionals collaborating" class="img-fluid">
							</div>
						</div>
						<div class="work-sets">
							<div class="recent-pro-img">
								<img src="{{ asset('assets/img/work2.jpg') }}" alt="Job interview process" class="img-fluid mb-2 aos" data-aos="zoom-in" data-aos-duration="2000">
								<img src="{{ asset('assets/img/work3.jpg') }}" alt="Team reviewing applications" class="img-fluid aos" data-aos="zoom-in" data-aos-duration="2500">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="aos" data-aos="fade-up">
						<div class="demand-professional">
							<h2>A Smarter Way to Recruit and Apply</h2>
							<p>NextHire simplifies every stage of the hiring journey — from job posting and application review to candidate shortlisting and onboarding.</p>
						</div>
						<div class="demand-post-job">
							<div class="demand-post-img">
								<img src="{{ asset('assets/img/recent-icon-01.svg') }}" alt="Post a job" class="img-fluid">
							</div>
							<div class="demand-content">
								<h6>Post & Manage Vacancies</h6>
								<p>Employers and agencies publish approved job listings with detailed requirements, deadlines, and application guidelines.</p>
							</div>
						</div>
						<div class="demand-post-job">
							<div class="demand-post-img">
								<img src="{{ asset('assets/img/recent-icon-02.svg') }}" alt="Review applications" class="img-fluid">
							</div>
							<div class="demand-content">
								<h6>Review & Shortlist Candidates</h6>
								<p>Access structured applications, verified documents, and candidate profiles to make informed hiring decisions faster.</p>
							</div>
						</div>
						<div class="demand-post-job">
							<div class="demand-post-img">
								<img src="{{ asset('assets/img/recent-icon-03.svg') }}" alt="Track progress" class="img-fluid">
							</div>
							<div class="demand-content">
								<h6>Track Every Stage</h6>
								<p>Both applicants and recruiters receive real-time updates on application status, approvals, and next steps.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section testimonial-section review">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-header aos text-center" data-aos="fade-up">
						<h2 class="header-title">What Our Users Say</h2>
						<p>Trusted by job seekers, employers, and public sector organizations</p>
					</div>
				</div>
			</div>
			<div class="testimonial-slider aos" data-aos="fade-up">
				@foreach([
					['name' => 'Adaeze Okonkwo', 'role' => 'HR Manager, Private Sector', 'text' => 'NextHire has transformed how we manage recruitment. The application tracking and document verification features save our team hours every week.', 'rating' => '4.9'],
					['name' => 'Emmanuel Bassey', 'role' => 'Job Applicant', 'text' => 'I found my current role through NextHire. The platform is easy to use, and I could track my application status at every stage.', 'rating' => '5.0'],
					['name' => 'Dr. Fatima Yusuf', 'role' => 'Public Sector Recruiter', 'text' => 'The structured workflow and role-based access controls make NextHire ideal for government recruitment processes that require transparency and accountability.', 'rating' => '4.8'],
					['name' => 'Chinedu Eze', 'role' => 'Employer', 'text' => 'From posting vacancies to shortlisting candidates, NextHire gives us everything we need in one professional platform.', 'rating' => '4.7'],
				] as $index => $testimonial)
				<div class="review-slide">
					<div class="review-blog">
						<div class="review-top d-flex align-items-center">
							<div class="review-img">
								<img class="img-fluid" src="{{ asset('assets/img/review/review-0'.(($index % 3) + 1).'.jpg') }}" alt="{{ $testimonial['name'] }}">
							</div>
							<div class="review-info">
								<h3>{{ $testimonial['name'] }}</h3>
								<h5>{{ $testimonial['role'] }}</h5>
							</div>
							<div class="test-quote-img">
								<img class="img-fluid" src="{{ asset('assets/img/test-quote.svg') }}" alt="Quote">
							</div>
						</div>
						<div class="review-content">
							<p>{{ $testimonial['text'] }}</p>
							<div class="rating">
								@for($i = 0; $i < 4; $i++)
								<i class="fas fa-star filled"></i>
								@endfor
								<i class="fas fa-star"></i>
								<span class="average-rating">{{ $testimonial['rating'] }}</span>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>

	<section class="section projects">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-12 mx-auto">
					<div class="section-header text-center aos" data-aos="fade-up">
						<h2 class="header-title">Trusted by Leading Organizations</h2>
						<p>Public and private sector partners rely on NextHire for professional recruitment</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="best-company aos" data-aos="fade-up">
						<ul class="mb-0">
							@for($i = 1; $i <= 6; $i++)
							<li>
								<div class="company-bestimg">
									<img src="{{ asset('assets/img/company/theme-'.$i.'.png') }}" alt="Partner organization {{ $i }}">
								</div>
							</li>
							@endfor
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('partials.public-cta')
</x-app>
