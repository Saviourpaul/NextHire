<?php

namespace App\Http\Requests;

use App\Models\ApplicationForm;
use App\Models\Job;
use App\Models\NigeriaState;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class StoreApplicationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        $job = $this->route('job');
        $user = $this->user();

        return $job instanceof Job
            && $user?->isApplicant()
            && $job->status === 'active';
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $user = $this->user();

        return [
            'profile_image' => [
                Rule::requiredIf(fn (): bool => blank($user?->profile_image_path)),
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(5 * 1024),
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'nationality' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'marital_status' => ['nullable', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'state_of_origin' => ['required', 'string', 'max:255', Rule::exists('nigeria_states', 'name')],
            'local_government_area' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:30'],
            'nin_number' => ['required', 'string', 'max:50'],
            'nin_document' => [
                'required',
                File::types(['pdf', 'jpg', 'jpeg', 'png'])->max(5 * 1024),
            ],
            'bvn_number' => ['required', 'string', 'max:50'],
            'bvn_document' => [
                'required',
                File::types(['pdf', 'jpg', 'jpeg', 'png'])->max(5 * 1024),
            ],
            'education_documents' => ['required', 'array', 'min:1', 'max:10'],
            'education_documents.*.type' => [
                'required',
                Rule::in(['ssce', 'ond', 'bsc', 'bed', 'nysc', 'msc', 'phd', 'other']),
            ],
            'education_documents.*.file' => [
                'required',
                File::types(['pdf', 'jpg', 'jpeg', 'png'])->max(5 * 1024),
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $job = $this->route('job');
            $user = $this->user();

            if (! $job instanceof Job || ! $user) {
                return;
            }

            $alreadyApplied = ApplicationForm::query()
                ->where('job_id', $job->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($alreadyApplied) {
                $validator->errors()->add('job', 'You have already applied for this job.');
            }

            $state = NigeriaState::query()
                ->where('name', (string) $this->input('state_of_origin'))
                ->first();

            if (! $state) {
                return;
            }

            $hasLga = $state->localGovernmentAreas()
                ->where('name', (string) $this->input('local_government_area'))
                ->exists();

            if (! $hasLga) {
                $validator->errors()->add('local_government_area', 'Select a local government area in the selected state.');
            }
        });
    }
}
