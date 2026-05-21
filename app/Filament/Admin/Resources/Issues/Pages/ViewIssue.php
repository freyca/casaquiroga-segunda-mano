<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Enums\IssueStatus;
use App\Enums\Role;
use App\Filament\Admin\Resources\Issues\IssueResource;
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

        if (auth()->user()?->role === Role::Admin) { // @phpstan-ignore-line
            $actions[] = EditAction::make();
        }

        $actions[] = Action::make('change_status')
            ->label(Str::ucfirst(__('issues.change_status')))
            ->icon('heroicon-m-plus')
            ->schema([
                ToggleButtons::make('issue_status')
                    ->label(Str::ucfirst(__('issues.issue_status')))
                    ->options(IssueStatus::class)
                    ->default($this->record->status) // @phpstan-ignore-line
                    ->required()
                    ->inline(),

                Textarea::make('note_description')
                    ->label(Str::ucfirst(__('app.note')))
                    ->required(),
            ])
            ->action(function (array $data): void {
                $this->record->notes()->create([ // @phpstan-ignore-line
                    'user_id' => auth()->id(),
                    'description' => $data['note_description'],
                    'previous_state' => $this->record->status, // @phpstan-ignore-line
                    'new_state' => $data['issue_status'],
                ]);

                $this->record->status = $data['issue_status']; // @phpstan-ignore-line
                $this->record->save(); // @phpstan-ignore-line

                $this->record->refresh(); // @phpstan-ignore-line
            });

        return $actions;
    }
}
