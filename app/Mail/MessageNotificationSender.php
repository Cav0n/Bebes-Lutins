<?php

namespace App\Mail;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageNotificationSender extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_message;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->subject('Message reçu !');

        $this->title = 'Merci pour votre message.';
        $this->contact_message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("no-reply@bebes-lutins.fr")->replyTo("no-reply@bebes-lutins.fr")->view('emails.messages.sender-notification');

    }
}
