<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ComponentIssues\Pages;

use App\Filament\Admin\Resources\ComponentIssues\ComponentIssueResource;
use App\Models\Issue;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditComponentIssue extends EditRecord
{
    protected static string $resource = ComponentIssueResource::class;

    public function getRecord(): Issue
    {
        return Issue::with(['customer', 'author', 'machine'])->findOrFail($this->record->id); // @phpstan-ignore-line
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
