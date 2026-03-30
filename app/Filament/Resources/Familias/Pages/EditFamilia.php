<?php

declare(strict_types=1);

namespace App\Filament\Resources\Familias\Pages;

use App\Filament\Resources\Familias\FamiliaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFamilia extends EditRecord
{
    protected static string $resource = FamiliaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
