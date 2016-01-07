<?php

use App\Action;
use App\ActionParam;
use App\TransformerMapping;
use App\University;
use App\Rule;

/**
 * Class UniversitySeeder.
 * Provides useful methods and constants regarding the creation
 * of seeders for universities.
 */
abstract class UniversitySeeder {

    /**
     * Id of the university.
     * Must be set in child class!
     * @var int
     */
    protected $universityId = 0;

    /**
     * Should the university be published?
     * @var bool
     */
    protected $published = false;

    // use
    protected $university;

    // constants
    const RULE_SEMESTER_FORMAT_SEMESTER = "semester";
    const RULE_SEMESTER_FORMAT_DATE = "date";

    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const ACTION_TYPE_NORMAL = "normal";
    const ACTION_TYPE_TABLE_GRADES = "table_grades";
    const ACTION_TYPE_TABLE_OVERVIEW = "table_overview";

    const ACTION_PARAM_TYPE_USERNAME = "username";
    const ACTION_PARAM_TYPE_PASSWORD = "password";

    const TRANSFORMER_MAPPING_EXAM_ID = "exam_id";
    const TRANSFORMER_MAPPING_NAME = "name";
    const TRANSFORMER_MAPPING_SEMESTER = "semester";
    const TRANSFORMER_MAPPING_GRADE = "grade";
    const TRANSFORMER_MAPPING_STATE = "state";
    const TRANSFORMER_MAPPING_CREDIT_POINTS = "credit_points";
    const TRANSFORMER_MAPPING_ANNOTATION = "annotation";
    const TRANSFORMER_MAPPING_ATTEMPT = "attempt";
    const TRANSFORMER_MAPPING_OVERVIEW_POSSIBLE = "overview_possible";
    const TRANSFORMER_MAPPING_TESTER = "tester";
    const TRANSFORMER_MAPPING_EXAM_DATE = "exam_date";
    const TRANSFORMER_MAPPING_ITERATOR = "iterator";
    const TRANSFORMER_MAPPING_OVERVIEW_SECTION_1 = "overview_section1";
    const TRANSFORMER_MAPPING_OVERVIEW_SECTION_2 = "overview_section2";
    const TRANSFORMER_MAPPING_OVERVIEW_SECTION_3 = "overview_section3";
    const TRANSFORMER_MAPPING_OVERVIEW_SECTION_4 = "overview_section4";
    const TRANSFORMER_MAPPING_OVERVIEW_SECTION_5 = "overview_section5";
    const TRANSFORMER_MAPPING_OVERVIEW_AVERAGE = "overview_average";
    const TRANSFORMER_MAPPING_PARTICIPANTS = "overview_participants";

    /**
     * UniversitySeeder constructor.
     * Must be called in subclass if there is a constructor defined.
     */
    public function __construct()
    {
        $this->university = University::find($this->universityId);

        $this->university->published = $this->published;
        $this->university->save();
    }

    /**
     * Creates a rule with the given attributes and adds it to the university.
     *
     * @param string
     * @param string $semesterFormat
     * @param string $semesterPattern
     * @param bool $overview
     * @param string $semesterStartSummer
     * @param string $semesterStartWinter
     * @param double $gradeFactor
     * @return Rule
     */
    protected final function createRule($name, $semesterFormat, $semesterPattern, $overview=false, $semesterStartSummer=NULL, $semesterStartWinter=NULL,$gradeFactor=1.0)
    {
        // fill array for rule creation
        $ruleAttributes = [
            'name' => $name,
            'semester_format' => $semesterFormat,
            'semester_pattern' => $semesterPattern,
            'semester_start_summer' => $semesterStartSummer,
            'semester_start_winter' => $semesterStartWinter,
            'grade_factor' => $gradeFactor,
            'overview' => $overview
        ];
        $rule = new Rule($ruleAttributes);

        // add rule to university
        $this->university->rules()->save($rule);
        return $rule;
    }

    /**
     * Creates an Action with the given attributes and adds it to the rule.
     *
     * @param Rule $rule
     * @param string $type
     * @param string $method
     * @param string $parseExpression
     * @param string $url
     * @return Action
     */
    protected final function createAction(Rule $rule, $type, $method, $parseExpression, $url=NULL)
    {
        // fill array for action creation
        $actionAttributes = [
            // position is calculated by current count of actions for this rule -> actions have to be added in order!
            'position' => $rule->actions()->count(),
            'type' => $type,
            'method' => $method,
            'url' => $url,
            'parse_expression' => $parseExpression
        ];
        $action = new Action($actionAttributes);

        // add action to rule
        $rule->actions()->save($action);
        return $action;
    }

    /**
     * Creates an ActionParam with the given attributes and adds it to the action.
     *
     * @param Action $action
     * @param string $key
     * @param string $type
     * @param string $value
     * @return ActionParam
     */
    protected final function createActionParam(Action $action, $key, $type=NULL, $value=NULL)
    {
        // fill array for action param creation
        $actionParamAttributes = [
            'key' => $key,
            'value' => $value,
            'type' => $type
        ];
        $actionParam = new ActionParam($actionParamAttributes);

        // add action param to action
        $action->actionParams()->save($actionParam);
        return $actionParam;
    }

    /**
     * Creates a TransformerMapping with the given attributes and adds it to the rule.
     *
     * @param Rule $rule
     * @param string $name
     * @param string $parseExpression
     * @return TransformerMapping
     */
    protected final function createTransformerMapping(Rule $rule, $name, $parseExpression)
    {
        // fill array for transformer mapping creation
        $transformerMappingsAttributes = [
            'name' => $name,
            'parse_expression' => $parseExpression
        ];
        $transformerMapping = new TransformerMapping($transformerMappingsAttributes);

        // add transformer mapping to rule
        $rule->transformerMappings()->save($transformerMapping);
        return $transformerMapping;
    }

    /**
     * Gets the university.
     * @return University the university.
     */
    public final function getUniversity()
    {
        return $this->university;
    }

    /**
     * Run the seed.
     * All logic regarding the university has to be placed inside this method.
     *
     * Gets called from the artisan seed and the PublishUniversity command.
     */
    public abstract function run();
}