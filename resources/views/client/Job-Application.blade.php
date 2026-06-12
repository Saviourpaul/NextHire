<x-admin-layout title="Applicant Dashboard">
    <div class="page-wrapper board-screen">
				<div class="content container-fluid">
					<div class="acc-content">
						
						<div class="row">
							<div class="col-sm-12">
								<div class="multistep-form"> 
										
									<!-- Freelancer Multistep -->
									<div class="multistep-progress" id="freelance_step">
										<div class="container">
											<div class="first-progress" >
												<div class="row align-items-center">
													<div class="col-md-3">
														<div class="board-logo">
															<a href="index-2.html"><img src="assets/img/logo.svg" alt="Img" class="img-fluid" ></a>
														</div>
													</div>
													<div class="col-md-9">
														<ul id="progressbar" class="progressbar">
															<li class="progress-active">
																<div class="multi-step"><img src="assets/img/icon/wizard-icon-01.svg" alt="Img"></div>	
																<div class="steps-count">
																	<span>Step 1/5</span>
																	<h5>Account Type</h5>
																</div>								
															</li>
															<li class="">
																<div class="multi-step"><img src="assets/img/icon/wizard-icon-02.svg" alt="Img"></div>		
																<div class="steps-count">
																	<span>Step 2/5</span>
																	<h5>Personal info</h5>
																</div>
															</li>
															<li class="">
																<div class="multi-step"><img src="assets/img/icon/wizard-icon-03.svg" alt="Img"></div>		
																<div class="steps-count">
																	<span>Step 3/5</span>
																	<h5>Skills & Experience</h5>
																</div>
															</li>
															<li class="">
																<div class="multi-step"><img src="assets/img/icon/wizard-icon-04.svg" alt="Img"></div>		
																<div class="steps-count">
																	<span>Step 4/5</span>
																	<h5>Other Information</h5>
																</div>
															</li>
															<li class="">
																<div class="multi-step"><img src="assets/img/icon/wizard-icon-05.svg" alt="Img"></div>		
																<div class="steps-count">
																	<span>Step 5/5</span>
																	<h5>Email Verification</h5>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /Freelancer Multistep -->
									
									<!-- Accounting Onboard -->
									<div  class="text-center on-board select-account group-select">
										<div class="select-type">
											<div class="account-onborad onboard-head">
												<h2>Select Account Type</h2>
												<p>Don’t worry, this can be changed later.</p>
												<div class="select-box d-flex justify-content-center">
													<input checked="checked" id="freelance"   type="radio" name="credit-card" value="visa">
													<label class="employee-level free-lance-img accounts_type" data-id="freelance" for="freelance">
														<a href="onboard-screen.html">
															<img src="assets/img/select-04.svg" alt="Img" class="img-fluid" >
															<span>Freelancer</span>
														</a>
													</label>
													<input id="employee" class="accounts_type"  type="radio" name="credit-card" value="mastercard">
													<label class="employee-level employee-img accounts_type" data-id="employee" for="employee">
														<a href="onboard-screen-employer.html"  >
															<img src="assets/img/icon/checks.svg" alt="Img" class="checks-set" >
															<img src="assets/img/select-05.svg" alt="Img" class="img-fluid" >
															<span>Employer</span>
														</a>
													</label>
												</div>
											</div>
											<input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back" disabled>									
											<input class="btn next_btn btn-primary btn-get btn-next" name="next" type="submit" value="Next">
										</div>
									</div>
									<!-- /Accounting Onboard -->
								
									<!-- Personal Info -->
									<div class="on-board field-card select-account select-btn">
										<div class="text-center onboard-head">
											<h2>Personal Info</h2>
											<p>Tell a bit about yourself. This information will appear on your public profile, so that potential buyers can get to know you better.</p>
										</div>
										<div class="field-item personal-info space-info">
											<form>
												<div class="row">
													<div class="col-md-12 col-lg-12">
														<div class="pro-form-img">
															<div class="profile-pic">
																Profile Photo
															</div>
															<div class="upload-files">
																<label class="file-upload image-upbtn ">
																	<i class="feather-upload me-2"></i>Upload Photo <input type="file">
																</label>
																<span>For better preview recommended size is 450px x 450px. Max size 5mb.</span>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-lg-6">
														<div class="input-block">
															<label class="form-label">First Name</label>
															<input type="text" class="form-control">
														</div>
													</div>
													<div class="col-md-6 col-lg-6">
														<div class="input-block">
															<label class="form-label">Last Name</label>
															<input type="text" class="form-control">
														</div>
													</div>
													<div class="col-md-6 col-lg-6">
														<div class="input-block">
															<label class="form-label">Phone Number</label>
															<input type="text" class="form-control">
														</div>
													</div>
													<div class="col-md-6 col-lg-6">
														<div class="input-block">
															<label class="form-label">Email Address</label>
															<input type="text" class="form-control">
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="text-center">
											<input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back">									
											<input class="btn next_btn btn-primary btn-get btn-next" name="next" type="submit" value="Next">
										</div>
									</div>
									<!-- /Personal Info -->
									
									<!-- Skills & Experience -->
									<div class="on-board field-card select-account select-btn">
										<div class="text-center onboard-head">
											<h2>Employer Info</h2>
											<p>This is your time to shine. Let potential buyers know what you do best and how you gained your skills, certifications and experience</p>
										</div>
										<div class="field-item personal-info space-info">
											<form action="#">
												<div class="row">
													<div class="col-md-12">
														<h4>Details</h4>
													</div>
													<div class="col-md-6">
														<div class="input-block">
															<label class="form-label">Company Name</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="input-block">
															<label class="form-label">Tagline</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="input-block">
															<label class="form-label">Established On</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="input-block">
															<label class="form-label">Company Owner Name</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="input-block">
															<label class="focus-label">Industry</label>
															<select class="form-control select">
																<option value="0">Select</option>
																<option value="1">Bachelor's degree</option>
																<option value="1">Master's Degree</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="input-block">
															<label class="form-label">Website</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-12">
														<div class="input-block">
															<label class="form-label">Team Size</label>
														</div>
														<div class="check-radio">
															<ul>
																<li>
																	<label class="custom_radio me-4">
																		<input type="radio" name="budget" value="Yes" checked="">
																		<span class="checkmark"></span> It's just me
																	</label> 
																</li>
																<li>
																	<label class="custom_radio me-4">
																		<input type="radio" name="budget" >
																		<span class="checkmark"></span>2-9 employees
																	</label> 
																</li>
																<li>
																	<label class="custom_radio me-4">
																		<input type="radio" name="budget" >
																		<span class="checkmark"></span>10-99 employees
																	</label> 
																</li>
																<li>
																	<label class="custom_radio me-4">
																		<input type="radio" name="budget" >
																		<span class="checkmark"></span>100-1000 employees
																	</label> 
																</li>
																<li>
																	<label class="custom_radio me-4">
																		<input type="radio" name="budget" >
																		<span class="checkmark"></span>More than 1000 employees
																	</label> 
																</li>
															</ul>
														</div>
													</div>
													<div class="col-md-12">
														<div class="input-block min-characters">
															<label class="form-label">Describe Yourself</label>
															<textarea class="form-control" rows="5" ></textarea>
														</div>
													</div>
												</div>
												
											</form>
											
										</div>
										<div class="text-center">
											<input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back">									
											<input class="btn next_btn btn-primary btn-get btn-next" name="next" type="submit" value="Next">
										</div>
									</div>
									<!-- /Skills & Experience -->

									<!-- Other Info -->
									<div class="on-board field-card select-account select-btn">
										<div class="text-center onboard-head">
											<h2>Other info</h2>
											<p>Don’t worry, this can be changed later.</p>
										</div>
										<div class="field-item personal-info">
											<div class="media-set">
												<div class="row">
													<div class="col-md-12">
														<h4>Social Media</h4>
													</div>
													<div class="col-md-4">
														<div class="input-block">
															<label class="form-label">Facebook</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-block">
															<label class="form-label">Instagram </label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-block">
															<label class="form-label">LinkedIn </label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-block">
															<label class="form-label">Behance </label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-block">
															<label class="form-label">Pinterest  </label>
															<input type="text"  class="form-control">
														</div>
													</div>
													<div class="col-md-4">
														<div class="input-block">
															<label class="form-label">Twitter</label>
															<input type="text"  class="form-control">
														</div>
													</div>
													
												</div>
											</div>
											<div>
												<div class="media-set">
													<div class="row">
														<div class="col-md-12">
															<h4>Personal Website</h4>
														</div>
														<div class="col-md-12">
															<div class="input-block">
																<label class="form-label">Website Url</label>
																<input type="text"  class="form-control">
															</div>
														</div>
													</div>
												</div>
												<div class="media-set">
													<div class="row">
														<div class="col-md-12">
															<h4>Location</h4>
														</div>
														<div class="col-md-12">
															<div class="input-block">
																<label class="form-label">Address</label>
																<input type="text"  class="form-control">
															</div>
														</div>
														<div class="col-md-3">
															<div class="input-block">
																<label class="form-label">City</label>
																<input type="text"  class="form-control">
															</div>
														</div>
														<div class="col-md-3">
															<div class="input-block">
																<label class="form-label">State / Province</label>
																<input type="text"  class="form-control">
															</div>
														</div>
														<div class="col-md-3">
															<div class="input-block">
																<label class="form-label">ZIP / Post Code</label>
																<input type="text"  class="form-control">
															</div>
														</div>
														<div class="col-md-3">
															<div class="input-block">
																<label class="form-label">ZIP / Post Code</label>
																<select class="select">
																	<option>Select</option>
																	<option>US</option>
																	<option>UK</option>
																	<option>India</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="media-set">
													<div class="row">
														<div class="col-md-12">
															<h4>KYC Upload</h4>
														</div>
														<div class="col-md-6">
															<div class="input-block">
																<label class="form-label">Document Type</label>
																<select class="select">
																	<option>Select</option>
																	<option>US</option>
																	<option>UK</option>
																	<option>India</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="input-block">
																<label class="form-label">Document Number</label>
																<input type="text"  class="form-control">
															</div>
														</div>
														<div class="col-md-12">
															<div class="input-block">
																<label class="form-label">Document Number</label>
																<div class="upload-sets">
																	<label class="upload-filesview">
																		Browse File
																		<input type="file">
																	</label>
																	<h6>Or Drag & Drop here</h6>
																</div>
																<span class="text-success"><i class="fa fa-check-circle me-2" aria-hidden="true"></i>Passport.jpg Uploaded Successfully</span>
															</div>
														</div>
													</div>
												</div>
												
											</div>
										</div>
										<div class="text-center">
											<input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back">
											<input class="btn next_btn btn-primary btn-get btn-next" name="next" type="button" value="Submit">
										</div>
									</div>	
									<!-- /Other Info -->
									
									<!-- Completeing Register -->
									<div class="on-board field-card">
										<div class="account-onborad complte-board back-home pb-0">
											<img src="assets/img/icon/mail.png" class="img-fluid" alt="icon">
											<h2>Thank you for registering!</h2>
											<h3>Your Application is Review </h3>
											
											<a href="javascript:void(0);" class="link-danger"><i class="feather-refresh-cw me-2 "></i> Resend Email</a>
										</div>
										<div class="text-center">
											<input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back">
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
    
</x-admin-layout>
