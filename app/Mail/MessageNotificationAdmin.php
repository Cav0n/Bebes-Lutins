<?php

namespace App\Mail;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageNotificationAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->subject('Un nouveau message depuis le site !');
        $this->contact_message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->contact_message->senderEmail)->replyTo($this->contact_message->senderEmail)->view('emails.messages.admin-notification');
    }
}
