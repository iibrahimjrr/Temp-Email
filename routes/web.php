<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemporaryEmailController;

Route::get('/', function () 
{
    return view('home');
})->name('home');

Route::post('/generate-email', [TemporaryEmailController::class, 'generate'])->name('generate.email');
Route::get('/inbox/{email}', [TemporaryEmailController::class, 'inbox'])->name('inbox.view');

