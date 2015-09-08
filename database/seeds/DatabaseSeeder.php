<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\University;
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
    }
}

class RuleSeeder extends Seeder {
    /**
     * Run the RuleSeeder.
     */
    public function run()
    {
        /*
        $login = Action::create([
            'position' => 1,
            'method' => 'POST',
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[2]/a/@href',
            'parse_type' => 'XPATH'
        ]);
        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'asdf']),
            new ActionParam(['key' => 'fdsa'])
        ]);

        // create Rule bachelor
        $bachelor = Rule::create(['type' => 'bachelor']);
        // add actions
        $bachelor->actions()->saveMany([
            new Action([
                'position' => 0,
                'method' => 'GET',
                'url' => 'https://qis.hs-rm.de/',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/div/form/@action',
                'parse_type' => 'XPATH'
            ]),
            $login

        ]);
        */
        $hsrm = University::find(333);
        $hsrm->rules()->saveMany([
            new Rule(['type' => 'bachelor']),
            new Rule(['type' => 'master']),
            new Rule(['type' => 'registeredTests'])
        ]);
    }
}