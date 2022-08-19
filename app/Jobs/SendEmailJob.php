<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\NotifyMail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details,$attachments;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$attachments)
    {
        $this->details = $details;
        $this->attachments=$attachments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('bharatjogi.07@gmail.com')->cc(['testgrab77@gmail.com'])->send(new NotifyMail($this->details,$this->attachments));
        //Mail::to('bharatjogi.07@gmail.com')->send(new NotifyMail($this->details,$this->attachments));
    }
}
