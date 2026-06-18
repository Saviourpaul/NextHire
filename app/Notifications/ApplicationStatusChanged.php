<?php

namespace App\Notifications;

use App\Models\ApplicationForm;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        private readonly ApplicationForm $application,
        private readonly ?string $remarks = null
    ) {
        $this->application->loadMissing('job');
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
        return [
            'title' => 'Application '.$this->application->status->label(),
            'message' => 'Your application for '.$this->application->job->title.' is now '.$this->application->status->label().'.',
            'application_id' => $this->application->id,
            'reference' => $this->application->reference,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job->title,
            'status' => $this->application->status->value,
            'remarks' => $this->remarks,
            'action_url' => route('client.applications.show', $this->application),
        ];
    }
}
