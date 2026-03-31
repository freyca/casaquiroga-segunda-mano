<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Families\Pages;

use App\Filament\Admin\Resources\Families\FamilyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditFamily extends EditRecord
{
    protected static string $resource = FamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
