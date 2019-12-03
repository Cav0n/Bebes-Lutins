<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Order $order)
    {
        $this->subject('Nouvelle commande !');
        $this->title = 'Notification de commande #' . $order->id;

        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.order-admin-notification');
    }
}
