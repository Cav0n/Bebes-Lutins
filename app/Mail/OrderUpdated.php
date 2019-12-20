<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $title;
    public $infos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, string $title, string $infos)
    {
        $this->order = $order;
        $this->title = $title;
        $this->infos = $infos;
        $this->subject('Votre commande #' . $order->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.order-updated');
    }
}
