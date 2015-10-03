<?php

use Carbon\Carbon;
use Flynsarmy\CsvSeeder\CsvSeeder;

class HochschulkompassSeeder extends CsvSeeder
{
    /**
     * Configure the csv seeder.
     */
    public function __construct()
    {
        $this->table = 'universities';
        $this->filename = base_path().'/database/seeds/hochschulkompass-alle-hochschulen.tsv';
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

        DB::table('universities')->update([
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }
}
