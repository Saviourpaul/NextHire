@use('Illuminate\Support\Str')

<x-app>
    	<!-- Home Banner -->
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
									<h5>Trused by over 2M+ users</h5> 
								</div>
								<h1>Get The Perfect <span class="orange-text"><br>Government Jobs</span></h1>
								<p>There are many variations of passages of the Ipsum available, but the majority have 
									suffered alteration in some form, by injected humour.</p>
								<form class="form"  name="store" id="store" method="post" action="https://NextHire.dreamstechnologies.com/html/template/project.html">
									<div class="form-inner">
										<div class="input-group">
											<span class="drop-detail">
												<select class="form-control select" name="storeID">
													<option value="project.html">Select</option>
													<option value="developer.html">Project</option>
													<option value="developer.html">Freelancers</option>
												</select>
											</span>
											<input type="email" class="form-control" placeholder="Keywords">
											<button class="btn btn-primary sub-btn" type="submit">Search </button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-md-4 col-lg-5">
							<div class="banner-img aos" data-aos="zoom-in" data-aos-duration="3000">
								<img src="assets/img/banner-img.svg" class="img-fluid" alt="banner">
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- /Home Banner -->
			<!-- jobs -->
			<section class="section news">
				<div class="container">				
					<div class="row">
						<div class="col-12">
							<div class="section-header text-center aos" data-aos="fade-up">
								<h2 class="header-title">Jobs</h2>
							</div>
						</div>
					</div>
					<div class="row blog-grid-row g-4">
						@foreach($jobs->take(3) as $job)
						<div class="col-xl-4 col-md-6 col-sm-12 d-flex">
							<!-- job Post -->
							<div class="blog grid-blog aos flex-fill w-100" data-aos="fade-up">
								<div class="blog-image">
									<a href="{{ route('job-details', $job) }}"><img class="img-fluid w-100" src="{{ $job->logoUrl() }}" alt="{{ $job->company }} logo" style="height: 220px; object-fit: contain;"></a>
								</div>
								
								<div class="blog-content d-flex flex-column h-100">
									<ul class="entry-meta meta-item mb-2">
										<li class="mb-0">
											<div class="post-author">
												<a href="{{ route('job-details', $job) }}"> <span>{{ $job->company }}</span></a>
											</div>
										</li>
										<li><i class="feather-calendar me-1"></i> {{ $job->created_at->format('d M Y') }}</li>
									</ul>
									<div class="blog-read mt-auto">
										<a href="{{ route('job-details', $job) }}">Apply <i class="fas fa-arrow-right ms-1"></i></a>
									</div>
									<h3 class="blog-title"><a href="{{ route('job-details', $job) }}">{{ $job->title }}</a></h3>
									<p class="mb-0 flex-grow-1">{{ Str::limit(strip_tags($job->description), 150) }}</p>
									
								</div>
							</div>
							<!-- /job Post -->
						</div>
						@endforeach
					</div>
					<div class="row mt-4">
						<div class="col-12 text-center">
							<a href="/find-jobs" class="btn btn-primary">View All Jobs</a>
						</div>
					</div>
				</div>
			</section>
			<!-- /Projects -->

			<section class="section review">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 mx-auto text-center">
							<div class="section-header aos" data-aos="fade-up">
								<h2 class="header-title">Popular Categories</h2>
								<p>Get some Inspirations from 1300+ skills</p>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="1000">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories1.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Development & IT</h5>
										<a href="javascript:void(0);">958 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="1500">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories7.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Design & Creative</h5>
										<a href="javascript:void(0);">515 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="2000">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories3.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Digital Marketing</h5>
										<a href="javascript:void(0);">486 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="2500">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories4.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Writing & Translation</h5>
										<a href="javascript:void(0);">956 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="1000">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories5.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Music & Video</h5>
										<a href="javascript:void(0);">662 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="1500">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories6.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Video & Animation</h5>
										<a href="javascript:void(0);">226 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="2000">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories7.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Engineering & Architecture</h5>
										<a href="javascript:void(0);">756 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-12 aos" data-aos="zoom-in" data-aos-duration="2500">
								<div class="popular-catergories">
									<div class="popular-catergories-img">
										<span><img src="assets/img/icon/categories8.svg" alt="img"></span>
									</div>
									<div class="popular-catergories-content">
										<h5>Finance & Accounting</h5>
										<a href="javascript:void(0);">958 Skills<i class="feather-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!--- Developed Project  -->
			<section class="section news pt-0 review-set">
				<div class="container">
					<div class="row">					
						<!-- Feature Item -->
						<div class="col-lg-6 col-md-12">
							<div class="work-box bg1"  data-aos="zoom-in"  data-aos-duration="1000">
								<div class="work-content">
									<h2>I need a Developed <span>Project</span></h2>
									<p>Get the perfect Developed project for your budget from our creative community.</p>
									<a href="project.html" class="btn btn-primary">Browse</a>
								</div>
							</div>
						</div>
						<!-- /Feature Item -->
						<div class="col-lg-6 col-md-12">
							<div class="work-box aos bg2"  data-aos="zoom-in"  data-aos-duration="2000">
								<div class="work-content ">
								<h2>Find Your Next Great  <span>Job Opportunity!</span></h2>
								<p>Do you want to earn money, find unlimited clients and build your freelance career?</p>
								<a href="project.html" class="btn btn-primary">Browse</a>
							</div>
						</div>
						</div>
					</div>
				</div>
			</section>
			<!--- /Developed Project  -->
	
			<!-- Our Feature -->
			<section class="section projects pt-0">
				<div class="container">
					<div class="row">					
						<div class="col-md-12 col-sm-12 col-12 mx-auto text-center">
							<div class="section-header aos" data-aos="fade-up">
								<h2 class="header-title">Achievement We Have Earned</h2>
								<p>At Freelancer, we believe that talent is borderless and opportunity should be too.</p>
							</div>
						</div>		
						<!-- Feature Item -->
						<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="1000">
							<div class="feature-item freelance-count ">
								<div class="feature-icon">
									<img src="assets/img/icon/achievement-1.svg" class="img-fluid" alt="Img">
								</div>
								<div class="feature-content course-count">
									<h3 class="counter-up">9,207</h3>
									<p>Freelance developers</p>
								</div>
							</div>
						</div>
						<!-- /Feature Item -->
						
						<!-- Feature Item -->
						<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="1500">
							<div class="feature-item ">
								<div class="feature-icon">
									<img src="assets/img/icon/achievement-2.svg" class="img-fluid" alt="Img">
								</div>
								<div class="feature-content course-count">
									<h3 ><span class="counter-up">8368 </span></h3>
									<p>Projects Added</p>
								</div>
							</div>
						</div>
						<!-- /Feature Item -->
						
						<!-- Feature Item -->
						<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="2000">
							<div class="feature-item comp-project ">
								<div class="feature-icon">
									<img src="assets/img/icon/achievement-3.svg" class="img-fluid" alt="Img">
								</div>
								<div class="feature-content course-count">
									<h3 class="counter-up">9198</h3>
									<p>Completed projects</p>
								</div>
							</div>
						</div>
						<!-- /Feature Item -->	

						<!-- Feature Item -->
						<div class="col-xl-3 col-md-6 aos" data-aos="zoom-in" data-aos-duration="2500">
							<div class="feature-item comp-project ">
								<div class="feature-icon">
									<img src="assets/img/icon/achievement-4.svg" class="img-fluid" alt="Img">
								</div>
								<div class="feature-content course-count">
									<h3 class="counter-up">998</h3>
									<p>Companies Registered</p>
								</div>
							</div>
						</div>
						<!-- /Feature Item -->
												
					</div>
				</div>
			</section>	
			<!-- /Our Feature -->			
			<section class="section review">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<div class="work-set-image">
								<div class="work-set">
									<div class="recent-pro-img aos" data-aos="zoom-in" data-aos-duration="1000">
										<img src="assets/img/work1.jpg" alt="Img" class="img-fluid ">
									</div>
								</div>
								<div class="work-sets">
									<div class="recent-pro-img">
										<img src="assets/img/work2.jpg" alt="Img" class="img-fluid mb-2 aos" data-aos="zoom-in" data-aos-duration="2000">
										<img src="assets/img/work3.jpg" alt="Img" class="img-fluid aos" data-aos="zoom-in" data-aos-duration="2500">
									</div>
								</div>
							</div>
							
						</div>
						<div class="col-lg-6">
							<div class="aos " data-aos="fade-up">
								<div class="demand-professional">
									<h2>Get Expert in Less Time and Our Work Process</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="demand-post-job">
									<div class="demand-post-img">
										<img src="assets/img/recent-icon-01.svg" alt="Img" class="img-fluid">
									</div>
									<div class="demand-content">
										<h6>Post a job</h6>
										<p>Publish the job posting on your selected platforms. Follow the specific submission process for each platform.</p>
									</div>
								</div>
								<div class="demand-post-job">
									<div class="demand-post-img">
										<img src="assets/img/recent-icon-02.svg" alt="Img" class="img-fluid">
									</div>
									<div class="demand-content">
										<h6>Hire Freelancers</h6>
										<p>Depending on the platform, you can either wait for freelancers to apply or invite specific freelancers to submit proposals.</p>
									</div>
								</div>
								<div class="demand-post-job">
									<div class="demand-post-img">
										<img src="assets/img/recent-icon-03.svg" alt="Img" class="img-fluid">
									</div>
									<div class="demand-content">
										<h6>Get Work Done</h6>
										<p>Utilize productivity tools and apps to help you stay organized, manage tasks, and set reminders.</p>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</section>
			
			
			
			
		
		
			<!-- Top Instructor -->
			<section class="section subscribe">
				<div class="bg-img">
					<img src="assets/img/bg/bg3.png" class="bg-img3" alt="img">
				</div>
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 mx-auto ">
							<div class="section-header aos text-center" data-aos="fade-up">
								<h2 class="header-title">Subscribe To Get Discounts, Updates & More</h2>
								<p>Monthly product updates, industry news and more!</p>
							</div>
						</div>
						<div class="subscribe-form aos " data-aos="fade-up">
							<input type="text" placeholder="Enter your Email">
							<a href="javascript:void(0);" class="btn btn-sub">Send</a>
						</div>
					</div>
					
				</div>
			</section>
			<!-- End Developer -->
		<!-- Review -->
		<section class="section testimonial-section review">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-header aos text-center" data-aos="fade-up">
							<h2 class="header-title">Top Reviews</h2>
							<p>High Performing Developers To Your</p>
						</div>
					</div>
				</div>
				<div class="testimonial-slider aos" data-aos="fade-up">
							
					<!-- Review Widget -->
					<div class="review-slide">
						<div class="review-blog">
							<div class="review-top d-flex align-items-center">
								<div class="review-img">
									<a href="review.html"><img class="img-fluid" src="assets/img/review/review-01.jpg" alt="Post Image"></a>
								</div>
								<div class="review-info">
									<h3><a href="review.html">Durso Raeen</a></h3>
									<h5>Project Lead</h5>								
									
								</div>
								<div class="test-quote-img">
									<img class="img-fluid" src="assets/img/test-quote.svg" alt="quote">
								</div>
							</div>
							<div class="review-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="average-rating">4.7</span>
								</div>
							</div>
						</div>
					</div>
					<!-- / Review Widget -->
						
					<!-- Review Widget -->
					<div class="review-slide">
						<div class="review-blog">
							<div class="review-top d-flex align-items-center">
								<div class="review-img">
									<a href="review.html"><img class="img-fluid" src="assets/img/review/review-02.jpg" alt="Post Image"></a>
								</div>
								<div class="review-info">
									<h3><a href="review.html">Camelia Rennesa</a></h3>
									<h5>Project Lead</h5>								
									
								</div>
								<div class="test-quote-img">
									<img class="img-fluid" src="assets/img/test-quote.svg" alt="quote">
								</div>
							</div>
							<div class="review-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="average-rating">4.8</span>
								</div>
							</div>
						</div>
					</div>
					<!-- /Review Widget -->
						
					<!-- Review Widget -->
					<div class="review-slide">
						<div class="review-blog">
							<div class="review-top d-flex align-items-center">
								<div class="review-img">
									<a href="review.html"><img class="img-fluid" src="assets/img/review/review-03.jpg" alt="Post Image"></a>
								</div>
								<div class="review-info">
									<h3><a href="review.html">Brayan</a></h3>
									<h5>Team Lead</h5>								
									
								</div>
								<div class="test-quote-img">
									<img class="img-fluid" src="assets/img/test-quote.svg" alt="quote">
								</div>
							</div>
							<div class="review-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="average-rating">5.0</span>
								</div>
							</div>
						</div>
					</div>
					<!-- /Review Widget -->
						
					<!-- Review Widget -->
					<div class="review-slide">
						<div class="review-blog">
							<div class="review-top d-flex align-items-center">
								<div class="review-img">
									<a href="review.html"><img class="img-fluid" src="assets/img/review/review-02.jpg" alt="Post Image"></a>
								</div>
								<div class="review-info">
									<h3><a href="review.html">Davis Payerf</a></h3>
									<h5>Project Lead</h5>								
									
								</div>
								<div class="test-quote-img">
									<img class="img-fluid" src="assets/img/test-quote.svg" alt="quote">
								</div>
							</div>
							<div class="review-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Volutpat orci enim, mattis nibh aliquam dui, nibh faucibus aenean.</p>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="average-rating">3.2</span>
								</div>
							</div>
						</div>
					</div>
					<!-- /Review Widget -->
				</div>
			</div>
		</section>
		<!-- / Review -->

		<section class="section projects">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-12 mx-auto">
							<div class="section-header text-center aos aos-init aos-animate" data-aos="fade-up">	
								<h2 class="header-title">Trusted by the world’s best</h2>
								<p>Top companies</p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="best-company aos aos-init aos-animate" data-aos="fade-up"> 
								<ul class="mb-0">
									<li>
										<div class="company-bestimg">
											<img src="assets/img/company/theme-1.png" alt="img">
										</div>
									</li>
									<li>
										<div class="company-bestimg">
											<img src="assets/img/company/theme-2.png" alt="img">
										</div>
									</li>
									<li>
										<div class="company-bestimg">
											<img src="assets/img/company/theme-3.png" alt="img">
										</div>
									</li>
									<li>
										<div class="company-bestimg">
											<img src="assets/img/company/theme-4.png" alt="img">
										</div>
									</li>
									<li>
										<div class="company-bestimg">
											<img src="assets/img/company/theme-5.png" alt="img">
										</div>
									</li>
									<li>
										<div class="company-bestimg">
											<img src="assets/img/company/theme-6.png" alt="img">
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>	
			
		
			
			
			<!-- News -->
			
			<!-- / News -->
			
			<!-- News -->
			<section class="section job-register">
				<div class="container">				
					<div class="row">
						<div class="col-12">
							<div class="register-job-blk">
								<div class="job-content-blk aos" data-aos="fade-up">
									<h2>Find Your Next Great Job Opportunity!</h2>
									<p>Quisque pretium dolor turpis, quis blandit turpis semper ut. Nam malesuada eros nec luctus laoreet.</p>
									<a href="register.html" class="btn all-btn">Join Now</a>
								</div>
								<div class="see-all mt-0 aos opportunity" data-aos="zoom-in"> 
									<img src="assets/img/job1.png" alt="img">
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
   </x-app>
