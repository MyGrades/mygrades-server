<?php

use App\Action;
use App\ActionParam;
use App\TransformerMapping;
use App\University;
use App\Rule;
use Illuminate\Support\Facades\DB;

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

    /**
     * Gets called when calling the seeder with PublishUniversity command with a list of rule ids.
     * So only rules of the university, which are in this array are updated.
     * @var array
     */
    private $rules = [];

    /**
     * Sets the array of rule ids.
     * @param array $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    // use
    protected $university;

    /**
     * Gets the university.
     * @return University the university.
     */
    public final function getUniversity()
    {
        return $this->university;
    }

    // constants
    const RULE_TYPE_MULTIPLE_TABLES = "multiple_tables";
    const RULE_SEMESTER_FORMAT_SEMESTER = "semester"; // e.q. WS 2015
    const RULE_SEMESTER_FORMAT_SEMESTER_REVERSED = "semester_reversed"; // e.g. 2015WS
    const RULE_SEMESTER_FORMAT_DATE = "date"; // e.q. 27.07.2015

    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const ACTION_TYPE_NORMAL = "normal";
    const ACTION_TYPE_TABLE_GRADES = "table_grades";
    const ACTION_TYPE_TABLE_OVERVIEW = "table_overview";
    const ACTION_TYPE_TABLE_GRADES_ITERATOR = "table_grades_iterator";

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
    
    const MT_SEMESTER_OPTIONS = "mt_semester_options";
    const MT_FORM_URL = "mt_form_url";
    const MT_SEMESTER_STRING = "mt_semester_string";

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
     * @param string $type
     * @return Rule
     */
    protected final function createRule($name, $semesterFormat, $semesterPattern, $overview=false, $semesterStartSummer=NULL, $semesterStartWinter=NULL,$gradeFactor=1.0, $type=NULL)
    {
        // fill array for rule creation
        $ruleAttributes = [
            'name' => $name,
            'semester_format' => $semesterFormat,
            'semester_pattern' => $semesterPattern,
            'semester_start_summer' => $semesterStartSummer,
            'semester_start_winter' => $semesterStartWinter,
            'grade_factor' => $gradeFactor,
            'overview' => $overview,
            'type' => $type
        ];

        // if $rules array is not empty -> this is an update
        if (!empty($this->rules)) {
            $ruleId = array_shift($this->rules);
            $rule = Rule::findOrFail($ruleId);
            $rule->update($ruleAttributes);

            // clear all actions and transformer mappings of rule
            $this->clearRule($rule);
        } else {
            $rule = new Rule($ruleAttributes);

            // add rule to university
            $this->university->rules()->save($rule);
        }
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
     * Run the seed.
     * All logic regarding the university has to be placed inside this method.
     *
     * Gets called from the artisan seed and the PublishUniversity command.
     */
    public abstract function run();


    /**
     * Clears the given rule from all actions, action params and transformer mappings.
     *
     * @param Rule $rule
     */
    private function clearRule(Rule $rule)
    {
        // delete all actions of rule
        // -> cascades down to actions_params
        Action::where("rule_id", $rule->rule_id)->delete();

        // delete all transformer mappings of rule
        TransformerMapping::where("rule_id", $rule->rule_id)->delete();
    }

    /**
     * Iterates over a string array, places each string into a given placeholder string at '%s'
     * and concatenates the resulting strings with a given delimiter.
     *
     * @param $stringArray
     * @param $placeholder
     * @param $delimiter
     * @return string
     */
    protected final function concatStringArray($stringArray, $placeholder, $delimiter)
    {
        $temp = array();

        foreach ($stringArray as $s)
        {
            array_push($temp, str_replace("%s", $s, $placeholder));
        }

        return implode($delimiter, $temp);
    }

    /**
     * Updates the university's updated at timestamp.
     * Important: Needs to be called after uni update so that it will be automatically re-fetched within the app after
     * changes to any rule of university.
     */
    public function updateUniversityTimestamp()
    {
        $this->university->touch();
    }
}
