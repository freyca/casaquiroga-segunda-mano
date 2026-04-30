<?php

declare(strict_types=1);

namespace App\Traits;

use App\Actions\UniqueReferenceNumber;
use App\Concerns\HasReferenceNumberContract;
use Illuminate\Database\Eloquent\Model;

trait HasReferenceNumber
{
    protected static function bootHasReferenceNumber(): void
    {
        static::creating(function (Model&HasReferenceNumberContract $model): void {
            $model->reference_number = UniqueReferenceNumber::create($model->getReferencePrefix()); // @phpstan-ignore-line
        });
    }
}
