<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $cod_us;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $cod_us)
    {
        $this->user = $user;
        $this->cod_us = $cod_us;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('¡Bienvenido a ' . config('app.name') . '!')
                    ->view('emails.welcome');
    }
}