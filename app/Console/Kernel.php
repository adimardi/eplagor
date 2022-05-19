<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{

    private $options = array(

        'http' => array(

            'method' => 'GET',
            'header' => 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3IiOiJXZWJzZXJ2aWNlIE1haGthbWFoIEFndW5nIiwidWlkIjoiTUFIIiwicm9sIjoid2Vic2VydmljZSIsImtkcyI6IldTVjAyNiIsImtkYiI6IiIsImtkdCI6IjIwMjEiLCJpYXQiOjE2MjE1OTY1MTEsIm5iZiI6MTYyMTU5NTkxMSwia2lkIjoiMjc2MSJ9.gAYDnUlKSt_PsQ0dQmgmMQd_pThgptZ5rVQOt-UTdWU'

        ),

        'ssl' => array(

            'verify_peer' => false,
            'verify_peer_name' => false

        )

    );

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->everyMinute();
        // $schedule->command('cache:clear')->daily();

        
        // $schedule->command('apikeu:dataanggaran')->daily()->at("01:00")->name('simpanDataAnggaran')->withoutOverlapping();
        // $schedule->command('apikeu:dataUraianAnggaran')->daily()->at("03:00")->name('simpanDataUraianAnggaran')->withoutOverlapping();
        // $schedule->command('apikeu:dataStatusAnggaran')->daily()->at("01:30")->name('simpanDataStatusAnggaran')->withoutOverlapping();
        // $schedule->command('apikeu:dataRealisasi')->daily()->at("02:00")->name('simpanDataRelisasi')->withoutOverlapping();
        
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
