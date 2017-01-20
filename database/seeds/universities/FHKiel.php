<?php

/**
 * Class FHKiel.
 * Defines the rules, actions, action params and transformer mappings for "Fachhochschule Kiel".
 */
class FHKiel extends UniversitySeeder {

    protected $universityId = 226;
    protected $published = true;

    public function run()
    {
        // Create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)');

        // Open login page & parse login action
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//form[@name="loginform"]/@action', $url='https://qis.fh-kiel.de/qisserver/rds?state=user&type=0');

        // Post user credentials & parse URL to exam administration page
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="makronavigation"]/ul/li[3]/a/@href');
        $this->createActionParam($login, "username", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "password", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        // Open exam administration & parse URL to exams extract
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//div[@class = "mikronavi_list"]//li[5]/a/@href');

        // Select degree & parse URL to actual exams extract
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//form/ul/li/a[3]/@href');

        // Open actual exams extract & parse table containing grade data
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES, UniversitySeeder::HTTP_GET, '//form/table[2]');

        // Determine position of link to a given exam's overview
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_OVERVIEW, UniversitySeeder::HTTP_GET, '//tr[./td[contains(text(), "###'.UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID.'###")] and ./td[./a] and contains(./td[5]/text(), "###'.UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT.'###")]/td/a/@href');

        // Open exam overview & parse table
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_OVERVIEW, UniversitySeeder::HTTP_GET, '//form/table[3]');

        // Transformer mappings for exams extract
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_SEMESTER, '//td[7]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_DATE, '//td[8]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[9]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[11]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[12]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, '//tr[./td[not(starts-with(@class, "qis_konto"))] and count(./td) = 13]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_POSSIBLE, 'boolean(//td[9]/a)');

        // Transformer mappings for exam overview
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_1, '//tr[4]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_2, '//tr[5]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_3, '//tr[6]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_4, '//tr[7]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_SECTION_5, '//tr[8]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_PARTICIPANTS, '//tr[9]/td[2]/text()');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_OVERVIEW_AVERAGE, '//tr[10]/td[1]/text()');
    }
}