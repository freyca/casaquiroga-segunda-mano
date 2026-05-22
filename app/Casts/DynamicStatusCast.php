<?php

declare(strict_types=1);

namespace App\Casts;

use App\Enums\IssueStatus;
use App\Enums\SellStatus;
use App\Models\Issue;
use App\Models\SecondHandMachine;
use BackedEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<IssueStatus|SellStatus, IssueStatus|SellStatus>
 */
final class DynamicStatusCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): IssueStatus|SellStatus|null
    {
        $statusClass = $this->getStatusEnumClass($model);

        return $statusClass::tryFrom($value); // @phpstan-ignore-line
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value instanceof BackedEnum ? $value->value : $value;
    }

    private function getStatusEnumClass(Model $model): string
    {
        $mapping = [
            Issue::class => IssueStatus::class,
            SecondHandMachine::class => SellStatus::class,
        ];

        $noteableType = $model->getAttribute('noteable_type');

        return $mapping[$noteableType] ?? IssueStatus::class; // @phpstan-ignore-line
    }
}
