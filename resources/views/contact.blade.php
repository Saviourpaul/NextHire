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
									<p>12 Recruitment Avenue, Central Business District, Portharcourt, Nigeria</p>
								</li>
							</ul>
						</div>
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
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.6159073417384!2d7.011289974739778!3d4.835830295139733!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1069cde6cbf3e971%3A0x97322eb45a4c74bb!2sRIVERS%20STATE%20ICT%20DEPARTMENT!5e0!3m2!1sen!2sus!4v1782916362639!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('partials.public-cta')
</x-app>
