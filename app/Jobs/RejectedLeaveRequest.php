<?php

namespace App\Jobs;

use App\Mail\LeaveRequestRejected;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RejectedLeaveRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $data = $this->data;
        $userdetail = $this->userdetail;
        $leaverequest = $this->leaverequest;

        Mail::to($userdetail->email)->later(10, new LeaveRequestRejected($data = null, $userdetail,$leaverequest));

    }
}
