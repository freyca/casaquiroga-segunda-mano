<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Enums\Tax;
use Database\Factories\SecondHandMachineFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'codigo',
    'name',
    'coste',
    'purchase_notes',
    'modelo',
    'serial_number',
    'selling_price',
    'tax',
    'work_hours',
    'description',
    'sell_status',
    'taller_reparacion',
    'fotos',
    'adjuntos',
    'brand_id',
    'responsable_compra_id',
    'cliente_compra_id',
    'family_id',
])]
class SecondHandMachine extends Model
{
    /** @use HasFactory<SecondHandMachineFactory> */
    use HasFactory;

    protected $casts = [
        'coste' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'taller_reparacion' => 'decimal:2',
        'tax' => Tax::class,
        'sell_status' => Status::class,
        'work_hours' => 'integer',
        'fotos' => 'array',
        'adjuntos' => 'array',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_compra_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_compra_id');
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
