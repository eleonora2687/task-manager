<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class NotifyExpiredTask extends Notification
{
    protected $task;

    // Constructor to accept task data
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    // Email Notification
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Expired Notification')
            ->line('The task "' . $this->task->title . '" has expired.')
            ->line('Due Date: ' . $this->task->due_date->toFormattedDateString())
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Please complete it as soon as possible.');
    }
}
