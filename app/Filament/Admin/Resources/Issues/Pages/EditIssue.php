<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Filament\Admin\Resources\Issues\IssueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditIssue extends EditRecord
{
    protected static string $resource = IssueResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $order = $this->record->order;
        abort_if(! $order, 404, 'Order not found.');

        $order->update([
            'number' => $data['order_number'],
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
