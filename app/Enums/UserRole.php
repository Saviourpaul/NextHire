<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Employer = 'employer';
    case Applicant = 'applicant';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Employer => 'Employer',
            self::Applicant => 'Applicant',
        };
    }
}
