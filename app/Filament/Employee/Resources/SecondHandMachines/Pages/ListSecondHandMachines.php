<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Pages;

use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Resources\Pages\ListRecords;

final class ListSecondHandMachines extends ListRecords
{
    protected static string $resource = SecondHandMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
