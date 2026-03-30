<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Pages;

use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSecondHandMachine extends CreateRecord
{
    protected static string $resource = SecondHandMachineResource::class;
}
