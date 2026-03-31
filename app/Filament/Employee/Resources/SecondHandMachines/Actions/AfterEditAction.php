<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Actions;

use App\Enums\Status;
use App\Models\SecondHandMachine;

class AfterEditAction
{
    /**
     * @param  array<string, string>  $data
     */
    public static function saveNote(SecondHandMachine $record, array $data, Status $previous): void
    {
        $record->notes()->create([
            'description' => $data['new_note'],
            'user_id' => auth()->id(),
            'previous_state' => $previous,
            'new_state' => $record->sell_status,
        ]);
    }
}
