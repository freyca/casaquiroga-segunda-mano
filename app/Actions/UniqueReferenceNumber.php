<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Str;

final class UniqueReferenceNumber
{
    public static function create(string $type): string
    {
        return sprintf(
            '%s-%s-%s',
            $type,
            now()->format('y'),
            Str::ulid()
        );
    }
}
