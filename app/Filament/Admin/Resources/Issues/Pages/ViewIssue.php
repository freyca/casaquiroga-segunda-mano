<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Enums\IssueStatus;
use App\Filament\Admin\Resources\Issues\IssueResource;
use App\Models\IssueNote;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

final class ViewIssue extends ViewRecord
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (filament()->getCurrentPanel()->getId() === 'admin') {
            $actions[] = EditAction::make();
        }

        $actions[] = Action::make('change_status')
            ->label(Str::ucfirst(__('change status')))
            ->icon('heroicon-m-plus')
            ->schema([
                ToggleButtons::make('issue_status')
                    ->label(Str::ucfirst(__('issue status')))
                    ->options(IssueStatus::class)
                    ->default($this->record->status)
                    ->required()
                    ->inline(),

                Textarea::make('note_description')
                    ->label(Str::ucfirst(__('note')))
                    ->required(),
            ])
            ->action(function (array $data): void {
                IssueNote::query()->create([
                    'issue_id' => $this->record->id,
                    'user_id' => auth()->id(),
                    'description' => $data['note_description'],
                    'previous_state' => $this->record->status,
                    'new_state' => $data['issue_status'],
                ]);

                $this->record->status = $data['issue_status'];
                $this->record->save();

                $this->record->refresh();
            });

        return $actions;
    }
}
