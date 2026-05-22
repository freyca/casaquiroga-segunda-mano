<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\DynamicStatusCast;
use Database\Factories\NoteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['user_id', 'noteable_id', 'noteable_type', 'description', 'previous_state', 'new_state'])]
final class Note extends Model
{
    /** @use HasFactory<NoteFactory> */
    use HasFactory;

    protected $casts = [
        'previous_state' => DynamicStatusCast::class,
        'new_state' => DynamicStatusCast::class,
    ];

    /**
     * @return MorphTo<Model, Note>
     */
    public function noteable(): MorphTo
    {
        // @codeCoverageIgnoreStart
        return $this->morphTo(); // @phpstan-ignore-line
        // @codeCoverageIgnoreEnd
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
