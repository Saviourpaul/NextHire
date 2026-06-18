<?php

namespace Database\Factories;

use App\Enums\ApplicationDocumentType;
use App\Enums\ApplicationStatus;
use App\Models\ApplicationDocument;
use App\Models\ApplicationForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApplicationDocument>
 */
class ApplicationDocumentFactory extends Factory
{
    protected $model = ApplicationDocument::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(ApplicationDocumentType::cases());

        return [
            'application_form_id' => ApplicationForm::factory(),
            'document_type' => $type,
            'document_name' => $type->label(),
            'document_number' => fake()->numerify('###########'),
            'file_path' => 'application-documents/sample.pdf',
            'original_name' => fake()->word().'.pdf',
            'mime_type' => 'application/pdf',
            'size' => fake()->numberBetween(10000, 2000000),
            'status' => ApplicationStatus::Pending,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'employer_remarks' => null,
        ];
    }

    public function type(ApplicationDocumentType $type): static
    {
        return $this->state(fn (array $attributes) => [
            'document_type' => $type,
            'document_name' => $type->label(),
        ]);
    }

    public function approved(?User $reviewer = null): static
    {
        return $this->reviewed(ApplicationStatus::Approved, $reviewer);
    }

    public function rejected(?User $reviewer = null): static
    {
        return $this->reviewed(ApplicationStatus::Rejected, $reviewer, 'Document did not pass review.');
    }

    public function reviewed(ApplicationStatus $status, ?User $reviewer = null, ?string $remarks = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
            'reviewed_by' => $reviewer?->id,
            'reviewed_at' => now(),
            'employer_remarks' => $remarks,
        ]);
    }
}
