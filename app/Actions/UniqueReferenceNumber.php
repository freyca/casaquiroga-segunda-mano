<?php

declare(strict_types=1);

namespace App\Actions;

final class UniqueReferenceNumber
{
    public static function create(string $type): string
    {
        return sprintf('%s-%s', $type, now()->format('ymd-His'));
    }
}
