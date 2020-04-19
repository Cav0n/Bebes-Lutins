<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Test extends Mailable
{
    use Queueable, SerializesModels;

    public $headerImage = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->headerImage['url'] = 'images/utils/emails/email-header.jpg';
        $this->headerImage['alt'] = 'Un peu de fraicheur chez Bébés Lutins';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.tests.test', ['headerImage' => $this->headerImage]);
    }
}
