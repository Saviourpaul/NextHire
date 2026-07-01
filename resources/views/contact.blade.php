<x-app title="Contact Us - NextHire" bodyClass="bg-one">
	@include('partials.public-breadcrumb', ['title' => 'Contact Us'])

	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-5">
					<div class="widget-box location-widget mb-4 aos" data-aos="fade-up">
						<div class="profile-head">
							<h4 class="pro-title">Get in Touch</h4>
						</div>
						<div class="profile-overview">
							<p>Have a question about NextHire, need support with your account, or want to discuss recruitment solutions for your organization? We are here to help.</p>
							<ul class="latest-posts">
								<li>
									<h6><i class="fas fa-envelope me-2 text-primary"></i> Email</h6>
									<p><a href="mailto:support@nexhire.com">support@nexhire.com</a></p>
								</li>
								<li>
									<h6><i class="fas fa-phone me-2 text-primary"></i> Phone</h6>
									<p><a href="tel:+2348000000000">+234 800 000 0000</a></p>
								</li>
								<li>
									<h6><i class="fas fa-map-marker-alt me-2 text-primary"></i> Office Address</h6>
									<p>12 Recruitment Avenue, Central Business District, Abuja, Nigeria</p>
								</li>
							</ul>
						</div>
					</div>

					<div class="widget-box working-days mb-4 aos" data-aos="fade-up" data-aos-delay="100">
						<div class="profile-head">
							<h4 class="pro-title">Business Hours</h4>
						</div>
						<ul class="latest-posts">
							<li class="justify-content-between">
								<h6>Monday – Friday</h6>
								<p>8:00 AM – 6:00 PM</p>
							</li>
							<li class="justify-content-between">
								<h6>Saturday</h6>
								<p>9:00 AM – 2:00 PM</p>
							</li>
							<li class="justify-content-between">
								<h6>Sunday & Public Holidays</h6>
								<p>Closed</p>
							</li>
						</ul>
					</div>
				</div>

				<div class="col-lg-7">
					<div class="widget-box aos" data-aos="fade-up">
						<div class="profile-head">
							<h4 class="pro-title">Send Us a Message</h4>
						</div>
						<div class="contact-btn">
							@if (session('success'))
								<div class="alert alert-success" role="alert">
									{{ session('success') }}
								</div>
							@endif

							<form method="POST" action="{{ route('contact.store') }}">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">Full Name <span class="text-danger">*</span></label>
											<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
											@error('name')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="email">Email Address <span class="text-danger">*</span></label>
											<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
											@error('email')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="phone">Phone Number</label>
											<input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
											@error('phone')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="inquiry_type">Inquiry Type <span class="text-danger">*</span></label>
											<select class="form-control @error('inquiry_type') is-invalid @enderror" id="inquiry_type" name="inquiry_type" required>
												<option value="">Select inquiry type</option>
												<option value="job_seeker" @selected(old('inquiry_type') === 'job_seeker')>Job Seeker</option>
												<option value="employer" @selected(old('inquiry_type') === 'employer')>Employer</option>
												<option value="government" @selected(old('inquiry_type') === 'government')>Government / Organization</option>
												<option value="general" @selected(old('inquiry_type') === 'general')>General Inquiry</option>
											</select>
											@error('inquiry_type')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="subject">Subject <span class="text-danger">*</span></label>
											<input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
											@error('subject')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="message">Message <span class="text-danger">*</span></label>
											<textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
											@error('message')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">
											<i class="fas fa-paper-plane"></i> Send Message
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section pt-0" id="office-location">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="widget-box map-location aos" data-aos="fade-up">
						<div class="profile-head">
							<h4 class="pro-title">Our Office Location</h4>
						</div>
						<iframe
							title="NextHire office location map"
							src="https://maps.google.com/maps?q=Abuja%20Nigeria&t=&z=13&ie=UTF8&iwloc=&output=embed"
							width="100%"
							height="400"
							style="border:0;"
							allowfullscreen=""
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
						></iframe>
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('partials.public-cta')
</x-app>
