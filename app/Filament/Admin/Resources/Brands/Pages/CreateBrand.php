<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Brands\Pages;

use App\Filament\Admin\Resources\Brands\BrandResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;
}
