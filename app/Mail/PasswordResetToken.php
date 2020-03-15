<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetToken extends Mailable
{
    /**
     * The reset token
     *
     * @var string
     */
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;

        $this->subject('Code de réinitialisation');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('cav0n@hotmail.fr')->view('mails.user.password.token');
    }
}
