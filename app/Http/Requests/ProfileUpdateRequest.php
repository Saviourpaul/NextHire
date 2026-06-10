<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $profileFieldRule = $this->user()->isApplicant() ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'];
        $dateOfBirthRule = $this->user()->isApplicant() ? ['required', 'date', 'before:today'] : ['nullable', 'date', 'before:today'];
        $imageRule = $this->user()->isApplicant() && ! $this->user()->profile_image_path ? ['required'] : ['nullable'];

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::in([$this->user()->email]),
            ],
            'profile_image' => [
                ...$imageRule,
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp', 'gif'])
                    ->max(2048),
            ],
            'date_of_birth' => $dateOfBirthRule,
            'phone' => $profileFieldRule,
            'address' => $profileFieldRule,
            'country' => $profileFieldRule,
            'state' => $profileFieldRule,
            'city' => $profileFieldRule,
            'zipcode' => $profileFieldRule,
        ];
    }
}
