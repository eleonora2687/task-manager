<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyTasksDue extends Notification
{
    protected $task;

    // Constructor to accept the task
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    // The email representation of the notification
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Due Notification')
            ->line('The task "' . $this->task->title . '" is due now!')
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Please complete it soon!');
    }
}
