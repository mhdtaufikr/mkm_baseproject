<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $hashPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $hashPassword)
    {
        $this->user = $user;
        $this->hashPassword = $hashPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('User Created - ' . 'MKM ' . ucfirst(str_replace('mkm_', '', config('app.name'))))
            ->view('emails.user-created', [
                'appName' => 'MKM ' . ucfirst(str_replace('mkm_', '', config('app.name'))),
                'user' => $this->user,
                'hashPassword' => $this->hashPassword,
            ]);
    }
}
