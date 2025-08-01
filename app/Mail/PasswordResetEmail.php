<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    public function __construct($user)
    {
        $this->user = $user;
        
        $this->url = config('app.frontend_url') . '/password-reset-form?token=' . $user->password_reset_token;
    }

    public function build()
    {
        return $this->subject('Reset Your Password')
                    ->view('emails.password-reset-email')
                    ->with([
                        'user' => $this->user,
                        'url' => $this->url,
                    ]);
    }
}
