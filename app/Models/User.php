<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'role',
        'status',
        'approved_at',
        'suspended_at',
        'last_login_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => 'applicant',
        'status' => 'pending',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'approved_at' => 'datetime',
            'suspended_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isEmployer(): bool
    {
        return $this->role === UserRole::Employer;
    }

    public function isApplicant(): bool
    {
        return $this->role === UserRole::Applicant;
    }

    public function hasRole(UserRole|string ...$roles): bool
    {
        $values = array_map(
            fn (UserRole|string $role): string => $role instanceof UserRole ? $role->value : $role,
            $roles
        );

        return in_array($this->role->value, $values, true);
    }

    public function isPending(): bool
    {
        return $this->status === UserStatus::Pending;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active;
    }

    public function isSuspended(): bool
    {
        return $this->status === UserStatus::Suspended;
    }

    public function scopeRole(Builder $query, UserRole|string $role): Builder
    {
        return $query->where('role', $role instanceof UserRole ? $role->value : $role);
    }

    public function scopeStatus(Builder $query, UserStatus|string $status): Builder
    {
        return $query->where('status', $status instanceof UserStatus ? $status->value : $status);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->status(UserStatus::Active);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->status(UserStatus::Pending);
    }

    public function scopeSuspended(Builder $query): Builder
    {
        return $query->status(UserStatus::Suspended);
    }

    public function activate(): bool
    {
        $this->status = UserStatus::Active;
        $this->approved_at ??= now();
        $this->suspended_at = null;

        return $this->save();
    }

    public function suspend(): bool
    {
        $this->status = UserStatus::Suspended;
        $this->suspended_at = now();

        return $this->save();
    }
}
