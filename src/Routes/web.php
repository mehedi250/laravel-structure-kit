<?php

use Illuminate\Support\Facades\Route;
use StructureKit\Http\Controllers\StructureKitController;

Route::middleware('web')
    ->prefix('structure-kit')
    ->group(function () {
        Route::get('/', [StructureKitController::class, 'index'])->name('structure-kit.index');
        Route::post('/generate', [StructureKitController::class, 'generate'])->name('structure-kit.generate');
    });
