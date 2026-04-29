<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\IssueStatus;
use Database\Factories\IssueNoteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'issue_id', 'description', 'previous_state', 'new_state'])]
final class IssueNote extends Model
{
    /** @use HasFactory<IssueNoteFactory> */
    use HasFactory;

    protected $casts = [
        'previous_state' => IssueStatus::class,
        'new_state' => IssueStatus::class,
    ];

    /**
     * @return BelongsTo<Issue, $this>
     */
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
