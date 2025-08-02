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
   
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::get('/verify/email', 'verifyEmail')->name('email.verify');
    Route::post('/email/resend', 'resendVerificationEmail')->name('email.resend');
      
    Route::post('/password/confirm', 'passwordConfirm')->name('password.confirm');
    Route::post('/password/reset-request', 'sendPasswordResetEmail')->name('password.reset.request');
    Route::post('/password/reset', 'resetPassword')->name('password.reset');
   
    Route::get('/me', 'checkUser')->name('user');
    
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/password/change', 'changePassword')->name('password.change');
    });
});



Route::prefix('events')->controller(EventController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{event}', 'show');

   
    Route::post('/register', 'register');
    
   

    Route::middleware('manager')->group(function(){
         Route::post('/', 'store');  
         Route::delete('/delete/{event}', 'cancel');
    });
});