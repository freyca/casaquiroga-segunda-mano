<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Filament\Admin\Resources\Issues\IssueResource;
use App\Models\Order;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditIssue extends EditRecord
{
    protected static string $resource = IssueResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var Order */
        $order = $this->record->order; // @phpstan-ignore-line

        $order->update([
            'type' => $data['order_type'],
        ]);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
