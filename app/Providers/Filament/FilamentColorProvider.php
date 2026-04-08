<?php

namespace App\Providers\Filament;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class FilamentColorProvider extends ServiceProvider
{
    public function boot(): void
    {
        FilamentColor::register([
            'gray' => //'#505759',
            [
                50 => '#edf1f3',
                100 => '#dfe7e9',
                200 => '#bfcfd3',
                300 => '#a8b6ba',
                400 => '#919da1',
                500 => '#7b8588',
                600 => '#666e71',
                700 => '#505759',
                800 => '#353a3b',
                900 => '#1d2021',
                950 => '#111414',
            ],
            'primary' => [
                50 => '#fef5eb',
                100 => '#feebd6',
                200 => '#fddaae',
                300 => '#fcc66e',
                400 => '#f1b434',
                500 => '#c59329',
                600 => '#9b731e',
                700 => '#765714',
                800 => '#503a0a',
                900 => '#2d1f03',
                950 => '#1c1201',
            ],
            'info' => Color::Blue,
            'danger' => Color::Red,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }
}
