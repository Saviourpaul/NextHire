<div class="modal fade" id="ModalApplyJobForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content apply-job-form">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body pl-30 pr-30 pt-50">
                <div class="text-center">
                    <p class="font-sm text-brand-2">Job Application</p>
                    <h2 class="mt-10 mb-5 text-brand-1 text-capitalize">Start your career today</h2>
                    <p class="font-sm text-muted mb-30">Share your information with the employer.</p>
                </div>
                <form class="login-register text-start mt-20 pb-30" action="#">
                    <div class="form-group">
                        <label class="form-label" for="apply-name">Full Name *</label>
                        <input class="form-control" id="apply-name" type="text" required name="fullname" placeholder="Steven Job">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="apply-email">Email *</label>
                        <input class="form-control" id="apply-email" type="email" required name="emailaddress" placeholder="stevenjob@gmail.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="apply-phone">Contact Number *</label>
                        <input class="form-control" id="apply-phone" type="text" required name="phone" placeholder="(+01) 234 567 89">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="apply-description">Description</label>
                        <input class="form-control" id="apply-description" type="text" name="description" placeholder="Your description...">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="apply-resume">Upload Resume</label>
                        <input class="form-control" id="apply-resume" name="resume" type="file">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default hover-up w-100" type="submit">Apply Job</button>
                    </div>
                    <div class="text-muted text-center">Do you need support? <a href="{{ url('/contact') }}">Contact Us</a></div>
                </form>
            </div>
        </div>
    </div>
</div>
