<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Familias\Pages;

use App\Filament\Admin\Resources\Familias\FamiliaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFamilia extends CreateRecord
{
    protected static string $resource = FamiliaResource::class;
}
