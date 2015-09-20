<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\University;
use Carbon\Carbon;
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
        $this->call(RuleSeeder::class);

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

        DB::table('universities')->update([
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);
    }
}

class RuleSeeder extends Seeder {
    /**
     * Run the RuleSeeder.
     */
    public function run()
    {
        // create Rule bachelor
        $bachelor = new Rule([
                'type' => 'bachelor'
        ]);

        $hsrm = University::find(333);
        $hsrm->published = true;
        $hsrm->save();

        // create Rule for HSRM
        $hsrm->rules()->saveMany([
            $bachelor,
            new Rule(['type' => 'master'])
        ]);


        $login = new Action([
            'position' => 1,
            'method' => 'POST',
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[2]/a/@href',
            'parse_type' => 'XPATH'
        ]);

        // add actions
        $bachelor->actions()->saveMany([
            new Action([
                'position' => 0,
                'method' => 'GET',
                'url' => 'https://qis.hs-rm.de/',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/div/form/@action',
                'parse_type' => 'XPATH'
            ]),
            $login,
            new Action([
                'position' => 2,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/form/div/ul/li[4]/a/@href',
                'parse_type' => 'XPATH'
            ]),
            new Action([
                'position' => 3,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul[1]/li/a[1]/@href',
                'parse_type' => 'XPATH'
            ]),
            new Action([
                'position' => 4,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul[1]/li/ul/li/a[1]/@href',
                'parse_type' => 'XPATH'
            ]),
            new Action([
                'position' => 5,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]/tbody/tr[contains(., "1120")]/td[5]',
                'parse_type' => 'XPATH'
            ]),

        ]);

        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'asdf', "type" => "username"]),
            new ActionParam(['key' => 'fdsa', "type" => "password"])
        ]);






    }
}