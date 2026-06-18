<?php

namespace App\Http\Requests;

use App\Enums\ApplicationStatus;
use App\Models\ApplicationDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewApplicationDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $document = $this->route('applicationDocument');
        $user = $this->user();

        if (! $document instanceof ApplicationDocument || ! $user?->isEmployer()) {
            return false;
        }

        $document->loadMissing('applicationForm.job');

        return $document->applicationForm->job->employer_id === $user->id;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(ApplicationStatus::values())],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
