<x-admin-layout title="Job Application">
    @php
        $wizardSteps = [
            'Personal Information',
            'Identification',
            'Educational Qualification',
            'Application Summary',
        ];

        $educationDocumentTypes = [
            'ssce' => 'SSCE',
            'ond' => 'OND',
            'bsc' => 'BSc',
            'bed' => 'B.Ed',
            'nysc' => 'NYSC',
            'msc' => 'MSc',
            'phd' => 'PhD',
            'other' => 'Other',
        ];

        $educationRows = collect(old('education_documents', [['type' => '']]))->values();
        $educationRows = $educationRows->isEmpty() ? collect([['type' => '']]) : $educationRows;
        $selectedState = old('state_of_origin', $user->state_of_origin);
        $selectedLga = old('local_government_area', $user->local_government_area);
        $selectedStateModel = $states->firstWhere('name', $selectedState);
        $selectedLgas = $selectedStateModel?->localGovernmentAreas ?? collect();
        $locationOptions = $states->mapWithKeys(
            fn ($state) => [$state->name => $state->localGovernmentAreas->pluck('name')->values()]
        );
    @endphp

    @push('styles')
        <style>
            .application-wizard-shell {
                max-width: 1120px;
                margin: 0 auto;
            }

            .application-wizard-progress {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
                padding: 0;
                margin: 0 0 20px;
            }

            .application-wizard-progress li {
                list-style: none;
                display: flex;
                align-items: center;
                gap: 10px;
                min-height: 58px;
                padding: 12px;
                border: 1px solid #dbe4ef;
                border-radius: 8px;
                background: #fff;
                color: #64748b;
            }

            .application-wizard-progress li.is-active,
            .application-wizard-progress li.is-complete {
                border-color: #0073b1;
                color: #16324f;
                background: #f2f9fd;
            }

            .application-wizard-progress-number {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 32px;
                background: #eef2f6;
                font-weight: 700;
            }

            .application-wizard-progress li.is-active .application-wizard-progress-number,
            .application-wizard-progress li.is-complete .application-wizard-progress-number {
                background: #0073b1;
                color: #fff;
            }

            .application-wizard-progress-label {
                line-height: 1.2;
                font-weight: 600;
                overflow-wrap: anywhere;
            }

            .application-wizard-step[hidden] {
                display: none;
            }

            .application-form-panel {
                border: 1px solid #eef2f6;
                border-radius: 8px;
                padding: 18px;
                background: #fbfdff;
                margin-bottom: 18px;
            }

            .application-form-panel:last-child {
                margin-bottom: 0;
            }

            .qualification-document {
                border: 1px solid #e3ebf4;
                border-radius: 8px;
                padding: 16px;
                background: #fff;
                margin-bottom: 14px;
            }

            .application-summary-list {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                margin: 0;
            }

            .application-summary-list div {
                border: 1px solid #e3ebf4;
                border-radius: 8px;
                padding: 14px;
                background: #fff;
            }

            .application-summary-list dt {
                color: #64748b;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 4px;
            }

            .application-summary-list dd {
                color: #1f2937;
                font-weight: 700;
                margin: 0;
                overflow-wrap: anywhere;
            }

            .wizard-actions {
                display: flex;
                justify-content: space-between;
                gap: 12px;
                margin-top: 20px;
            }

            @media (max-width: 767.98px) {
                .application-wizard-progress,
                .application-summary-list {
                    grid-template-columns: 1fr;
                }

                .wizard-actions {
                    flex-direction: column-reverse;
                }

                .wizard-actions .btn {
                    justify-content: center;
                    width: 100%;
                }
            }
        </style>
    @endpush

    <div class="application-wizard-shell">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Apply for {{ $job->title }}</h3>
                    <p class="text-muted mb-0">{{ $job->company }}</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('job-details', $job) }}" class="btn btn-outline-secondary">
                        <i data-feather="arrow-left"></i>
                        Back to Job
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please review the highlighted fields.</strong>
            </div>
        @endif

        <x-application-wizard-progress :steps="$wizardSteps" />

        <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data" data-application-wizard>
            @csrf

            <x-application-wizard-step title="Personal Information" :index="0">
                <div class="application-form-panel">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*" @required(blank($user->profile_image_path)) data-file-input>
                            @error('profile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}">
                            @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" value="{{ old('nationality', $user->nationality ?? 'Nigeria') }}" required>
                            @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required>
                            @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">Select gender</option>
                                @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('gender') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Marital Status</label>
                            <select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                                <option value="">Select status</option>
                                @foreach (['single' => 'Single', 'married' => 'Married', 'divorced' => 'Divorced', 'widowed' => 'Widowed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('marital_status') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('marital_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Zipcode</label>
                            <input type="text" name="zipcode" class="form-control @error('zipcode') is-invalid @enderror" value="{{ old('zipcode', $user->zipcode) }}" required>
                            @error('zipcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">State of Origin</label>
                            <select name="state_of_origin" class="form-control @error('state_of_origin') is-invalid @enderror" required data-state-of-origin>
                                <option value="">Select state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->name }}" @selected($selectedState === $state->name)>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_of_origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Local Government Area</label>
                            <select name="local_government_area" class="form-control @error('local_government_area') is-invalid @enderror" required data-local-government-area data-selected-lga="{{ $selectedLga }}">
                                <option value="">Select LGA</option>
                                @foreach ($selectedLgas as $lga)
                                    <option value="{{ $lga->name }}" @selected($selectedLga === $lga->name)>{{ $lga->name }}</option>
                                @endforeach
                            </select>
                            @error('local_government_area')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" required>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="wizard-actions">
                    <span></span>
                    <button type="button" class="btn btn-primary" data-wizard-next>
                        Next
                        <i data-feather="arrow-right"></i>
                    </button>
                </div>
            </x-application-wizard-step>

            <x-application-wizard-step title="Identification" :index="1">
                <div class="application-form-panel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIN Number</label>
                            <input type="text" name="nin_number" class="form-control @error('nin_number') is-invalid @enderror" value="{{ old('nin_number') }}" inputmode="numeric" pattern="[0-9]{11}" minlength="11" maxlength="11" required>
                            @error('nin_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIN Document</label>
                            <input type="file" name="nin_document" class="form-control @error('nin_document') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required data-file-input>
                            @error('nin_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">BVN Number</label>
                            <input type="text" name="bvn_number" class="form-control @error('bvn_number') is-invalid @enderror" value="{{ old('bvn_number') }}" inputmode="numeric" pattern="[0-9]{11}" minlength="11" maxlength="11" required>
                            @error('bvn_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">BVN Document</label>
                            <input type="file" name="bvn_document" class="form-control @error('bvn_document') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required data-file-input>
                            @error('bvn_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="wizard-actions">
                    <button type="button" class="btn btn-outline-secondary" data-wizard-previous>
                        <i data-feather="arrow-left"></i>
                        Back
                    </button>
                    <button type="button" class="btn btn-primary" data-wizard-next>
                        Next
                        <i data-feather="arrow-right"></i>
                    </button>
                </div>
            </x-application-wizard-step>

            <x-application-wizard-step title="Educational Qualification" :index="2">
                <div class="application-form-panel">
                    <div id="education-documents" data-education-documents>
                        @foreach ($educationRows as $index => $row)
                            <div class="qualification-document" data-education-document>
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <h6 class="mb-0" data-document-title>Qualification Document {{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-remove-document>
                                        <i data-feather="x"></i>
                                        Remove
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="education-document-type-{{ $index }}">Document Type</label>
                                        <select id="education-document-type-{{ $index }}" name="education_documents[{{ $index }}][type]" class="form-control @error('education_documents.'.$index.'.type') is-invalid @enderror" required data-document-type>
                                            <option value="">Select document type</option>
                                            @foreach ($educationDocumentTypes as $value => $label)
                                                <option value="{{ $value }}" @selected(($row['type'] ?? '') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('education_documents.'.$index.'.type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="education-document-file-{{ $index }}">Upload Document</label>
                                        <input id="education-document-file-{{ $index }}" type="file" name="education_documents[{{ $index }}][file]" class="form-control @error('education_documents.'.$index.'.file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required data-document-file data-file-input>
                                        @error('education_documents.'.$index.'.file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('education_documents')<div class="text-danger mb-3">{{ $message }}</div>@enderror

                    <button type="button" class="btn btn-outline-primary" data-add-document>
                        <i data-feather="plus"></i>
                        Add another document
                    </button>
                </div>

                <div class="wizard-actions">
                    <button type="button" class="btn btn-outline-secondary" data-wizard-previous>
                        <i data-feather="arrow-left"></i>
                        Back
                    </button>
                    <button type="button" class="btn btn-primary" data-wizard-next>
                        Next
                        <i data-feather="arrow-right"></i>
                    </button>
                </div>
            </x-application-wizard-step>

            <x-application-wizard-step title="Application Summary" :index="3">
                <div class="application-form-panel">
                    <dl class="application-summary-list">
                        <div>
                            <dt>Job</dt>
                            <dd>{{ $job->title }}</dd>
                        </div>
                        <div>
                            <dt>Company</dt>
                            <dd>{{ $job->company }}</dd>
                        </div>
                        <div>
                            <dt>Deadline</dt>
                            <dd>{{ $job->due_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt>Applicant</dt>
                            <dd data-summary-full-name>{{ trim(old('first_name', $user->first_name).' '.old('last_name', $user->last_name)) ?: 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt>Contact</dt>
                            <dd data-summary-contact>{{ old('phone', $user->phone) ?: 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt>Origin</dt>
                            <dd data-summary-origin>{{ collect([$selectedLga, $selectedState])->filter()->implode(', ') ?: 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt>Qualification Documents</dt>
                            <dd data-summary-documents>{{ $educationRows->count() }}</dd>
                        </div>
                        <div>
                            <dt>Nationality</dt>
                            <dd data-summary-nationality>{{ old('nationality', $user->nationality ?? 'Nigeria') ?: 'Not provided' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="wizard-actions">
                    <button type="button" class="btn btn-outline-secondary" data-wizard-previous>
                        <i data-feather="arrow-left"></i>
                        Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="send"></i>
                        Submit Application
                    </button>
                </div>
            </x-application-wizard-step>
        </form>

        <template id="education-document-template">
            <div class="qualification-document" data-education-document>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h6 class="mb-0" data-document-title></h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-remove-document>
                        <i data-feather="x"></i>
                        Remove
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" data-document-type-label>Document Type</label>
                        <select class="form-control" required data-document-type>
                            <option value="">Select document type</option>
                            @foreach ($educationDocumentTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" data-document-file-label>Upload Document</label>
                        <input type="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required data-document-file data-file-input>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
        <script>
            (function () {
                const form = document.querySelector('[data-application-wizard]');

                if (!form) {
                    return;
                }

                const steps = Array.from(form.querySelectorAll('[data-application-wizard-step]'));
                const progressItems = Array.from(document.querySelectorAll('[data-application-wizard-progress-item]'));
                const lgaOptions = @json($locationOptions);
                let currentStep = 0;

                const showStep = (index) => {
                    currentStep = Math.max(0, Math.min(index, steps.length - 1));

                    steps.forEach((step, stepIndex) => {
                        step.hidden = stepIndex !== currentStep;
                    });

                    progressItems.forEach((item, itemIndex) => {
                        item.classList.toggle('is-active', itemIndex === currentStep);
                        item.classList.toggle('is-complete', itemIndex < currentStep);
                    });
                };

                const validateCurrentStep = () => {
                    const fields = Array.from(steps[currentStep].querySelectorAll('input, select, textarea'));
                    const invalidField = fields.find((field) => !field.disabled && !field.checkValidity());

                    if (!invalidField) {
                        return true;
                    }

                    invalidField.reportValidity();
                    return false;
                };

                const stateSelect = form.querySelector('[data-state-of-origin]');
                const lgaSelect = form.querySelector('[data-local-government-area]');

                const populateLgas = (state, selectedLga = '') => {
                    if (!lgaSelect) {
                        return;
                    }

                    lgaSelect.innerHTML = '';
                    lgaSelect.append(new Option('Select LGA', ''));

                    (lgaOptions[state] || []).forEach((lga) => {
                        lgaSelect.append(new Option(lga, lga, false, lga === selectedLga));
                    });
                };

                if (stateSelect && lgaSelect) {
                    populateLgas(stateSelect.value, lgaSelect.dataset.selectedLga || '');

                    stateSelect.addEventListener('change', () => {
                        populateLgas(stateSelect.value);
                        updateSummary();
                    });

                    lgaSelect.addEventListener('change', updateSummary);
                }

                const documentsContainer = form.querySelector('[data-education-documents]');
                const addDocumentButton = form.querySelector('[data-add-document]');
                const documentTemplate = document.getElementById('education-document-template');

                const refreshDocumentRows = () => {
                    if (!documentsContainer) {
                        return;
                    }

                    const rows = Array.from(documentsContainer.querySelectorAll('[data-education-document]'));

                    rows.forEach((row, index) => {
                        const number = index + 1;
                        const type = row.querySelector('[data-document-type]');
                        const file = row.querySelector('[data-document-file]');
                        const typeLabel = row.querySelector('[data-document-type-label]');
                        const fileLabel = row.querySelector('[data-document-file-label]');
                        const removeButton = row.querySelector('[data-remove-document]');
                        const title = row.querySelector('[data-document-title]');

                        if (title) {
                            title.textContent = `Qualification Document ${number}`;
                        }

                        if (type) {
                            type.name = `education_documents[${index}][type]`;
                            type.id = `education-document-type-${index}`;
                        }

                        if (file) {
                            file.name = `education_documents[${index}][file]`;
                            file.id = `education-document-file-${index}`;
                        }

                        if (typeLabel) {
                            typeLabel.setAttribute('for', `education-document-type-${index}`);
                        }

                        if (fileLabel) {
                            fileLabel.setAttribute('for', `education-document-file-${index}`);
                        }

                        if (removeButton) {
                            removeButton.hidden = rows.length === 1;
                        }
                    });

                    updateSummary();

                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                };

                addDocumentButton?.addEventListener('click', () => {
                    if (!documentTemplate || !documentsContainer) {
                        return;
                    }

                    const currentRows = documentsContainer.querySelectorAll('[data-education-document]').length;

                    if (currentRows >= 10) {
                        return;
                    }

                    documentsContainer.append(documentTemplate.content.firstElementChild.cloneNode(true));
                    refreshDocumentRows();
                    documentsContainer.lastElementChild?.querySelector('select')?.focus();
                });

                documentsContainer?.addEventListener('click', (event) => {
                    const removeButton = event.target.closest('[data-remove-document]');

                    if (!removeButton) {
                        return;
                    }

                    const rows = documentsContainer.querySelectorAll('[data-education-document]');

                    if (rows.length <= 1) {
                        return;
                    }

                    removeButton.closest('[data-education-document]')?.remove();
                    refreshDocumentRows();
                });

                function fieldValue(name) {
                    return form.elements[name]?.value?.trim() || '';
                }

                function updateSummary() {
                    const fullName = [fieldValue('first_name'), fieldValue('last_name')].filter(Boolean).join(' ');
                    const origin = [fieldValue('local_government_area'), fieldValue('state_of_origin')].filter(Boolean).join(', ');
                    const documentCount = documentsContainer?.querySelectorAll('[data-education-document]').length || 0;

                    const summary = {
                        '[data-summary-full-name]': fullName,
                        '[data-summary-contact]': fieldValue('phone'),
                        '[data-summary-origin]': origin,
                        '[data-summary-nationality]': fieldValue('nationality'),
                        '[data-summary-documents]': String(documentCount),
                    };

                    Object.entries(summary).forEach(([selector, value]) => {
                        const target = document.querySelector(selector);

                        if (target) {
                            target.textContent = value || 'Not provided';
                        }
                    });
                }

                form.addEventListener('click', (event) => {
                    if (event.target.closest('[data-wizard-next]')) {
                        if (validateCurrentStep()) {
                            showStep(currentStep + 1);
                            updateSummary();
                        }
                    }

                    if (event.target.closest('[data-wizard-previous]')) {
                        showStep(currentStep - 1);
                        updateSummary();
                    }
                });

                form.addEventListener('input', updateSummary);
                form.addEventListener('change', updateSummary);

                refreshDocumentRows();
                updateSummary();
                showStep(0);
            })();
        </script>
    @endpush
</x-admin-layout>
