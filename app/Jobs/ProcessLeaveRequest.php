<?php

namespace App\Jobs;

use App\Mail\SendLeaveRequest;
use App\Mail\SendLeaveRequestToUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessLeaveRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $leaverequest;

    public function __construct($leaverequest)
    {
        $this->leaverequest = $leaverequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $leaverequest = $this->leaverequest;
        $user = $leaverequest->user;

        Mail::to('admin@leave.com')->later(10,new SendLeaveRequest($leaverequest));
        Mail::to($user->email)->later(10,new SendLeaveRequestToUser($leaverequest));
    }
}
