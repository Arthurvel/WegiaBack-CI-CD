<?php

use Illuminate\Support\Facades\Route;
use Modules\Memorando\Http\Controllers\MemorandoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('memorandos', MemorandoController::class)->names('memorando');
});
