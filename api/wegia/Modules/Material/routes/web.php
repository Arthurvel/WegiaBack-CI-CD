<?php

use Illuminate\Support\Facades\Route;
use Modules\Material\Http\Controllers\MaterialController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('materials', MaterialController::class)->names('material');
});
