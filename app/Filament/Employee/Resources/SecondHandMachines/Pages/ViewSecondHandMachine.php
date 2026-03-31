<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Pages;

use App\Enums\Status;
use App\Filament\Employee\Resources\SecondHandMachines\Actions\AfterEditAction;
use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource;
use App\Models\SecondHandMachine;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSecondHandMachine extends ViewRecord
{
    protected Status $previous_status;

    protected static string $resource = SecondHandMachineResource::class;

    protected string $view = 'filament.employee.resources.second-hand-machines.pages.view-second-hand-machine';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->before(function (SecondHandMachine $record) {
                    $this->previous_status = $record->sell_status;
                })
                ->after(function (SecondHandMachine $record, array $data) {
                    AfterEditAction::saveNote($record, $data, $this->previous_status); // @phpstan-ignore-line
                }),
        ];
    }
}
