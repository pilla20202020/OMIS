<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendLeaveRequestToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $leaverequest;

    public function __construct($leaverequest)
    {
        $this->leaverequest = $leaverequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->leaverequest->user;

        return $this->from("noreply@leave.net", "Leave Request")->to($user->email)->view('mail.sendleaverequest',['user' => $user, 'leaverequest' => $this->leaverequest]);
    }
}
