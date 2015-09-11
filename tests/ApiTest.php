<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    protected $apiPrefix = "/api/v1";

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetUniversities()
    {
        $this->get('/universities')
            ->seeJsonEquals([
                'created' => true,
            ]);
    }

    public function testGetSingleUniversity()
    {
        /*
         * {
  "university_id": 333,
  "short_name": "RheinMain H",
  "name": "Hochschule RheinMain, RheinMain University of Applied Sciences Wiesbaden, Rüsselsheim",
  "sponsorship": "staatlich",
  "state": "Hessen",
  "student_count": 11407,
  "year_established": 1971,
  "street": "Kurt-Schumacher-Ring 18",
  "plz": "65197",
  "city": "Wiesbaden",
  "website": "http://www.hs-rm.de",
  "created_at": "-0001-11-30 00:00:00",
  "updated_at": "-0001-11-30 00:00:00",
  "rules": [
    {
      "rule_id": 1,
      "type": "bachelor",
      "university_id": 333,
      "created_at": "2015-09-09 21:59:01",
      "updated_at": "2015-09-09 21:59:01",
      "actions": []
    },
    {
      "rule_id": 2,
      "type": "master",
      "university_id": 333,
      "created_at": "2015-09-09 21:59:01",
      "updated_at": "2015-09-09 21:59:01",
      "actions": []
    },
    {
      "rule_id": 3,
      "type": "registeredTests",
      "university_id": 333,
      "created_at": "2015-09-09 21:59:01",
      "updated_at": "2015-09-09 21:59:01",
      "actions": []
    }
  ]
}
         */

        $this->get('/university/333')
            ->seeJsonEquals([
                "rule_id" => true,

            ]);
    }

    public function testGetSingleUniversityDetailed()
    {
        $this->post('/user', ['name' => 'Sally'])
            ->seeJsonEquals([
                'created' => true,
            ]);
    }

    public function testCreateWishForUniversity()
    {

    }

    public function testCreateErrorForUniversity()
    {
        $this->post('/user', ['name' => 'Sally'])
            ->seeJsonEquals([
                'created' => true,
            ]);
    }
}
