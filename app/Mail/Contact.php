<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class Contact extends Mailable
{
    /**
     * The firstname
     *
     * @var string
     */
    public $firstname;

    /**
     * The lastname
     *
     * @var string
     */
    public $lastname;

    /**
     * The email
     *
     * @var string
     */
    public $email;

    /**
     * The message
     *
     * @var string
     */
    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $firstname, string $lastname, string $email, string $message)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->text = nl2br($message);

        $this->subject('Nouveau message !');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('florian@coinks.fr')->view('mails.contact.message');
    }
}
