<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestRejected extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data,$userdetail,$leaverequest;

    public function __construct($data, $userdetail,$leaverequest)
    {
        $this->data = $data;
        $this->userdetail = $userdetail;
        $this->leaverequest = $leaverequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $userdetail = $this->userdetail;
        $leaverequest = $this->leaverequest;
        return $this->from($userdetail->email, $userdetail->name)->view('mail.rejectedleaverequest',compact('data','userdetail','leaverequest'));
    }
}
