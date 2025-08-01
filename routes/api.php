<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::prefix('events')->controller(EventController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{event}', 'show');

    Route::post('/', 'store');  
    Route::post('/register', 'register');
    
    Route::delete('/{event}', 'cancel');
});