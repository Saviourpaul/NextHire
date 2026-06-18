<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Http\Requests\ReviewApplicationDocumentRequest;
use App\Models\ApplicationDocument;
use App\Services\ApplicationFormService;
use Illuminate\Http\RedirectResponse;

class EmployerApplicationDocumentController extends Controller
{
    public function update(
        ReviewApplicationDocumentRequest $request,
        ApplicationDocument $applicationDocument,
        ApplicationFormService $service
    ): RedirectResponse {
        $data = $request->validated();

        $service->reviewDocument(
            $applicationDocument,
            $request->user(),
            ApplicationStatus::from($data['status']),
            $data['remarks'] ?? null
        );

        return back()->with('success', 'Document status updated.');
    }
}
