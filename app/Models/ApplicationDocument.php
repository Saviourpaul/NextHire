<?php

namespace App\Models;

use App\Enums\ApplicationDocumentType;
use App\Enums\ApplicationStatus;
use Database\Factories\ApplicationDocumentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ApplicationDocument extends Model
{
    /** @use HasFactory<ApplicationDocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'application_form_id',
        'document_type',
        'document_name',
        'document_number',
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'status',
        'reviewed_by',
        'reviewed_at',
        'employer_remarks',
    ];

    protected function casts(): array
    {
        return [
            'document_type' => ApplicationDocumentType::class,
            'status' => ApplicationStatus::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function applicationForm(): BelongsTo
    {
        return $this->belongsTo(ApplicationForm::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ApplicationDocumentStatusHistory::class);
    }

    public function downloadUrl(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
