<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Pages;

use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSecondHandMachine extends ViewRecord
{
    protected static string $resource = SecondHandMachineResource::class;

    protected string $view = 'filament.employee.resources.second-hand-machines.pages.view-second-hand-machine';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
