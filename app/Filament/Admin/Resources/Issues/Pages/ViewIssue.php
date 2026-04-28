<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Filament\Admin\Resources\Issues\IssueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewIssue extends ViewRecord
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
