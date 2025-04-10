<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemporaryEmailController;

Route::get('/generate', [TemporaryEmailController::class, 'generate']);


Route::get('/', function () {
    return view('welcome');
});
