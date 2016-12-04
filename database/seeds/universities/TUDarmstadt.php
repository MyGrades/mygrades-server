<?php

/**
 * Class TUDarmstadt.
 * Defines the rules, actions, action params and transformer mappings for
 * "Technische Universität Darmstadt"
 */
class TUDarmstadt extends UniversitySeeder {

    protected $universityId = 95;
    protected $published = true;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)', $overview=false, $semesterStartSummer=NULL, $semesterStartWinter=NULL, $gradeFactor=1.0, $type=UniversitySeeder::RULE_TYPE_MULTIPLE_TABLES);

        // create actions for rule
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL.':form', UniversitySeeder::HTTP_GET, '//*[@id="cn_loginForm"]', $url='https://www.tucan.tu-darmstadt.de');
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="link000324"]/a/@href');
        $this->createActionParam($login, "usrname", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "pass", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES_ITERATOR.':form', UniversitySeeder::HTTP_GET, '//*[@id="contentSpacer_IE"]/div/table');

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[3]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[4]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, '//tr[./td[starts-with(@class, "tbdata")] and count(./td) = 7]');

        $this->createTransformerMapping($rule, UniversitySeeder::MT_SEMESTER_OPTIONS, '//*[@id="semester"]//option/@value');
        $this->createTransformerMapping($rule, UniversitySeeder::MT_SEMESTER_STRING, '//*[@id="semester"]/option[@selected]');
        $this->createTransformerMapping($rule, UniversitySeeder::MT_FORM_URL, '//*[@id="semesterchange"]/@action');
    }
}