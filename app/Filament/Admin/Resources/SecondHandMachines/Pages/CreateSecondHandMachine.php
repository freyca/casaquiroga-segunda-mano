<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Pages;

use App\Filament\Admin\Resources\SecondHandMachines\SecondHandMachineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSecondHandMachine extends CreateRecord
{
    protected static string $resource = SecondHandMachineResource::class;
}
