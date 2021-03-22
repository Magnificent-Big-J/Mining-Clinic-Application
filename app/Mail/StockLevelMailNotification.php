<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockLevelMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $full_names;
    public $clinicProducts;
    public $clinic;
    public function __construct($clinicProducts, $full_names, $clinic)
    {
        $this->clinicProducts = $clinicProducts;
        $this->full_names = $full_names;
        $this->clinic = $clinic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.stock_level_notifications');
    }
}
