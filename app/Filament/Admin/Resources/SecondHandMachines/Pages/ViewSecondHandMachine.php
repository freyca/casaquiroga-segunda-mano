<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Pages;

use App\Filament\Admin\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewSecondHandMachine extends ViewRecord
{
    protected static string $resource = SecondHandMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
