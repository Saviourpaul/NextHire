<?php

namespace App\Notifications;

use App\Models\ApplicationDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationDocumentStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        private readonly ApplicationDocument $document,
        private readonly ?string $remarks = null
    ) {
        $this->document->loadMissing('applicationForm.job');
    }

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $application = $this->document->applicationForm;

        return [
            'title' => $this->document->document_name.' '.$this->document->status->label(),
            'message' => 'Your '.$this->document->document_name.' for '.$application->job->title.' is now '.$this->document->status->label().'.',
            'application_id' => $application->id,
            'document_id' => $this->document->id,
            'reference' => $application->reference,
            'job_id' => $application->job_id,
            'job_title' => $application->job->title,
            'document_name' => $this->document->document_name,
            'status' => $this->document->status->value,
            'remarks' => $this->remarks,
            'action_url' => route('client.applications.show', $application),
        ];
    }
}
