<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum status: string implements HasLabel
{
    case active = 'active';
    case inactive = 'inactive';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::active => 'active',
            self::inactive => 'inactive',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::active => 'success',
            self::inactive => 'danger',
        };
    }
}