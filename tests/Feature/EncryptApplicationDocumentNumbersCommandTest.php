<?php

use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\DB;

it('previews plaintext document numbers without encrypting by default', function () {
    $document = ApplicationDocument::factory()->create([
        'document_number' => null,
    ]);

    DB::table('application_documents')
        ->where('id', $document->id)
        ->update(['document_number' => '12345678901']);

    $this->artisan('app:encrypt-application-document-numbers')
        ->expectsOutputToContain('Dry run')
        ->assertSuccessful();

    expect(DB::table('application_documents')->where('id', $document->id)->value('document_number'))
        ->toBe('12345678901');
});

it('encrypts legacy plaintext document numbers when committed', function () {
    $document = ApplicationDocument::factory()->create([
        'document_number' => null,
    ]);

    DB::table('application_documents')
        ->where('id', $document->id)
        ->update(['document_number' => '12345678901']);

    $this->artisan('app:encrypt-application-document-numbers', ['--commit' => true])
        ->assertSuccessful();

    $document->refresh();

    expect($document->getRawOriginal('document_number'))
        ->not->toBe('12345678901')
        ->and($document->document_number)->toBe('12345678901')
        ->and($document->documentNumberIsEncrypted())->toBeTrue();
});

it('skips document numbers that are already encrypted', function () {
    $document = ApplicationDocument::factory()->create([
        'document_number' => '12345678901',
    ]);

    $encryptedValue = $document->getRawOriginal('document_number');

    $this->artisan('app:encrypt-application-document-numbers', ['--commit' => true])
        ->assertSuccessful();

    expect(DB::table('application_documents')->where('id', $document->id)->value('document_number'))
        ->toBe($encryptedValue);
});
