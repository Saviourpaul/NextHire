  document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.on-board');
            const progressItems = document.querySelectorAll('#progressbar li');
            const totalSteps = steps.length;
            let currentStep = 0;

            function showStep(index) {
                steps.forEach((step, i) => {
                    step.style.display = (i === index) ? 'block' : 'none';
                });
                progressItems.forEach((item, i) => {
                    item.classList.toggle('active', i <= index);
                });
                currentStep = index;
            }

            document.querySelectorAll('.next_btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (currentStep < totalSteps - 1) {
                        showStep(currentStep + 1);
                    }
                });
            });

            document.querySelectorAll('.prev_btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const step = parseInt(btn.getAttribute('data-step'));
                    if (step > 1) {
                        showStep(step - 2);
                    }
                });
            });
        });


  document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.on-board');
            const stepperSteps = document.querySelectorAll('.stepper-step');
            const stepperLines = document.querySelectorAll('.stepper-line');
            const totalSteps = steps.length;
            let currentStep = 0;

            function showStep(index) {
                steps.forEach((step, i) => {
                    step.style.display = (i === index) ? 'block' : 'none';
                });

                stepperSteps.forEach((el, i) => {
                    el.classList.remove('active', 'completed');
                    if (i < index) el.classList.add('completed');
                    if (i === index) el.classList.add('active');
                });

                stepperLines.forEach((line, i) => {
                    const lineIndex = i + 1;
                    if (lineIndex <= index) {
                        line.classList.add('completed');
                    } else {
                        line.classList.remove('completed');
                    }
                });

                currentStep = index;
            }

            document.querySelectorAll('.next_btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (currentStep < totalSteps - 1) {
                        showStep(currentStep + 1);
                    }
                });
            });

            document.querySelectorAll('.prev_btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (currentStep > 0) {
                        showStep(currentStep - 1);
                    }
                });
            });

            // File upload interactions
            setupUploadZones();

            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        function setupUploadZones() {
            document.querySelectorAll('.upload-zone').forEach(function(zone) {
                const input = zone.querySelector('input[type="file"]');
                if (!input) return;

                const previewContainer = zone.parentElement.querySelector('.upload-preview');
                const fileNameEl = previewContainer ? previewContainer.querySelector('.file-name') : null;
                const fileSizeEl = previewContainer ? previewContainer.querySelector('.file-size') : null;

                zone.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'INPUT') {
                        input.click();
                    }
                });

                zone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    zone.style.borderColor = 'var(--app-primary)';
                    zone.style.background = 'var(--app-primary-light)';
                });

                zone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    zone.style.borderColor = '';
                    zone.style.background = '';
                });

                zone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    zone.style.borderColor = '';
                    zone.style.background = '';
                    if (e.dataTransfer.files.length) {
                        input.files = e.dataTransfer.files;
                        handleFileSelect(input, previewContainer, fileNameEl, fileSizeEl);
                    }
                });

                input.addEventListener('change', function() {
                    handleFileSelect(input, previewContainer, fileNameEl, fileSizeEl);
                });

                // Remove file handler
                const removeBtn = previewContainer ? previewContainer.querySelector('.btn-remove') : null;
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        input.value = '';
                        if (previewContainer) previewContainer.classList.remove('has-file');
                    });
                }
            });

            function handleFileSelect(input, previewContainer, fileNameEl, fileSizeEl) {
                if (input.files && input.files[0] && previewContainer) {
                    const file = input.files[0];
                    previewContainer.classList.add('has-file');
                    if (fileNameEl) fileNameEl.textContent = file.name;
                    if (fileSizeEl) fileSizeEl.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                }
            }

            // Photo upload preview
            const photoInput = document.getElementById('photoInput');
            const photoPreview = document.getElementById('photoPreview');
            const photoImg = document.getElementById('photoImg');

            if (photoInput && photoPreview && photoImg) {
                photoInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            photoImg.src = e.target.result;
                            photoPreview.classList.add('has-image');
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        }
