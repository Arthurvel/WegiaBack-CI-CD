<?php

use Illuminate\Support\Facades\Route;
use Modules\Pet\Http\Controllers\PetController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pets', PetController::class)->names('pet');
});
