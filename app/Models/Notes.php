<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SellStatus;
use Database\Factories\NotesFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['description', 'user_id', 'second_hand_machine_id', 'previous_state', 'new_state'])]
final class Notes extends Model
{
    /** @use HasFactory<NotesFactory> */
    use HasFactory;

    protected $casts = [
        'previous_state' => SellStatus::class,
        'new_state' => SellStatus::class,
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
