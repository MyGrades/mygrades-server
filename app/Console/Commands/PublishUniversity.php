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
                        {class : name of the class and file of the university}
                        {--c|create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish an university from the "database/seeds/universities" folder.';

    /**
     * Create a new command instance.
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

        // retrieve command input
        $universityClass = $this->argument('class');
        $isCreateMode = $this->option('create');

        // create seeder object
        $seeder = new $universityClass;

        // if command gets called in update mode (without action "create") -> prompt for rule ids
        if (!$isCreateMode) {
            // show the university with all rules to the user
            $university = $seeder->getUniversity();
            $this->line("Rules of: " . $university->name . ", ID=" . $university->university_id);
            $this->table(array_keys($university->rules->toArray()[0]), $university->rules->toArray());

            $rules = [];
            // prompt for rule ids of university
            do {
                $rule_id = $this->ask('Enter the rule id of ' . $universityClass . ". \nIf there are multiple: Enter one by one in order of appearance in seeder. \nTo finish enter '-1'.");
                $rule_id = intval($rule_id);
                if ($rule_id !== -1) {
                    $rules[] = $rule_id;
                }
            } while ($rule_id !== -1);

            // check if at least 1 rule id was retrieved
            if (empty($rules)) {
                $this->error("What's wrong with you? You have to add at least 1 valid rule id! Try again!");
                return;
            }

            $seeder->setRules($rules);
        }

        // run the seeder
        $seeder->run();

        // log
        if ($isCreateMode) {
            $infoString = "Created";
        } else {
            $infoString = "Updated";
        }
        $this->line("<info>$infoString:</info> " . $universityClass);

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
