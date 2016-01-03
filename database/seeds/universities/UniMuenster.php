<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class UniMuenster extends Seeder {
    /**
     * Run the Seeder.
     */
    public function run()
    {
        $general = new Rule([
            'name' => 'Allgemein',
            'semester_format' => 'semester',
            'semester_pattern' => '(^\w+)\s*([0-9]+)',
            'grade_factor' => 1,
            'overview' => false
        ]);

        $uni = University::find(291);
        $uni->published = true;
        $uni->save();

        // create Rule
        $uni->rules()->saveMany([
            $general
        ]);


        $login = new Action([
            'position' => 1,
            'method' => 'POST',
            'type' => 'normal',
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[1]/a/@href'
        ]);

        // add actions
        $general->actions()->saveMany([
            new Action([
                'position' => 0,
                'method' => 'GET',
                'url' => 'https://studium.uni-muenster.de/qisserver/rds?state=user&type=0',
                'type' => 'normal',
                'parse_expression' => '//*[@id="wrapper"]/div[7]/div[2]/div/div/form/@action'
            ]),
            $login,
            new Action([
                'position' => 2,
                'method' => 'GET',
                'type' => 'normal',
                'parse_expression' => '//*[@id="wrapper"]/div[7]/div[2]/div/form/div/ul/li[3]/a/@href'
            ]),
            new Action([
                'position' => 3,
                'method' => 'GET',
                'type' => 'normal',
                'parse_expression' => '//*[@id="wrapper"]/div[7]/div[2]/form/ul[1]/li/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'method' => 'GET',
                'type' => 'normal',
                'parse_expression' => '//*[@id="wrapper"]/div[7]/div[2]/form/ul[1]/li/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 5,
                'method' => 'GET',
                'type' => 'table_grades',
                'parse_expression' => '//*[@id="wrapper"]/div[7]/div[2]/table/tbody/tr[4]/td/table'
            ]),
        ]);

        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'asdf', "type" => "username"]),
            new ActionParam(['key' => 'fdsa', "type" => "password"])
        ]);


        $general->transformerMappings()->saveMany([
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
                'name' => 'tester',
                'parse_expression' => '//td[7]'
            ]),

            new TransformerMapping([
                'name' => 'annotation',
                'parse_expression' => '//td[8]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[9]'
            ]),
            new TransformerMapping([
                'name' => 'exam_date',
                'parse_expression' => '//td[10]'
            ]),

            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[./td[starts-with(@class, 'tabelle1')] and count(./td) = 10]"
            ]),
        ]);
    }
}