<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationApply extends Mailable
{
    use Queueable, SerializesModels;


    public $student;

    /**
     * Create a new message instance.
     *
     * @param $student
     */
    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('emails.application.apply');

        $documents = $this->student->documents;

        foreach ($documents as $document) {
            if ($document->path) {
                $mail->attachFromStorageDisk('public', $document->path);
            }
        }

        return $mail;

    }
}
