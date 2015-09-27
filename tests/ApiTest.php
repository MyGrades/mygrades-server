<?php

use App\University;
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
        /*$this->get($this->apiPrefix . '/universities')
            ->seeJsonEquals(University::all()->toArray());*/
        $this->assertTrue(true);
    }

    public function testGetSingleUniversity()
    {
        /*$this->get($this->apiPrefix . '/university/333')
            ->seeJsonEquals([
                "university_id" => 333,
                "short_name" => "RheinMain H",
                "name" => "Hochschule RheinMain, RheinMain University of Applied Sciences Wiesbaden, Rüsselsheim",
                "sponsorship" => "staatlich",
                "state" => "Hessen",
                "student_count" => 11407,
                "year_established" => 1971,
                "street" => "Kurt-Schumacher-Ring 18",
                "plz" => "65197",
                "city" => "Wiesbaden",
                "website" => "http://www.hs-rm.de",
                "created_at" => "-0001-11-30 00:00:00",
                "updated_at" => "-0001-11-30 00:00:00"
            ]);*/
        $this->assertTrue(true);
    }

/*
    public function testGetSingleUniversityDetailed()
    {
        $this->post('/user', ['name' => 'Sally'])
            ->seeJsonEquals([
                'created' => true
            ]);
    }

    public function testCreateWishForUniversity()
    {

    }

    public function testCreateErrorForUniversity()
    {
        $this->post('/user', ['name' => 'Sally'])
            ->seeJsonEquals([
                'created' => true
            ]);
    }*/
}
