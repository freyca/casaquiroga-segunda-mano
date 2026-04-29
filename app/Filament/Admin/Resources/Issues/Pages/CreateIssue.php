<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Filament\Admin\Resources\Issues\IssueResource;
use App\Models\Order;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

final class CreateIssue extends CreateRecord
{
    protected static string $resource = IssueResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return DB::transaction(function () use ($data): array {
            $order = Order::query()->create([
                'number' => $data['order_number'],
                'type' => $data['order_type'],
            ]);

            $data['order_id'] = $order->id;
            $data['created_by'] = auth()->id();

            return $data;
        });
    }
}
