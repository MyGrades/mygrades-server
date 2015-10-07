<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class HSRMSeeder extends Seeder {
    /**
     * Run the RuleSeeder.
     */
    public function run()
    {
        // create Rule bachelor
        $bachelor = new Rule([
            'type' => 'bachelor',
            'semester_format' => 'semester',
            'semester_pattern' => '(^\w+)\s*([0-9]+)',
            'grade_factor' => 1,
            'overview' => true
        ]);

        $hsrm = University::find(333);
        $hsrm->published = true;
        $hsrm->save();

        // create Rule for HSRM
        $hsrm->rules()->saveMany([
            $bachelor
        ]);


        $login = new Action([
            'position' => 1,
            'type' => 'normal',
            'method' => 'POST',
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[2]/a/@href'
        ]);

        // add actions
        $bachelor->actions()->saveMany([
            new Action([
                'position' => 0,
                'type' => 'normal',
                'method' => 'GET',
                'url' => 'https://qis.hs-rm.de/',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/div/form/@action'
            ]),
            $login,
            new Action([
                'position' => 2,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/div/form/div/ul/li[4]/a/@href'
            ]),
            new Action([
                'position' => 3,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul[1]/li/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul[1]/li/ul/li/a[1]/@href'
            ]),
            new Action([
                'position' => 5,
                'type' => 'table_grades',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]'
            ]),

            new Action([
                'position' => 6,
                'type' => 'table_overview',
                'method' => 'GET',
                'parse_expression' => "//*[@id='wrapper']/div[6]/div[2]/form/table[2]//tr[./td[contains(text(), '###exam_id###')] and ./td[./a]]/td/a/@href"
            ]),
            new Action([
                'position' => 7,
                'type' => 'table_overview',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[3]'
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
                'name' => 'annotation',
                'parse_expression' => '//td[8]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[9]'
            ]),
            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[not(./td[contains(text(), 'ECTS-Kontostand')]) and ./td[not(starts-with(@class, 'qis_konto'))]]"
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
                'name' => 'overview_section3',
                'parse_expression' => "//tr[6]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section4',
                'parse_expression' => "//tr[7]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_section5',
                'parse_expression' => "//tr[8]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_participants',
                'parse_expression' => "//tr[9]/td[2]/text()"
            ]),
            new TransformerMapping([
                'name' => 'overview_average',
                'parse_expression' => "//tr[10]/td[2]/text()"
            ]),
        ]);
    }
}