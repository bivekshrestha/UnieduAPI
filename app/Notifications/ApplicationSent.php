<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSent extends Notification
{
    use Queueable;

    public $student;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage();

        $message->greeting('Dear Sir/Madam')
            ->line('We are forwarding you the documents of ' . $this->student->detail->first_name . ' ' . $this->student->detail->last_name . '.')
            ->line('Please find the attachment below.');

        $documents = $this->student->documents;

        foreach ($documents as $document) {
            if($document->path){
                $message->attachFromStorage(asset('storage/' . $document->path));
            }
        }

        return $message;

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
