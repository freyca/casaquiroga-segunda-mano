<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use Database\Factories\NotesFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['descripcion', 'user_id', 'second_hand_machine_id', 'previous_state', 'new_state'])]
class Notes extends Model
{
    /** @use HasFactory<NotesFactory> */
    use HasFactory;

    protected $casts = [
        'previous_state' => Status::class,
        'new_state' => Status::class,
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
