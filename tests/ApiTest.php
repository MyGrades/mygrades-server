<?php

use App\University;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    protected $apiPrefix = "/api/v1";

    /**
     * Test if all published universities have at least one rule with at least one action.
     */
    public function testPublishedUniversities()
    {
        University::published(true)->get()->each(function ($university)
        {
            $this->assertTrue($university->published === true);
            $this->assertGreaterThan(0, $university->rules->count());

            $university->rules->each(function ($rule) {
                $this->assertGreaterThan(0, $rule->actions->count());
            });
        });
    }

    /**
     * TODO: call function on each published university
     */
    public function testSingleUniversityDetailed()
    {
        $response = $this->call('GET', $this->apiPrefix . '/universities/333?detailed=true');
        $data = $this->parseJson($response);

        $this->assertObjectHasAttribute("university_id", $data);
        $this->assertObjectHasAttribute("published", $data);
        $this->assertObjectHasAttribute("name", $data);
        $this->assertObjectHasAttribute("updated_at_server", $data);

        // check structure of rules
        $this->assertObjectHasAttribute("rules", $data);
        $this->assertGreaterThan(0, count($data->rules));
        foreach ($data->rules as $rule) {
            // set booleans for action params username and password
            $usernameIsPresent = false;
            $passwordIsPresent = false;

            $this->assertObjectHasAttribute("rule_id", $rule);
            $this->assertObjectHasAttribute("type", $rule);
            $this->assertObjectHasAttribute("semester_format", $rule);
            $this->assertObjectHasAttribute("semester_pattern", $rule);
            $this->assertObjectHasAttribute("semester_start_summer", $rule);
            $this->assertObjectHasAttribute("semester_start_winter", $rule);
            $this->assertObjectHasAttribute("grade_factor", $rule);

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
        }
    }



    private function parseJson($response)
    {
        return json_decode($response->getContent());
    }
}
