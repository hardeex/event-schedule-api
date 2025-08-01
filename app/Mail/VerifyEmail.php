<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    public function __construct($user)
    {
        $this->user = $user;
        $this->url = config('app.frontend_url') . '/verify-email?token=' . $user->email_verification_token;
    }

    public function build()
    {
        return $this->subject('Verify Your Email Address')
                    ->view('emails.verify-email')
                    ->with([
                        'user' => $this->user,
                        'url' => $this->url,
                    ]);
    }
}
