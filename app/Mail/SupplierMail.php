<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;
    public $paymentData;
    public function __construct($userData, $paymentData)
    {
        $this->userData    = $userData;
        $this->paymentData = $paymentData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('OBS Accounting')
                    ->view('admin.emails.supplier_invoice',['user'=>$this->userData,'paymentData'=>$this->paymentData]);
    }
}
