<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $requestData;
    protected $formName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestData,$formName)
    {
        $this->requestData = $requestData;
        $this->formName = $formName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('backend.form.mail.leave-request',['requestData'=>$this->requestData,'formName'=>$this->formName]);

    }
}
