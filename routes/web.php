<?php

declare(strict_types=1);

use App\Http\Controllers\SecondHandMachinePrintController;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

Route::redirect('/', Filament::getPanel('employee')->getUrl()); // @phpstan-ignore-line
Route::redirect('/login', Filament::getPanel('employee')->getUrl())->name('login'); // @phpstan-ignore-line

Route::get('secondhandmachines/{secondhandmachine}/print', SecondHandMachinePrintController::class)
    ->name('secondhandmachines.print')
    ->middleware('auth');
