<?php

use Illuminate\Support\Facades\Route;
use Modules\Material\app\Http\Controllers\OrigemController;

Route::prefix('material')->group(function () {

});

Route::prefix('origem')->group(function () {
    Route::get('/todos', [OrigemController::class, 'todos']);
    Route::post('/', [OrigemController::class, 'cadastrar']);
});



