<?php

declare(strict_types=1);

namespace App\Actions;

final class UniqueReferenceNumber
{
    public static function create(string $type): string
    {
        return sprintf('%s-%s-%03d-%04d', $type, now()->format('y'), now()->dayOfYear, random_int(0, 9999));
    }
}
