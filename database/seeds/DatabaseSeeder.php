<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(HochschulkompassSeeder::class);

        // call all seeders in "database/seeds/universities"
        foreach(File::files("database/seeds/universities") as $path) {
            $filename = pathinfo($path)["filename"];

            // create and execute seeder
            $seeder = new $filename;
            if ($seeder instanceof UniversitySeeder) {
                $seeder->run();

                // log
                if (isset($this->command)) {
                    $this->command->getOutput()->writeln("<info>Published:</info> " . $filename);
                }
            }
        }

        Model::reguard();
    }
}
