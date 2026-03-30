<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Pages;

use App\Filament\Admin\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSecondHandMachines extends ListRecords
{
    protected static string $resource = SecondHandMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
