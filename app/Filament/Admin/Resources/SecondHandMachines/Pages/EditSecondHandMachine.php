<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Pages;

use App\Filament\Admin\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditSecondHandMachine extends EditRecord
{
    protected static string $resource = SecondHandMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
