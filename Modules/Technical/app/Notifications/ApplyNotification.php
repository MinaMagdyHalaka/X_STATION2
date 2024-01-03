<?php

namespace Modules\Technical\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplyNotification extends Notification
{
    use Queueable;
    public array $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['broadcast','database'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => $this->message
        ]);
    }

    public function toDatabase($notifiable): array
    {
        return $this->message;
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
