<?php

/**
 * Class HSGeisenheim.
 * Defines the rules, actions, action params and transformer mappings for
 * "Hochschule Geisenheim"
 */
class HSGeisenheim extends UniversitySeeder {

    protected $universityId = 154;
    protected $published = true;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)', $overview=true);

        // create actions for rule
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//form[@name="loginform"]/@action', $url='https://qis.hs-geisenheim.de/hsg/rds?state=user&type=0');
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="makronavigation"]/ul/li[2]/a/@href');
        $this->createActionParam($login, "asdf", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "fdsa", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//div[@class="mikronavi_list"]/ul/li[4]/a/@href');

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//ul[@class="treelist"]/li/a[1]/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//ul[@class="treelist"]/li/ul/li[1]/a[1]/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//div[@class="content"]/form/table[2]');

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_OVERVIEW, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//div[@class="content"]/form/table[2]//tr[./td[contains(text(), "###'.UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID.'###")] and ./td[./a] and contains(./td[9]/text(), "###'.UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT.'###")]/td/a/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_OVERVIEW, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//div[@class="content"]/form/table[3]');

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_SEMESTER, '//td[3]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[6]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[7]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ANNOTATION, '//td[8]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT, '//td[9]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_POSSIBLE, 'boolean(//a)');

        $stringsToExclude = array("ECTS", "Durchschnittsnote", "Deutschlandstipendium");
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, '//tr[not(' . $this->concatStringArray($stringsToExclude, "./td[contains(text(), '%s')]", " or ") . ') and ./td[not(starts-with(@class, "qis_konto"))] and count(./td) = 9]');

        // transformer overview
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_1, '//tr[4]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_2, '//tr[5]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_3, '//tr[6]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_4, '//tr[7]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_5, '//tr[8]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_PARTICIPANTS, '//tr[9]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_AVERAGE, '//tr[10]/td[2]/text()');
    }
}