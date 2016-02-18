<?php

/**
 * Class FHWuerzburgSchweinfurt.
 * Defines the rules, actions, action params and transformer mappings for "FH Wuerzburg-Schweinfurt".
 */
class FHWuerzburgSchweinfurt extends UniversitySeeder {

    protected $universityId = 397;
    protected $published = true;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER_REVERSED, '(^[0-9]+)\s*(\w+)', $overview=true);

        // create actions for rule
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '(//form)[1]/@action', $url='https://studentenportal.fhws.de/login');
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="navbar-collapse"]/ul[2]/li[1]/ul/li[1]/a/@href');
        $this->createActionParam($login, "username", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "password", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES, UniversitySeeder::HTTP_GET, '//div[@class="tile"]');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_OVERVIEW, UniversitySeeder::HTTP_GET, '//div[contains(@class, "panel-default")]//a[@data-exam="###'.UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID.'###"]/../../..//div[contains(@class, "panel-body")]');

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '(//table)[1]/tbody/tr/td[1]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '(//table)[1]/tbody/tr/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, 'substring-before((//table)[1]/tbody/tr/td[3]/text(), " ")');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '(//table)[1]/tbody/tr/td[4]/span/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_SEMESTER, '//a/@data-time');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, "//div[contains(@class, 'panel-default')]");
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_POSSIBLE, 'boolean(//div[contains(@class, "panel-body")]//table[contains(@class, "grades_grid")])');

        // overview mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_1, '//table[contains(@class, "grades_grid")]/tbody//td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_1, '//table[contains(@class, "grades_grid")]/tbody//td[3]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_2, '//table[contains(@class, "grades_grid")]/tbody//td[4]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_2, '//table[contains(@class, "grades_grid")]/tbody//td[5]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_2, '//table[contains(@class, "grades_grid")]/tbody//td[6]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_3, '//table[contains(@class, "grades_grid")]/tbody//td[7]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_3, '//table[contains(@class, "grades_grid")]/tbody//td[8]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_3, '//table[contains(@class, "grades_grid")]/tbody//td[9]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_4, '//table[contains(@class, "grades_grid")]/tbody//td[10]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_4, '//table[contains(@class, "grades_grid")]/tbody//td[11]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_5, '//table[contains(@class, "grades_grid")]/tbody//td[12]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_PARTICIPANTS, '/div/ul/li[1]/strong/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_AVERAGE, '/div/ul/li[4]/strong/text()');
    }
}