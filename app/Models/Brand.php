<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\MarcaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    /** @use HasFactory<BrandFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function secondHandMachines(): HasMany
    {
        return $this->hasMany(SecondHandMachine::class);
    }
}
