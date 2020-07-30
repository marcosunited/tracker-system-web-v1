<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalloutMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public  $from_email;
    public  $subject;
    public  $message_content;
    public  $filename_file;
    public function __construct($from, $domain, $subject, $message,$filename)
    {
        //
        $this->from_email = $from;
        $this->subject = $subject;
        $this->message_content = $message;
        $this->filename_file = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->from($this->from_email)->view('emails.callout')
                    ->attach(storage_path().'/pdf/callout/'.$this->filename_file.'.pdf', [
                        'as' => $this->filename_file.'.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
