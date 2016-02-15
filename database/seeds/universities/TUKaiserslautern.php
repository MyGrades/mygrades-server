<?php

/**
 * Class TUKaiserslautern.
 * Defines the rules, actions, action params and transformer mappings
 * for "Technische Universität Kaiserslautern".
 *
 * Only valid in the network of the university (e.g. VPN).
 */
class TUKaiserslautern extends UniversitySeeder {

    protected $universityId = 215;
    protected $published = true;

    public function run()
    {
        // create rule
        $rule = $this->createRule("Allgemein", UniversitySeeder::RULE_SEMESTER_FORMAT_SEMESTER, '(^\w+)\s*([0-9]+)');

        // create actions for rule
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//form[@name="loginform"]/@action', $url='https://qis.verw.uni-kl.de/qisserver/rds?state=user&type=0');
        $login = $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_POST, '//*[@id="makronavigation"]/ul/li[3]/a/@href');
        $this->createActionParam($login, "asdf", UniversitySeeder::ACTION_PARAM_TYPE_USERNAME);
        $this->createActionParam($login, "fdsa", UniversitySeeder::ACTION_PARAM_TYPE_PASSWORD);

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//div[@class="mikronavi_list"]/ul/li[3]/a/@href');
        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_NORMAL, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//ul[@class="treelist"]/li/a[2]/@href');

        $this->createAction($rule, UniversitySeeder::ACTION_TYPE_TABLE_GRADES, UniversitySeeder::HTTP_GET, '//*[@id="wrapper"]//div[@class="content"]/form/table[2]');

        // create transformer mappings
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_ID, '//td[1]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_NAME, '//td[2]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_SEMESTER, '//td[3]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_GRADE, '//td[4]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_STATE, '//td[5]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_CREDIT_POINTS, '//td[6]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ANNOTATION, '//td[8]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ATTEMPT, '//td[9]');
        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_EXAM_DATE, '//td[10]');

        $this->createTransformerMapping($rule, UniversitySeeder::TRANSFORMER_MAPPING_ITERATOR, "//tr[./td[not(starts-with(@class, 'qis_konto'))] and count(./td) = 10]");

    }
}