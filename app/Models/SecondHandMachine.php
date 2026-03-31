<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SellStatus;
use App\Enums\Tax;
use Database\Factories\SecondHandMachineFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'identifier_code',
    'name',
    'purchase_cost',
    'purchase_notes',
    'model',
    'serial_number',
    'selling_price',
    'tax',
    'work_hours',
    'description',
    'sell_status',
    'repair_workshop',
    'photos',
    'attachments',
    'brand_id',
    'employee_id',
    'customer_id',
    'family_id',
])]
final class SecondHandMachine extends Model
{
    /** @use HasFactory<SecondHandMachineFactory> */
    use HasFactory;

    protected $casts = [
        'purchase_cost' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'repair_workshop' => 'decimal:2',
        'tax' => Tax::class,
        'sell_status' => SellStatus::class,
        'work_hours' => 'integer',
        'photos' => 'array',
        'attachments' => 'array',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return BelongsTo<Family, $this>
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return HasMany<Notes, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Notes::class);
    }
}
