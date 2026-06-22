<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationDocumentDownloadController extends Controller
{
    public function __invoke(Request $request, ApplicationDocument $applicationDocument): StreamedResponse
    {
        $applicationDocument->loadMissing('applicationForm.job');

        $user = $request->user();
        $application = $applicationDocument->applicationForm;

        $canDownload = ($user->isApplicant() && $application->user_id === $user->id)
            || ($user->isEmployer() && $application->job->employer_id === $user->id)
            || $user->isAdmin();

        abort_unless($canDownload, 403);

        $disk = Storage::disk('local')->exists($applicationDocument->file_path)
            ? Storage::disk('local')
            : Storage::disk('public');

        abort_unless($disk->exists($applicationDocument->file_path), 404);

        return $disk->download(
            $applicationDocument->file_path,
            $applicationDocument->original_name
        );
    }
}
