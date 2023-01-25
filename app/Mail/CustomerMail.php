<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;
    public $paymentData;

    public function __construct($userData, $paymentData)
    {
        // dd($paymentData);
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
                    ->view('admin.emails.customer_invoice',['user'=>$this->userData,'paymentData'=>$this->paymentData]);
                    // ->with('user',$this->userData,'test',$this->paymentData);
    }
}
