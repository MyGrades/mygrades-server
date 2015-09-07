<?php

use App\University;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


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

        $this->call(HsrmSeeder::class);

        Model::reguard();
    }
}


class HsrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hsrm = University::create([
            "name" => "Hochschule RheinMain"
        ]);
    }
}