<?php

use App\Action;
use App\ActionParam;
use App\Rule;
use App\TransformerMapping;
use App\University;
use Illuminate\Database\Seeder;

class UniWuerzburg extends Seeder {
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

        $wuerzburg = University::find(398);
        $wuerzburg->published = true;
        $wuerzburg->save();

        // create Rule for HSRM
        $wuerzburg->rules()->saveMany([
            $general
        ]);


        $login = new Action([
            'position' => 1,
            'type' => 'normal',
            'method' => 'POST',
            'parse_expression' => '//*[@id="makronavigation"]/ul/li[3]/a/@href'
        ]);

        // add actions
        $general->actions()->saveMany([
            new Action([
                'position' => 0,
                'type' => 'normal',
                'method' => 'GET',
                'url' => 'https://www-sbhome1.zv.uni-wuerzburg.de/qisserver/rds?state=user&type=0',
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
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li[last()]/a[1]/@href'
            ]),
            new Action([
                'position' => 4,
                'type' => 'normal',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li[last()]/a[2]/@href'
            ]),
            new Action([
                'position' => 5,
                'type' => 'table_grades',
                'method' => 'GET',
                'parse_expression' => '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]'
            ])
        ]);

        $login->actionParams()->saveMany([
            new ActionParam(['key' => 'asdf', "type" => "username"]),
            new ActionParam(['key' => 'fdsa', "type" => "password"])
        ]);

        $stringsToExclude = array("Fertig", "Gesamtnote", "Schlüsselqualifikationen", "Fachnote", "Studienfachnote");

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
                'parse_expression' => '//td[6]'
            ]),
            new TransformerMapping([
                'name' => 'grade',
                'parse_expression' => '//td[3]'
            ]),
            new TransformerMapping([
                'name' => 'state',
                'parse_expression' => '//td[5]'
            ]),
            new TransformerMapping([
                'name' => 'credit_points',
                'parse_expression' => '//td[4]'
            ]),
            new TransformerMapping([
                'name' => 'annotation',
                'parse_expression' => '//td[9]'
            ]),
            new TransformerMapping([
                'name' => 'attempt',
                'parse_expression' => '//td[8]'
            ]),
            new TransformerMapping([
                'name' => 'iterator',
                'parse_expression' => "//tr[not(" . $this->concat($stringsToExclude, "./td[contains(text(), '%s')]", " or ") . ") and ./td[not(starts-with(@class, 'qis_konto'))]]"
            ]),
        ]);
    }

    public function concat($toExclude, $placeholder, $join)
    {
        $temp = array();

        foreach ($toExclude as $s)
        {
            array_push($temp, str_replace("%s", $s, $placeholder));
        }

        return implode($join, $temp);
    }
}