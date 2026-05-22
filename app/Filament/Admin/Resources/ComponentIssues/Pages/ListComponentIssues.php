<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ComponentIssues\Pages;

use App\Filament\Admin\Resources\ComponentIssues\ComponentIssueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListComponentIssues extends ListRecords
{
    protected static string $resource = ComponentIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
