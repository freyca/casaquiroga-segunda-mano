<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

arch()
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch()
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend(Model::class)
    // ->toOnlyBeUsedIn('App\Repositories')
    ->ignoring(User::class);

arch()
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

// arch()
//    ->expect('App\*\Traits')
//    ->toBeTraits();

arch()->preset()->php();
arch()->preset()->security()->ignoring('md5');
