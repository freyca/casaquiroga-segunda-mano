<?php

declare(strict_types=1);

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;

final class FilamentLanguageSwitcherProvider extends ServiceProvider
{
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch->locales(['es', 'gl']);
        });
    }
}
