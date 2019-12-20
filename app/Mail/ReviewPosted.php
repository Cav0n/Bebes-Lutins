<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Review $review)
    {
        $this->subject('Merci pour votre commentaire !');
        $this->title = 'Merci 💚';

        $this->review = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reviews.review-posted');
    }
}
