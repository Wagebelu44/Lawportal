<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject($this->data['subject'])->cc($this->data['cc_arr'])->bcc($this->data['bcc_arr'])->view('email_templates.dynamic_email_template')->with('data', $this->data);
        if (count($this->data['attach_arr'])) {
            foreach ($this->data['attach_arr'] as $attach) {
                $email->attach($attach['path'], [
                    'as' => $attach['as'],
                    'mime' => $attach['mime'],
                ]);
            }
        }
        
        return $email;
    }
}
