<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Competition;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
   protected function schedule(Schedule $schedule)
    {
    $schedule->call(function () {

        Competition::where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->where('deadline', '<', now())
            ->update(['status' => 'completed']);

    })->everyMinute(); // You can change to daily() if preferred
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
