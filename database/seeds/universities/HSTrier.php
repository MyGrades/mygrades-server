<?php

/**
 * Class HSTrier.
 * Defines the rules, actions, action params and transformer mappings for
 * "Hochschule Trier"
 */
class HSTrier extends UniversitySeeder {

    protected $universityId = 366;
    protected $published = true;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)', $overview=false);

        // create actions for rule
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//form[@name="login"]/@action', $url="https://qis.hochschule-trier.de/qisserver/rds?state=user&type=0");

        // login 1 shibboleth
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL.":form", UniversitySeeder::HTTP_POST, '//form');
        $this->createActionParam($login, "j_username", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "j_password", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        // "no javascript" confirmation
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '/html/body/table[3]/tbody/tr/td/form/@action');

        // login 2 qis
        $login2 = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, "//a[contains(@href,'menuid=notenspiegel')]/@href");
        $this->createActionParam($login2, "username", $type=UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login2, "password", $type=UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES, UniversitySeeder::HTTP_GET, "//table[.//td[contains(@class, 'posrecords')]]");

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_SEMESTER, '//td[3]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[4]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[6]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ANNOTATION, '//td[8]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT, '//td[9]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_DATE, '//td[11]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, "//tr[./td[starts-with(@class, 'posrecords')] and count(./td) = 11]");
    }
}