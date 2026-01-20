<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        Commands\ResetCutiTahunan::class,
    ];

protected function schedule(Schedule $schedule)
    {
        $schedule->command('cuti:reset-tahunan')
            ->yearlyOn(1, 1, '00:01')
            ->timezone('Asia/Jakarta');
    }

protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
