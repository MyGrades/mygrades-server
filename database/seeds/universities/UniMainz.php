<?php

/**
 * Class UniMainz.
 * Defines the rules, actions, action params and transformer mappings for
 * "Johannes Gutenberg-Universität Mainz"
 */
class UniMainz extends UniversitySeeder {

    protected $universityId = 262;
    protected $published = false;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)', $overview=false, $semesterStartSummer=NULL, $semesterStartWinter=NULL,$gradeFactor=1.0, $type=UniversitySeeder::RULE_TYPE_MULTIPLE_TABLES);

        // create actions for rule

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="cn_loginForm"]/@action', $url='http://10.0.2.2:8888/mygrades-test/unimainz/1.html');
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="link000351"]/a/@href');
        $this->createActionParam($login, "usrname", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "pass", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES_ITERATOR, UniversitySeeder::HTTP_GET, '//*[@id="contentSpacer_IE"]/div/table');

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[3]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[7]');

        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, '//tr[./td[starts-with(@class, "tbdata")] and count(./td) = 9]');

        $this->createTransformerMapping($rule, UniversitySeeder::MT_SEMESTER_OPTIONS, '//*[@id="semester"]//option/@value');
        $this->createTransformerMapping($rule, UniversitySeeder::MT_FORM_URL, '//*[@id="semesterchange"]/@action');
        $this->createTransformerMapping($rule, UniversitySeeder::MT_SEMESTER_STRING, '//*[@id="semester"]/option[@selected]');

    }
}