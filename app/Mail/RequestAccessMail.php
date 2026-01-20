<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Request Access - ' . 'MKM ' . ucfirst(str_replace('mkm_', '', config('app.name'))))
            ->view('emails.request-access', [
                'appName' => 'MKM ' . ucfirst(str_replace('mkm_', '', config('app.name'))),
                'data' => $this->data,
            ]);
    }
}
