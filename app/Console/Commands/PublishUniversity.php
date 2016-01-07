<?php

namespace App\Console\Commands;

use App\University;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class PublishUniversity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:publish
                        {class : name of the class and file of the university}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish an university from the "database/seeds/universities" folder.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Model::unguard();

        $universityClass = $this->argument('class');

        // create and execute seeder
        $seeder = new $universityClass;
        //$this->clearUniversity($seeder->getUniversity());
        $seeder->run();

        // log
        $this->line("<info>Published:</info> " . $universityClass);

        Model::reguard();
    }

    private function clearUniversity(University $university) {
        // get all rules of university and delete them
        // -> cascades down to actions, actions_params and transformer_mappings
        $collection = $university->rules;
        $collection->each(function($item, $key) {
           $item->delete();
        });
    }
}
