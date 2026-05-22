<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ComponentIssues\Pages;

use App\Filament\Admin\Resources\ComponentIssues\ComponentIssueResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

final class CreateComponentIssue extends CreateRecord
{
    protected static string $resource = ComponentIssueResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return DB::transaction(function () use ($data): array {
            $data['created_by'] = auth()->id();

            return $data;
        });
    }
}
