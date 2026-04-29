<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Pages;

use App\Filament\Admin\Resources\Issues\IssueResource;
use App\Models\Issue;
use App\Models\Order;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditIssue extends EditRecord
{
    protected static string $resource = IssueResource::class;

    public function getRecord(): Issue
    {
        return Issue::with(['order', 'user', 'machine'])->findOrFail($this->record->id); // @phpstan-ignore-line
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var false|Order */
        $order = $this->record->order; // @phpstan-ignore-line
        abort_if(! $order, 404, 'Order not found.');

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
