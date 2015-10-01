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
        $universities = University::published(true)->get();
        foreach($universities as $university)
        {
            $this->assertTrue($university->published === true);
            $this->assertGreaterThan(0, $university->rules->count());
            foreach($university->rules as $rule) {
                $this->assertGreaterThan(0, $rule->actions->count());
            }
        }
    }
}
