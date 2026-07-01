<x-app title="Services - NextHire">
	@include('partials.public-breadcrumb', ['title' => 'Our Services'])

	<section class="section about">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10 text-center aos" data-aos="fade-up">
					<div class="about-content">
						<h2>Recruitment Solutions for Every Sector</h2>
						<p>NextHire delivers tailored recruitment services for government agencies, private organizations, employers, and job seekers. Our platform supports permanent, contract, and freelance hiring models with the same level of professionalism and transparency.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section projects" id="government">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 aos" data-aos="fade-up">
					<div class="demand-professional">
						<h2>Government & Public Sector Recruitment</h2>
						<p>Manage public sector hiring with structured workflows designed for transparency, compliance, and accountability.</p>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Publish approved vacancies with defined eligibility criteria and application deadlines.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Review applications with document verification and structured candidate profiles.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Maintain audit-ready records of every stage in the recruitment process.</p></div>
					</div>
				</div>
				<div class="col-lg-6 aos" data-aos="zoom-in">
					<img src="{{ asset('assets/img/blog/aboutus.jpg') }}" class="img-fluid rounded" alt="Government recruitment services">
				</div>
			</div>
		</div>
	</section>

	<section class="section review" id="private">
		<div class="container">
			<div class="row align-items-center flex-row-reverse">
				<div class="col-lg-6 aos" data-aos="fade-up">
					<div class="demand-professional">
						<h2>Private Organization Hiring</h2>
						<p>Scale your workforce with access to a verified talent pool and tools that simplify every stage of private sector recruitment.</p>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Post and manage job listings across departments and business units.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Shortlist, approve, or reject candidates with clear status communication.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Reduce time-to-hire with centralized application management and notifications.</p></div>
					</div>
				</div>
				<div class="col-lg-6 aos" data-aos="zoom-in">
					<img src="{{ asset('assets/img/work1.jpg') }}" class="img-fluid rounded" alt="Private sector hiring">
				</div>
			</div>
		</div>
	</section>

	<section class="section projects" id="employers">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 aos" data-aos="fade-up">
					<div class="demand-professional">
						<h2>Employer Services</h2>
						<p>Empower your HR team with a dedicated employer dashboard for end-to-end vacancy and candidate management.</p>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Create and publish job postings with detailed descriptions and requirements.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Review applied, approved, and rejected candidates from a single dashboard.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Access applicant profiles and supporting documents for informed decisions.</p></div>
					</div>
				</div>
				<div class="col-lg-6 aos" data-aos="zoom-in">
					<img src="{{ asset('assets/img/work2.jpg') }}" class="img-fluid rounded" alt="Employer recruitment dashboard">
				</div>
			</div>
		</div>
	</section>

	<section class="section review" id="job-seekers">
		<div class="container">
			<div class="row align-items-center flex-row-reverse">
				<div class="col-lg-6 aos" data-aos="fade-up">
					<div class="demand-professional">
						<h2>Job Seeker Services</h2>
						<p>Take control of your career with a professional applicant portal designed to simplify job discovery and application tracking.</p>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Browse verified job openings from government and private sector employers.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Submit applications with a guided profile and document upload workflow.</p></div>
					</div>
					<div class="demand-post-job align-items-start">
						<div class="demand-post-img"><img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid"></div>
						<div class="demand-content"><p>Track application status and receive notifications at every stage.</p></div>
					</div>
				</div>
				<div class="col-lg-6 aos" data-aos="zoom-in">
					<img src="{{ asset('assets/img/work3.jpg') }}" class="img-fluid rounded" alt="Job seeker using NextHire">
				</div>
			</div>
		</div>
	</section>

	<section class="section projects" id="contract">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 mx-auto text-center aos" data-aos="fade-up">
					<div class="section-header">
						<h2 class="header-title">Contract & Freelance Recruitment</h2>
						<p>NextHire also supports contract-based and freelance hiring, giving organizations flexibility to engage professionals for project-specific and short-term engagements.</p>
					</div>
				</div>
			</div>
			<div class="row row-gap mt-4">
				@foreach([
					['title' => 'Contract Roles', 'text' => 'Post fixed-term and project-based vacancies with clear scope, duration, and deliverables.'],
					['title' => 'Freelance Opportunities', 'text' => 'Connect with skilled professionals available for consultancy and freelance engagements.'],
					['title' => 'Flexible Hiring Models', 'text' => 'Adapt recruitment workflows to permanent, contract, or hybrid employment arrangements.'],
				] as $index => $service)
				<div class="col-md-4 aos d-flex" data-aos="zoom-in" data-aos-duration="{{ 1000 + ($index * 500) }}">
					<div class="feature-items d-flex align-items-center justify-content-center flex-column w-100">
						<div class="feature-content course-count text-center">
							<h3>{{ $service['title'] }}</h3>
							<p>{{ $service['text'] }}</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>

	@include('partials.public-cta')
</x-app>
