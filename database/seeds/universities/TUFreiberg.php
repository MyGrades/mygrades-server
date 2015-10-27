<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class TUFreiberg extends Seeder {
    /**
     * Run the RuleSeeder.
     */
    public function run()
    {
        // create Rule bachelor
        $bachelor = new Rule([
            'name' => 'Allgemein',
            'semester_format' => 'semester',
            'semester_pattern' => '(^\w+)\s*([0-9]+)',
            'grade_factor' => 1
        ]);

        $uni = University::find(141);
        $uni->published = true;
        $uni->save();

        // create Rule for HSRM
        $uni->rules()->saveMany([
            $bachelor
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
                'url' => 'https://sbweb2.tu-freiberg.de/',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/div[2]/form/@action'
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
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 5,
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]'
            ]),

        ]);

        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'username', "type" => "username"]),
            new ActionParam(['key' => 'password', "type" => "password"])
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
                'parse_expression' => '//td[4]'
            ]),
            new TransformerMapping([
                'name' => 'state',
                'parse_expression' => '//td[5]'
            ]),
            new TransformerMapping([
                'name' => 'credit_points',
                'parse_expression' => '//td[6]'
            ]),
            new TransformerMapping([
                'name' => 'annotation',
                'parse_expression' => '//td[7]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[8]'
            ]),
            new TransformerMapping([
                'name' => 'exam_date',
                'parse_expression' => '//td[9]'
            ]),

            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[./td[not(starts-with(@class, 'qis_konto'))]]"
            ])
        ]);
    }
}