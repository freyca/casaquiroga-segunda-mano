<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Pages;

use App\Enums\SellStatus;
use App\Filament\Employee\Resources\SecondHandMachines\Actions\AfterEditAction;
use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource;
use App\Models\SecondHandMachine;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

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
            Action::make('download_pdf')
                ->label(ucfirst(__('download_pdf')))
                ->icon(Heroicon::ArrowDown)
                ->color('info')
                ->action(function (SecondHandMachine $record) {
                    $filename = Str::slug((string) ($record->identifier_code ?: $record->name ?: 'machine')).'.pdf';

                    $pdf = Pdf::loadView('secondhandmachines.print', [
                        'machine' => $record->loadMissing('brand'),
                    ])
                        ->setOption('isRemoteEnabled', true)
                        ->setPaper('a4');

                    return response()->streamDownload(function () use ($pdf): void {
                        echo $pdf->output();
                    }, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
        ];
    }
}
