<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
use App\Models\Concerns\HasReferenceNumber;
use App\Models\Concerns\HasReferenceNumberContract;
use Database\Factories\IssueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'customer_id',
    'created_by',
    'order_id',
    'machine_id',
    'priority',
    'status',
    'type',
    'description',
    'just_arrived',
    'observations',
    'images',
    'reference_number',
])]
final class Issue extends Model implements HasReferenceNumberContract
{
    /** @use HasFactory<IssueFactory> */
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
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo<Machine, $this>
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    /**
     * @return HasMany<IssueNote, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(IssueNote::class);
    }

    protected function casts(): array
    {
        return [
            'type' => IssueType::class,
            'priority' => IssuePriority::class,
            'status' => IssueStatus::class,
            'just_arrived' => 'boolean',
            'images' => 'array',
        ];
    }

    public function getReferencePrefix(): string
    {
        return 'SAT';
    }
}
