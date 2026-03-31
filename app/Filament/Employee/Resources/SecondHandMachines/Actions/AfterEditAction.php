<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Actions;

use App\Enums\SellStatus;
use App\Models\SecondHandMachine;

final class AfterEditAction
{
    /**
     * @param  array<string, string>  $data
     */
    public static function saveNote(SecondHandMachine $record, array $data, SellStatus $previous): void
    {
        $record->notes()->create([
            'description' => $data['note_description'],
            'user_id' => auth()->id(),
            'previous_state' => $previous,
            'new_state' => $record->sell_status,
        ]);
    }
}
