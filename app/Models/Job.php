<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory;

    protected $table = 'job_posts';

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'company',
        'logo',
        'start_date',
        'due_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ApplicationForm::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function logoUrl(): string
    {
        $defaultLogo = 'assets/img/default-logo.svg';

        if (! $this->logo) {
            return asset($defaultLogo);
        }

        $path = ltrim($this->logo, '/');

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/'.$path);
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return asset($defaultLogo);
    }

    public function storedLogoPath(): ?string
    {
        if (! $this->logo || filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return null;
        }

        $path = ltrim($this->logo, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        return Storage::disk('public')->exists($path) ? $path : null;
    }
}
