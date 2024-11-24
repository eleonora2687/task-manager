<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Notifications\NotifyExpiredTask;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $expiredTasks = Task::where('due_date', '<', Carbon::now()) // Filter tasks that have expired
                                 ->where('status', '!=', 'completed') // Make sure task is not marked as completed
                                 ->get();
    
            foreach ($expiredTasks as $task) {
                $user = $task->user; // Assuming tasks are related to users
                $user->notify(new NotifyExpiredTask($task)); // Send the notification
            }
        })->daily(); // Run this task daily
    }

}
