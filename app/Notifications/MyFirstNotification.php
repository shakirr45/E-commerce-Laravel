<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MyFirstNotification extends Notification
{
    //for sending email prive $details ================>>
    use Queueable;
    private $details;

    /**
     * Create a new notification instance.
     */
    //for sending email  public function __construct($details) inside $this->$details=$details; ================>>

    public function __construct($details)
    {
        //
        $this->details=$details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
    //for sending email add lines ================>>

        return (new MailMessage)
                    ->greeting($this->details['greeting'])
                    ->line($this->details['firstline'])
                    ->line($this->details['body'])
                    ->action($this->details['button'], $this->details['url'])
                    ->line($this->details['lastline']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
