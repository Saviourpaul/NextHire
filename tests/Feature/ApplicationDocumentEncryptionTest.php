<?php

use App\Enums\ApplicationDocumentType;
use App\Models\ApplicationDocument;
use App\Models\ApplicationForm;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;

it('encrypts document numbers when saving and exposes masked values', function () {
    $document = ApplicationDocument::factory()->create([
        'document_number' => '12345678901',
    ]);

    expect($document->getRawOriginal('document_number'))
        ->not->toBe('12345678901')
        ->and($document->document_number)->toBe('12345678901')
        ->and($document->documentNumberIsEncrypted())->toBeTrue()
        ->and($document->maskedDocumentNumber())->toBe('*******8901');
});

it('reads legacy plaintext document numbers without breaking accessors', function () {
    $document = ApplicationDocument::factory()->create([
        'document_number' => null,
    ]);

    DB::table('application_documents')
        ->where('id', $document->id)
        ->update(['document_number' => '12345678901']);

    $document->refresh();

    expect($document->getRawOriginal('document_number'))
        ->toBe('12345678901')
        ->and($document->document_number)->toBe('12345678901')
        ->and($document->documentNumberIsEncrypted())->toBeFalse()
        ->and($document->maskedDocumentNumber())->toBe('*******8901');
});

it('masks document numbers on employer application review pages', function () {
    $employer = User::factory()->employer()->create();
    $applicant = User::factory()->applicant()->create();
    $job = Job::factory()->for($employer, 'employer')->create();
    $application = ApplicationForm::factory()
        ->for($job, 'job')
        ->for($applicant, 'applicant')
        ->create();

    ApplicationDocument::factory()
        ->for($application, 'applicationForm')
        ->type(ApplicationDocumentType::Nin)
        ->create([
            'document_number' => '12345678901',
        ]);

    $this->actingAs($employer)
        ->get(route('employer.applications.show', $application))
        ->assertOk()
        ->assertSee(route('application-documents.preview', ApplicationDocument::query()->firstOrFail()), false)
        ->assertSee('Preview')
        ->assertSee('Download')
        ->assertSee('*******8901')
        ->assertDontSee('12345678901');
});
