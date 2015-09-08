<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Flynsarmy\CsvSeeder\CsvSeeder;

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

        Model::reguard();
    }
}

class HochschulkompassSeeder extends CsvSeeder
{
    /**
     * Configure the csv seeder.
     */
    public function __construct()
    {
        $this->table = 'universities';
        $this->filename = base_path().'/database/seeds/hochschulkompass-alle-hochschulen.tsv'; // TODO: update path?
        $this->csv_delimiter = "\t";
        $this->offset_rows = 1;
        $this->mapping = [
            1 => "short_name",
            2 => "name",
            4 => "sponsorship",
            5 => "state",
            6 => "student_count",
            7 => "year_established",
            10 => "street",
            11 => "plz",
            12 => "city",
            19 => "website"
        ];
    }

    /**
     * Run the hochschulkompass seeder.
     */
    public function run()
    {
        parent::run();
    }
}