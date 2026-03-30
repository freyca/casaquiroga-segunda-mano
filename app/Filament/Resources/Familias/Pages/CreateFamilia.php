<?php

declare(strict_types=1);

namespace App\Filament\Resources\Familias\Pages;

use App\Filament\Resources\Familias\FamiliaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFamilia extends CreateRecord
{
    protected static string $resource = FamiliaResource::class;
}
