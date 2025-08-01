<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('test-email', function () {
    try {
        Mail::raw('This is a test email from Event Scheduler API...', function ($message) {
            $message->to('webmasterjdd@gmail.com')
                ->subject('Test Email');
        });

        return 'Test email sent successfully.';
    } catch (\Exception $e) {
        return 'Failed to send test email: ' . $e->getMessage();
       
    }
});


Route::controller(AuthController::class)->middleware('throttle:5,1')->group(function () {
   
    Route::post('/register', 'register')->name('auth.register');
    Route::post('/login', 'login')->name('auth.login');
    Route::get('/verify/email', 'verifyEmail')->name('auth.email.verify');
    Route::post('/email/resend', 'resendVerificationEmail')->name('auth.email.resend');
      
    Route::post('/password/confirm', 'passwordConfirm')->name('auth.password.confirm');
    Route::post('/password/reset-request', 'sendPasswordResetEmail')->name('auth.password.reset.request');
    Route::post('/password/reset', 'resetPassword')->name('auth.password.reset');
   
    Route::get('/me', 'checkUser')->name('auth.user');
    
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'logout')->name('auth.logout');
        Route::post('/password/change', 'changePassword')->name('auth.password.change');
    });
});



Route::prefix('events')->controller(EventController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{event}', 'show');

    Route::post('/', 'store');  
    Route::post('/register', 'register');
    
    Route::delete('/{event}', 'cancel');
});