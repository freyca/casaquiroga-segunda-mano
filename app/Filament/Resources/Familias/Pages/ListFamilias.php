<?php

declare(strict_types=1);

namespace App\Filament\Resources\Familias\Pages;

use App\Filament\Resources\Familias\FamiliaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFamilias extends ListRecords
{
    protected static string $resource = FamiliaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
