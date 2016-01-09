<?php

/**
 * Class UniWuerzburg.
 * Defines the rules, actions, action params and transformer mappings
 * for "Julius-Maximilians-Universität Würzburg".
 */
class UniWuerzburg extends UniversitySeeder {

    protected $universityId = 398;
    protected $published = true;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)');

        // create actions for rule
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]/div[6]/div[2]/div/div/form/@action', $url='https://www-sbhome1.zv.uni-wuerzburg.de/qisserver/rds?state=user&type=0');
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="makronavigation"]/ul/li[3]/a/@href');
        $this->createActionParam($login, "asdf", UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "fdsa", UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]/div[6]/div[2]/div/form/div/ul/li[4]/a/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li[last()]/a[1]/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]/div[6]/div[2]/form/ul/li[last()]/a[2]/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]/div[6]/div[2]/form/table[2]');

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_SEMESTER, '//td[6]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[3]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[4]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ANNOTATION, '//td[9]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT, '//td[8]');

        $stringsToExclude = array("Fertig", "Gesamtnote", "Schlüsselqualifikationen", "Fachnote", "Studienfachnote");
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, '//tr[not(' . $this->concat($stringsToExclude, "./td[contains(text(), '%s')]", " or ") . ') and ./td[not(starts-with(@class, "qis_konto"))] and count(./td) = 9]');
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