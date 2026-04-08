<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Pages;

use App\Enums\SellStatus;
use App\Filament\Employee\Resources\SecondHandMachines\Actions\AfterEditAction;
use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource;
use App\Models\SecondHandMachine;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewSecondHandMachine extends ViewRecord
{
    protected static string $resource = SecondHandMachineResource::class;

    protected string $view = 'filament.employee.pages.view-second-hand-machine';

    private SellStatus $previous_status;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->modalHeading(ucfirst(__('edit_machine')))
                ->before(function (SecondHandMachine $record): void {
                    $this->previous_status = $record->sell_status;
                })
                ->after(function (SecondHandMachine $record, array $data): void {
                    AfterEditAction::saveNote($record, $data, $this->previous_status); // @phpstan-ignore-line
                }),
        ];
    }
}
