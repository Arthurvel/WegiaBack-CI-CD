<?php

use Illuminate\Support\Facades\Route;
use Modules\ContribuicaoSocios\Http\Controllers\ContribuicaoSociosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('contribuicaosocios', ContribuicaoSociosController::class)->names('contribuicaosocios');
});
