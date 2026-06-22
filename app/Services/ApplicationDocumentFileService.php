<?php

namespace App\Services;

use App\Models\ApplicationDocument;
use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class ApplicationDocumentFileService
{
    public function authorize(?User $user, ApplicationDocument $document): void
    {
        abort_unless($this->userCanAccess($user, $document), 403);
    }

    public function userCanAccess(?User $user, ApplicationDocument $document): bool
    {
        if (! $user) {
            return false;
        }

        $document->loadMissing('applicationForm.job');

        $application = $document->applicationForm;

        if (! $application) {
            return false;
        }

        return ($user->isApplicant() && $application->user_id === $user->id)
            || ($user->isEmployer() && $application->job?->employer_id === $user->id)
            || $user->isAdmin();
    }

    public function diskFor(ApplicationDocument $document): FilesystemAdapter
    {
        $path = trim((string) $document->file_path);

        abort_if($path === '', 404);

        foreach (['local', 'public'] as $diskName) {
            $disk = Storage::disk($diskName);

            if ($disk->exists($path)) {
                return $disk;
            }
        }

        abort(404);
    }

    public function assertPreviewable(ApplicationDocument $document, FilesystemAdapter $disk): void
    {
        abort_unless(
            ApplicationDocument::mimeTypeCanPreview($this->mimeTypeFor($document, $disk)),
            415,
            'This document type cannot be previewed. Download it instead.'
        );
    }

    /**
     * @return array<string, string>
     */
    public function responseHeaders(ApplicationDocument $document, FilesystemAdapter $disk): array
    {
        return [
            'Content-Type' => $this->mimeTypeFor($document, $disk) ?: 'application/octet-stream',
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ];
    }

    private function mimeTypeFor(ApplicationDocument $document, FilesystemAdapter $disk): ?string
    {
        if ($document->mime_type) {
            return $document->mime_type;
        }

        return $disk->mimeType($document->file_path) ?: null;
    }
}
