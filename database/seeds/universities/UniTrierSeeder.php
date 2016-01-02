<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class UniTrierSeeder extends Seeder {
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
            'overview' => false
        ]);

        $university = University::find(368);
        $university->published = true;
        $university->save();

        // create Rule for university
        $university->rules()->saveMany([
            $general
        ]);


        $login = new Action([
            'position' => 1,
            'type' => 'normal',
            'method' => 'POST',
            'parse_expression' => '//*[@id="navitem_2"]/li[4]/a/@href'
        ]);

        $expandAll = new Action([
            'position' => 3,
            'type' => 'table_grades',
            'method' => 'POST',
            'parse_expression' => '//*[@id="examsReadonly:overviewAsTreeReadonly:tree:ExamOverviewForPersonTree"]/table/tbody/tr/td/div/table'
        ]);

        // add actions
        $general->actions()->saveMany([
            new Action([
                'position' => 0,
                'type' => 'normal:form',
                'method' => 'GET',
                'url' => 'https://porta-system.uni-trier.de/qisserver/pages/cs/sys/portal/hisinoneStartPage.faces?chco=y',
                'parse_expression' => '//*[@id="loginForm"]'
            ]),
            $login,
            new Action([
                'position' => 2,
                'method' => 'GET',
                'type' => 'normal:form',
                'parse_expression' => '//*[@id="examsReadonly"]'
            ]),
            $expandAll
        ]);

        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'asdf', "type" => "username"]),
            new ActionParam(['key' => 'fdsa', "type" => "password"]),
            new ActionParam(['key' => "submit", "value" => "Anmelden"])
        ]);

           $expandAll->actionParams()->saveMany([
            new ActionParam(['key' => 'examsReadonly:overviewAsTreeReadonly:tree:expandAll2', "value" => "Alle aufklappen"]),

        ]);


        $general->transformerMappings()->saveMany([
            new TransformerMapping([
                'name' => 'name',
                'parse_expression' => '//td[7]'
            ]),
            new TransformerMapping([
                'name' => 'exam_id',
                'parse_expression' => '//td[9]'
            ]),
            new TransformerMapping([
                'name' => 'semester',
                'parse_expression' => '//td[10]'
            ]),
            new TransformerMapping([
                'name' => 'tester',
                'parse_expression' => '//td[11]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[12]'
            ]),
            new TransformerMapping([
                'name' => 'grade',
                'parse_expression' => '//td[14]'
            ]),
            new TransformerMapping([
                'name' => 'credit_points',
                'parse_expression' => '//td[15]'
            ]),
            new TransformerMapping([
                'name' => 'state',
                'parse_expression' => '//td[17]'
            ]),
            new TransformerMapping([
                'name' => 'annotation',
                'parse_expression' => '//td[18]'
            ]),
            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => '//tr[starts-with(@class, "treeTableCellLevel5")]'
            ])
        ]);
    }
}