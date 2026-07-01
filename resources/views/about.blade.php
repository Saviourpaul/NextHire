<x-app title="About Us - NextHire">
	@include('partials.public-breadcrumb', ['title' => 'About Us'])

	<section class="section about">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12 d-flex align-items-center aos" data-aos="fade-up">
					<div class="about-content">
						<h2>Empowering Recruitment for a Modern Workforce</h2>
						<p>NextHire is a professional job recruitment platform designed to connect government agencies, private organizations, employers, and job seekers through a secure, transparent, and efficient hiring system.</p>
						<p>We understand that effective recruitment requires more than a job board. That is why NextHire provides structured application workflows, document verification, role-based access controls, and real-time status tracking — giving every stakeholder the tools they need to hire and apply with confidence.</p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="about-content-img aos" data-aos="zoom-in">
						<img src="{{ asset('assets/img/blog/aboutus.jpg') }}" class="img-fluid" alt="NextHire recruitment team">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="about-content-img aos" data-aos="zoom-in">
						<img src="{{ asset('assets/img/blog/aboutus1.jpg') }}" class="img-fluid" alt="Professional job seekers using NextHire">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section projects">
		<div class="container">
			<div class="row row-gap">
				<div class="col-md-12 col-sm-12 col-12 mx-auto text-center">
					<div class="section-header aos" data-aos="fade-up">
						<h2 class="header-title">Why Choose NextHire?</h2>
						<p>A recruitment platform built for accountability, efficiency, and results</p>
					</div>
				</div>
				@foreach([
					['icon' => 'great1.svg', 'title' => 'Verified Opportunities', 'text' => 'Every job listing goes through an approval process to ensure legitimacy and compliance with organizational standards.'],
					['icon' => 'great2.svg', 'title' => 'Streamlined Applications', 'text' => 'Applicants submit structured profiles and documents through a guided workflow, reducing incomplete submissions and review delays.'],
					['icon' => 'great3.svg', 'title' => 'Secure & Compliant', 'text' => 'Role-based access, account verification, and document management protect sensitive applicant and organizational data.'],
					['icon' => 'great4.svg', 'title' => 'End-to-End Tracking', 'text' => 'From application submission to shortlisting, approval, and rejection — every stage is tracked and communicated transparently.'],
				] as $index => $feature)
				<div class="col-xl-3 col-md-6 aos d-flex" data-aos="zoom-in" data-aos-duration="{{ 1000 + ($index * 500) }}">
					<div class="feature-items d-flex align-items-center justify-content-center flex-column">
						<div class="feature-icon">
							<img src="{{ asset('assets/img/icon/'.$feature['icon']) }}" class="img-fluid" alt="{{ $feature['title'] }}">
						</div>
						<div class="feature-content course-count text-center">
							<h3>{{ $feature['title'] }}</h3>
							<p>{{ $feature['text'] }}</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>

	<section class="section review">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="aos" data-aos="fade-up">
						<div class="demand-professional">
							<h2>Built for Every Stakeholder in the Hiring Process</h2>
							<p>Whether you are a government agency managing public sector vacancies, a private company scaling your workforce, or a professional seeking your next opportunity, NextHire adapts to your recruitment needs.</p>
						</div>
						@foreach([
							'Government agencies can publish approved vacancies with structured compliance workflows.',
							'Private organizations gain access to a qualified talent pool with efficient shortlisting tools.',
							'Job seekers benefit from a single portal to discover, apply, and track opportunities across sectors.',
						] as $point)
						<div class="demand-post-job align-items-start">
							<div class="demand-post-img">
								<img src="{{ asset('assets/img/icon/checks.svg') }}" alt="Check" class="img-fluid">
							</div>
							<div class="demand-content">
								<p>{{ $point }}</p>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="col-lg-6">
					<div class="work-set-image">
						<div class="recent-pro-img aos" data-aos="zoom-in" data-aos-duration="1000">
							<img src="{{ asset('assets/img/blog/abt3.png') }}" alt="NextHire platform overview" class="img-fluid">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('partials.public-cta')
</x-app>
