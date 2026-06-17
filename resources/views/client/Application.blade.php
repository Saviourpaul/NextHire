<x-admin-layout title="Job Applications">
    <div class="content container-fluid">
        <div class="acc-content">
            <div class="row">
                <div class="col-sm-12">

                    <div class="multistep-form">

                        <div class="multistep-progress" id="freelance_step">
                            <div class="container">
                                <div class="first-progress">
                                    <div class="row align-items-center">
                                        <div class="col-md-9">
                                            <ul id="progressbar" class="progressbar">
                                                <li class="active">
                                                    <div class="progress-active"><img src="{{ asset('assets/img/icon/wizard-icon-02.svg') }}" alt="Img"></div>
                                                    <div class="steps-count">
                                                        <span>Step 1/4</span>
                                                        <h5>Personal info</h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="multi-step"><img src="{{ asset('assets/img/icon/wizard-icon-03.svg') }}" alt="Img"></div>
                                                    <div class="steps-count">
                                                        <span>Step 2/4</span>
                                                        <h5>Skills & Experience</h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="multi-step"><img src="{{ asset('assets/img/icon/wizard-icon-04.svg') }}" alt="Img"></div>
                                                    <div class="steps-count">
                                                        <span>Step 3/4</span>
                                                        <h5>Other Information</h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="multi-step"><img src="{{ asset('assets/img/icon/wizard-icon-05.svg') }}" alt="Img"></div>
                                                    <div class="steps-count">
                                                        <span>Step 4/4</span>
                                                        <h5>Application Verification</h5>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="on-board field-card select-account select-btn" id="step1">
                            <div class="text-center onboard-head">
                                <h2>Personal Info</h2>
                                <p>Tell a bit about yourself. This information will appear on your public profile, so that potential buyers can get to know you better.</p>
                            </div>
                            <div class="field-item personal-info space-info">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="pro-form-img">
                                                <div class="profile-pic">Profile Photo</div>
                                                <div class="upload-files">
                                                    <label class="file-upload image-upbtn">
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
                                        <div class="col-md-6 col-lg-4">
                                            <div class="input-block">
                                                <label class="form-label">Date of Birth</label>
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control datetimepicker" placeholder="Choose">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                            <div class="text-center">
                                <input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back" disabled>
                                <input class="btn next_btn btn-primary btn-get btn-next" name="next" type="button" value="Next" data-step="1">
                            </div>
                        </div>

                        <div class="on-board field-card select-account select-btn" id="step2" style="display: none;">
                            <div class="text-center onboard-head">
                                <h2>Skills & Experience</h2>
                                <p>This is your time to shine. Let potential buyers know what you do best and how you gained your skills, certifications and experience</p>
                            </div>
                            <div class="field-item personal-info space-info">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Skill</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">Skills</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="focus-label">Level</label>
                                                <select name="skills['level'][]" class="form-control select-level select">
                                                    <option value="">Choose Level</option>
                                                    <option value="Basic">Basic</option>
                                                    <option value="Intermediate">Intermediate</option>
                                                    <option value="Proficient">Proficient</option>
                                                </select>
                                                <div class="new-addd">
                                                    <a class="add-new" id="skill_add"><i class="feather-plus-circle me-1"></i> Add New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="skill_add_row"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Education</h4>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">Degree Name</label>
                                                <select name="education['degree_name'][]" class="form-control select-level select-edu select">
                                                    <option value="0">Select</option>
                                                    <option value="1">Bachelor's degree</option>
                                                    <option value="1">Master's Degree</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">University Name</label>
                                                <input type="text" name="education['university_name'][]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">Start Date</label>
                                                <div class="cal-icon">
                                                    <input type="text" name="education['start_date'][]" class="form-control datetimepicker" placeholder="Choose">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">End Date</label>
                                                <div class="cal-icon">
                                                    <input type="text" name="education['end_date'][]" class="form-control datetimepicker" placeholder="Choose">
                                                </div>
                                                <div class="new-addd">
                                                    <a class="add-new" id="edu_add"><i class="feather-plus-circle me-1"></i> Add New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="education_add_row"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Certification</h5>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-block">
                                                <label class="focus-label">Certification or Award</label>
                                                <select name="certification['award'][]" class="form-control select-level select-edu select">
                                                    <option value="0">Select</option>
                                                    <option value="1">Certification</option>
                                                    <option value="1">Award</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-block">
                                                <label class="focus-label">Certified from</label>
                                                <input type="text" name="certification['certified_from'][]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-block">
                                                <label class="focus-label">Year</label>
                                                <div class="cal-icon">
                                                    <input type="text" name="certification['year'][]" class="form-control datetimepicker" placeholder="Choose">
                                                </div>
                                                <div class="new-addd">
                                                    <a class="add-new" id="certify_add"><i class="feather-plus-circle me-1"></i> Add New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="certify_add_row"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Experience</h4>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">Company Name</label>
                                                <input type="text" name="experience['company_name'][]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">Position</label>
                                                <select name="experience['position'][]" class="form-control select-level select">
                                                    <option>Select</option>
                                                    <option>Basic</option>
                                                    <option>Intermediate</option>
                                                    <option>Proficient</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">Start Date</label>
                                                <div class="cal-icon">
                                                    <input type="text" name="experience['start_date'][]" class="form-control datetimepicker" placeholder="Choose">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="input-block">
                                                <label class="focus-label">End Date</label>
                                                <div class="cal-icon">
                                                    <input type="text" name="experience['end_date'][]" class="form-control datetimepicker" placeholder="Choose">
                                                </div>
                                                <div class="new-addd">
                                                    <a class="add-new" id="experience_add"><i class="feather-plus-circle me-1"></i> Add New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="experience_add_row"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Language</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">Language</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="focus-label">Level</label>
                                                <select class="form-control select-level select">
                                                    <option value="">Choose Level</option>
                                                    <option value="Basic">Basic</option>
                                                    <option value="Intermediate">Intermediate</option>
                                                    <option value="Proficient">Proficient</option>
                                                </select>
                                                <div class="new-addd">
                                                    <a class="add-new" id="lang_add"><i class="feather-plus-circle me-1"></i> Add New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="language_add_row"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="text-center">
                                <input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back" data-step="2">
                                <input class="btn next_btn btn-primary btn-get btn-next" name="next" type="button" value="Next" data-step="2">
                            </div>
                        </div>

                        <div class="on-board field-card select-account select-btn" id="step3" style="display: none;">
                            <div class="text-center onboard-head">
                                <h2>Other info</h2>
                                <p>Don't worry, this can be changed later.</p>
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
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">Instagram</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">LinkedIn</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">Behance</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">Pinterest</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">Twitter</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-set">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Personal Website</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">Website Url</label>
                                                <input type="text" class="form-control">
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
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block">
                                                <label class="form-label">State / Province</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block">
                                                <label class="form-label">ZIP / Post Code</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block">
                                                <label class="form-label">Country</label>
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
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">Upload Document</label>
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
                            <div class="text-center">
                                <input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back" data-step="3">
                                <input class="btn next_btn btn-primary btn-get btn-next" name="next" type="button" value="Next" data-step="3">
                            </div>
                        </div>

                        <div class="on-board field-card select-account select-btn" id="step4" style="display: none;">
                            <div class="text-center onboard-head">
                                <h2>Application Verification</h2>
                                <p>Please review your information before submitting.</p>
                            </div>
                            <div class="field-item personal-info">
                                <div class="text-center">
                                    <img src="assets/img/icon/mail.png" class="img-fluid" alt="icon" style="max-width: 120px; margin-bottom: 20px;">
                                    <h3>Thank you for Applying</h3>
                                    <p>Your application is under review. We will get back to you shortly.</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <input class="btn btn-prev prev_btn btn-back" name="next" type="button" value="Back" data-step="4">
                                <input class="btn next_btn btn-primary btn-get btn-next" name="next" type="button" value="Submit" data-step="4">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    

</x-admin-layout>
