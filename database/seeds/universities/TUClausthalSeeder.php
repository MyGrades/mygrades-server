<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class TUClausthalSeeder extends Seeder {
    /**
     * Run the RuleSeeder.
     */
    public function run()
    {
        // create Rule bachelor
        $general = new Rule([
            'name' => 'Allgemein',
            'semester_format' => 'date',
            'semester_pattern' => '\d{2}\.(\d{2})\.(\d{4})',
            'semester_start_summer' => 4,
            'semester_start_winter' => 10,
            'grade_factor' => 0.01,
            'overview' => false
        ]);

        $clausthal = University::find(89);
        $clausthal->published = true;
        $clausthal->save();

        // create Rule for HSRM
        $clausthal->rules()->saveMany([
            $general
        ]);


        $login = new Action([
            'position' => 1,
            'type' => 'normal',
            'method' => 'POST',
            'parse_expression' => '//*[@id="navbox"]/dl/dd[2]/a/@href'
        ]);

        // add actions
        $general->actions()->saveMany([
            new Action([
                'position' => 0,
                'type' => 'normal',
                'method' => 'GET',
                'url' => 'https://www.studierenplus.tu-clausthal.de/service/online-pruefungsanmeldung/login/',
                'parse_expression' => '//*[@id="inhalt"]/div[2]/form/@action'
            ]),
            $login,
            new Action([
                'position' => 2,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="inhalt"]/div[3]/form/div/ul/li[3]/a/@href'
            ]),
            new Action([
                'position' => 3,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="inhalt"]/form/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'type' => 'table_grades',
                'method' => 'GET',
                'parse_expression' => '//*[@id="inhalt"]/form/table[2]'
            ])
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
                'name' => 'state',
                'parse_expression' => '//td[3]'
            ]),
            new TransformerMapping([
                'name' => 'annotation',
                'parse_expression' => '//td[4]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[6]'
            ]),
            new TransformerMapping([
                'name' => 'semester',
                'parse_expression' => '//td[7]'
            ]),
            new TransformerMapping([
                'name' => 'grade',
                'parse_expression' => '//td[8]'
            ]),
            new TransformerMapping([
                'name' => 'credit_points',
                'parse_expression' => '//td[9]'
            ]),
            new TransformerMapping([
                'name' => 'exam_date',
                'parse_expression' => '//td[7]'
            ]),

            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[./td[not(starts-with(@class, 'qis_konto'))]]"
            ])
        ]);
    }
}