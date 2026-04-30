<?php

declare(strict_types=1);

namespace App\Models\Concerns;

/**
 * @property string $reference_number
 */
interface HasReferenceNumberContract
{
    public function getReferencePrefix(): string;
}
