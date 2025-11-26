<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\BackupDatabase::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Backup harian setiap jam 2 pagi
        $schedule->command('backup:database')
                 ->daily()
                 ->at('02:00')
                 ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}