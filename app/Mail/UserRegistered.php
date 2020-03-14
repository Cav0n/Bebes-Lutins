<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserRegistered extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->subject('Votre compte Bébés Lutins');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('cav0n@hotmail.fr')->view('mails.user.registered');
    }
}
