<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class FHDarmstadt extends Seeder {
    /**
     * Run the RuleSeeder.
     */
    public function run()
    {
        // create Rule bachelor
        $general = new Rule([
            'name' => 'Allgemein',
            'semester_format' => 'semester',
            'semester_pattern' => '(^\w+)\s*([0-9]+)',
            'grade_factor' => 1,
            'overview' => true
        ]);

        $hsrm = University::find(94);
        $hsrm->published = true;
        $hsrm->save();

        // create Rule for HSRM
        $hsrm->rules()->saveMany([
            $general
        ]);


        $login = new Action([
            'position' => 1,
            'type' => 'normal',
            'method' => 'POST',
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[6]/a/@href'
        ]);

        // add actions
        $general->actions()->saveMany([
            new Action([
                'position' => 0,
                'type' => 'normal',
                'method' => 'GET',
                'url' => 'https://qis.h-da.de/qisserver/rds?state=user&type=0&application=lsf',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/div/form/@action'
            ]),
            $login,
            new Action([
                'position' => 2,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 3,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'type' => 'table_grades',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]'
            ]),

            new Action([
                'position' => 5,
                'type' => 'table_overview',
                'method' => 'GET',
                'parse_expression' => "//*[@id='wrapper']/div[6]/div[2]/form/table[2]//tr[./td[contains(text(), '###exam_id###')] and ./td[./a]]/td/a/@href"
            ]),
            new Action([
                'position' => 6,
                'type' => 'table_overview',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[4]'
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
                'name' => 'tester',
                'parse_expression' => '//td[5]'
            ]),
            new TransformerMapping([
                'name' => 'state',
                'parse_expression' => '//td[7]'
            ]),
            new TransformerMapping([
                'name' => 'credit_points',
                'parse_expression' => '//td[8]'
            ]),
            new TransformerMapping([
                'name' => 'annotation',
                'parse_expression' => '//td[9]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[10]'
            ]),
            new TransformerMapping([
                'name' => 'exam_date',
                'parse_expression' => '//td[11]'
            ]),
            new TransformerMapping([
                'name' => 'overview_possible',
                'parse_expression' => 'boolean(//a)'
            ]),
            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[./td[starts-with(@class, 'tabelle1_')] and not(./td[contains(text(), '. Semester')])]"
            ]),

            // Transformer overview
            new TransformerMapping([
                'name' => 'overview_section1',
                'parse_expression' => "//tr[4]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section2',
                'parse_expression' => "//tr[5]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section2',
                'parse_expression' => "//tr[6]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section3',
                'parse_expression' => "//tr[7]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section3',
                'parse_expression' => "//tr[8]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section3',
                'parse_expression' => "//tr[9]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section4',
                'parse_expression' => "//tr[10]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section5',
                'parse_expression' => "//tr[11]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_participants',
                'parse_expression' => "//tr[12]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_average',
                'parse_expression' => "//tr[13]/td[2]/text()"
            ]),
        ]);
    }
}