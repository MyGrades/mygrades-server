<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
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
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[2]/a/@href'
        ]);

        // add actions
        $bachelor->actions()->saveMany([
            new Action([
                'position' => 0,
                'method' => 'GET',
                'url' => 'https://qis.hs-rm.de/',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/div/form/@action'
            ]),
            $login,
            new Action([
                'position' => 2,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/form/div/ul/li[4]/a/@href'
            ]),
            new Action([
                'position' => 3,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul[1]/li/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul[1]/li/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 5,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]'
            ]),

        ]);

        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'asdf', "type" => "username"]),
            new ActionParam(['key' => 'fdsa', "type" => "password"])
        ]);


        $bachelor->transformerMappings()->saveMany([
            new TransformerMapping([
                'name' => 'exam_id',
                'parse_expression' => '//td[1]'
            ]),
            new TransformerMapping([
                'name' => 'name',
                'parse_expression' => '//td[2]'
            ]),
            new TransformerMapping([
                'name' => 'semester',
                'parse_expression' => '//td[3]'
            ]),
            new TransformerMapping([
                'name' => 'grade',
                'parse_expression' => '//td[5]'
            ]),
            new TransformerMapping([
                'name' => 'state',
                'parse_expression' => '//td[6]'
            ]),
            new TransformerMapping([
                'name' => 'credit_points',
                'parse_expression' => '//td[7]'
            ]),
            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[./td[not(starts-with(@class, 'qis_konto'))]]"
            ])
        ]);



    }
}