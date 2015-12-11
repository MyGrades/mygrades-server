<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       // TODO: test functionality on live system and change frequency

        // check if there is a new error
        $schedule->call(function () {
            // get new errors
            $new_errors = DB::table('errors')
                ->whereNull('cron_seen')
                ->get();
            if ($new_errors !== null && count($new_errors) > 0) {

                Mail::raw('Text to e-mail \n ' . json_encode($new_errors), function ($message) {
                    $message->to("hallo@mygrades.de", $name = null);
                    $message->subject("New errors reported");
                });

                echo json_encode($new_errors);

                // mark them as seen
                DB::table('errors')
                    ->whereNull('cron_seen')
                    ->update(['cron_seen' => Carbon::now()]);
            }
        })->everyMinute();
    }
}
