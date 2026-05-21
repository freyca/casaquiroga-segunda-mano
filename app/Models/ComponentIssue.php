<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasReferenceNumberContract;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Traits\HasReferenceNumber;
use Database\Factories\ComponentIssueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'customer_id',
    'created_by',
    'machine_id',
    'status',
    'priority',
    'description',
    'just_arrived',
    'images',
    'reference_number',
])]
final class ComponentIssue extends Model implements HasReferenceNumberContract
{
    /** @use HasFactory<ComponentIssueFactory> */
    use HasFactory;

    use HasReferenceNumber;

    /**
     * @return BelongsTo<User, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo<Machine, $this>
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    /**
     * @return MorphMany<Note, $this>
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function getReferencePrefix(): string
    {
        return 'REC';
    }

    protected function casts(): array
    {
        return [
            'priority' => IssuePriority::class,
            'status' => IssueStatus::class,
            'just_arrived' => 'boolean',
            'images' => 'array',
        ];
    }
}
