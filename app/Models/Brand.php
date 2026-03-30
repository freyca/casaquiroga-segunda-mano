<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nombre'])]
class Brand extends Model
{
    /** @use HasFactory<BrandFactory> */
    use HasFactory;

    /**
     * @return HasMany<SecondHandMachine, $this>
     */
    public function secondHandMachines(): HasMany
    {
        return $this->hasMany(SecondHandMachine::class);
    }
}
