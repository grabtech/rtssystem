<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details,$filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$filename)
    {
        $this->details = $details;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$path = ['D:\xampp\htdocs\grabtech\storage\app\public\files\1660383428_log1.txt.txt','D:\xampp\htdocs\grabtech\storage\app\public\files\1660385820_log1.txt - Copy.txt'];
        $email = $this->subject('TechSupport -'.$this->details['ticketid'])->view('email.email',['data'=>$this->details]);
        if(count($this->filename) > 0){
            foreach($this->filename as $path){
                 $email->attach($path);
            }
        }    
        return $email;
    }
}
