<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Filament\Admin\Resources\Issues\IssueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListIssues extends ListRecords
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
