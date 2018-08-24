<?php

use App\Rule;
use App\University;
use Carbon\Carbon;
use Tests\TestCase;

class ApiTest extends TestCase
{
    protected $apiPrefix = "/api/v1";

    /**
     * Test if all published universities have the necessary attributes.
     */
    public function testPublishedUniversities()
    {
        // get all published universities
        $response = $this->call('GET', $this->apiPrefix . '/universities?published=true');

        $universities = $this->parseJson($response);
        /**
         * @var $university University
         */
        foreach ($universities as $university) {
            $this->assertObjectHasAttribute("university_id", $university);
            $this->assertObjectHasAttribute("published", $university);
            $this->assertObjectHasAttribute("name", $university);
            $this->assertObjectHasAttribute("updated_at_server", $university);
            $this->assertEquals($university->published, true);
        }
    }

    /**
     * Test all published universities and its details.
     */
    public function testPublishedUniversitiesWithDetails()
    {
        // get all published universities
        $response = $this->call('GET', $this->apiPrefix . '/universities?published=true');

        $hiddenFields = Rule::getDefaultHidden();
        Rule::setStaticHidden($hiddenFields);

        $universities = $this->parseJson($response);
        foreach ($universities as $university) {
            // get detailed university
            $detailedResponse = $this->call('GET', $this->apiPrefix . '/universities/' . $university->university_id . '?detailed=true');
            $detailedUniversity = $this->parseJson($detailedResponse);
            $this->checkSingleUniversityDetailed($detailedUniversity);
        }
    }

    /**
     * Checks if the given university has all necessary attributes.
     * This method will be called for each university from other tests.
     *
     * @param $university
     */
    public function checkSingleUniversityDetailed($university)
    {
        $this->assertObjectHasAttribute("university_id", $university);
        $this->assertObjectHasAttribute("published", $university);
        $this->assertObjectHasAttribute("name", $university);
        $this->assertObjectHasAttribute("updated_at_server", $university);

        // check structure of rules
        $this->assertObjectHasAttribute("rules", $university);
        $this->assertGreaterThan(0, count($university->rules));
        foreach ($university->rules as $rule) {
            //var_dump($rule);
            // set booleans for action params username and password
            $usernameIsPresent = false;
            $passwordIsPresent = false;

            $this->assertObjectHasAttribute("rule_id", $rule);
            $this->assertObjectHasAttribute("name", $rule);
            $this->assertObjectHasAttribute("semester_format", $rule);
            $this->assertObjectHasAttribute("semester_pattern", $rule);
            $this->assertObjectHasAttribute("semester_start_summer", $rule);
            $this->assertObjectHasAttribute("semester_start_winter", $rule);
            $this->assertObjectHasAttribute("grade_factor", $rule);
            $this->assertObjectHasAttribute("overview", $rule);

            // check structure of actions
            $this->assertObjectHasAttribute("actions", $rule);
            $this->assertGreaterThan(0, count($rule->actions));
            foreach ($rule->actions as $action) {
                $this->assertObjectHasAttribute("action_id", $action);
                $this->assertObjectHasAttribute("position", $action);
                $this->assertObjectHasAttribute("method", $action);
                $this->assertObjectHasAttribute("url", $action);
                $this->assertObjectHasAttribute("parse_expression", $action);
                $this->assertObjectHasAttribute("action_params", $action);

                // check structure of action_params if present
                if (count($action->action_params) > 0) {
                    foreach ($action->action_params as $action_param) {
                        $this->assertObjectHasAttribute("action_param_id", $action_param);
                        $this->assertObjectHasAttribute("key", $action_param);
                        $this->assertObjectHasAttribute("value", $action_param);
                        $this->assertObjectHasAttribute("type", $action_param);

                        if ($action_param->type === "username") {
                            $usernameIsPresent = true;
                        }
                        if ($action_param->type === "password") {
                            $passwordIsPresent = true;
                        }
                    }
                }
            }

            // check structure of transformer_mappings
            $this->assertObjectHasAttribute("transformer_mappings", $rule);
            $this->assertGreaterThan(0, count($rule->transformer_mappings));
            foreach ($rule->transformer_mappings as $transformer_mapping) {
                $this->assertObjectHasAttribute("transformer_mapping_id", $transformer_mapping);
                $this->assertObjectHasAttribute("name", $transformer_mapping);
                $this->assertObjectHasAttribute("parse_expression", $transformer_mapping);
            }

            // make sure that username and password is present in rule
            $this->assertTrue($usernameIsPresent, "Username is present");
            $this->assertTrue($passwordIsPresent, "Password is present");

            // if overview === true, search for actions with type === table_overview
            if ($rule->overview === true) {
                $tableOverviewIsPresent = false;
                foreach ($rule->actions as $action) {
                    if ($action->type === 'table_overview') {
                        $tableOverviewIsPresent = true;
                        break;
                    }
                }
                $this->assertEquals(true, $tableOverviewIsPresent);
            }
        }
    }

    /**
     * Test if consecutive calls to published universities returns only new ones.
     *
     * 1. Get all published universities and the latest updated_at timestamp
     * 2. Get all published universities -> expect empty array
     * 3. touch hsrm to updated its timestamp
     * 4. Get all published universities -> expect 1 university
     */
    public function testTimestampPublishedOnly()
    {
        // get all published universities
        $response = $this->call('GET', $this->apiPrefix . '/universities?published=true');
        $universities = $this->parseJson($response);

        // get latest timestamp
        $latestTimestamp = $this->getLatestTimestamp($universities);

        if ($latestTimestamp !== null) {
            // get all published universities with Updated-At-Server header parameter
            $response = $this->call('GET', $this->apiPrefix . '/universities?published=true', [], [], [], $server = [
                'HTTP_Updated-At-Server-Published' => $latestTimestamp->toDateTimeString()
            ]);

            // check if array is empty
            $universities = $this->parseJson($response);
            $this->assertEquals(0, count($universities));

            // get month to month back from latestTimestamp and check if retrieved universities are newer
            for ($i=1; $i <= 12; $i++) {
                $latestTimestamp->subMonth();
                $response = $this->call('GET', $this->apiPrefix . '/universities?published=true', [], [], [], $server = [
                    'HTTP_Updated-At-Server-Published' => $latestTimestamp->toDateTimeString()
                ]);
                $universities = $this->parseJson($response);
                foreach ($universities as $university) {
                    $updated_at_server_current = Carbon::parse($university->updated_at_server);
                    $this->assertTrue($updated_at_server_current->gt($latestTimestamp));
                }
            }
        }
    }

    /**
     * Gets the latest timestamp for a list of universities.
     *
     * @param $universities
     * @return null|Carbon
     */
    private function getLatestTimestamp($universities)
    {
        $latestTimestamp = null;
        foreach ($universities as $university) {
            $actTimestamp = Carbon::parse($university->updated_at_server);
            if ($latestTimestamp === null || $actTimestamp->gt($latestTimestamp)) {
                $latestTimestamp = $actTimestamp;
            }
        }
        return $latestTimestamp;
    }

    /**
     * Parse json to a php object.
     *
     * @param $response
     * @return mixed
     */
    private function parseJson($response)
    {
        return json_decode($response->getContent());
    }
}
