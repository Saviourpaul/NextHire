<?php

namespace App\Enums;

enum ApplicationDocumentType: string
{
    case Nin = 'nin';
    case Bvn = 'bvn';
    case Education = 'education';

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
            self::Nin => 'National Identity Number',
            self::Bvn => 'Bank Verification Number',
            self::Education => 'Educational Qualification',
        };
    }
}
