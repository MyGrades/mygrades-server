<?php

namespace App\Console;

use App\Error;
use App\Wish;
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
        \App\Console\Commands\PublishUniversity::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        /*
         * Let us know if there is something new :)
         */
        // check if there is a new error
        $schedule->call(function () {
            // get new errors
            $new_errors = Error::cronUnseen()->get();

            if (!$new_errors->isEmpty()) {
                Mail::send('emails.errors', ['errors' => $new_errors], function ($message) {
                    $message->from('notification@mygrades.de', 'Notification | MyGrades');
                    $message->to("hallo@mygrades.de", $name = null);
                    $message->subject("New errors reported");
                });

                // mark them as seen
                DB::table('errors')
                    ->whereNull('cron_seen')
                    ->update(['cron_seen' => Carbon::now()]);
            }
        })->hourly();

        // check if there is a new wish
        $schedule->call(function () {
            // get new errors
            $new_wishes = Wish::cronUnseen()->get();

            if (!$new_wishes->isEmpty()) {

                Mail::send('emails.wishes', ['wishes' => $new_wishes], function ($message) {
                    $message->from('notification@mygrades.de', 'Notification | MyGrades');
                    $message->to("hallo@mygrades.de", $name = null);
                    $message->subject("New wishes");
                });

                // mark them as seen
                DB::table('wishes')
                    ->whereNull('cron_seen')
                    ->update(['cron_seen' => Carbon::now()]);
            }
        })->hourly();
    }
}
