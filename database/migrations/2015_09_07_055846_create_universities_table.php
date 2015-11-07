<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->increments('university_id');
            $table->boolean('published')->default(false);
            $table->string('short_name');
            $table->string('name');
            $table->string('sponsorship');
            $table->string('state');
            $table->integer('student_count');
            $table->integer('year_established');
            $table->string('street');
            $table->string('plz');
            $table->string('city');
            $table->string('website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('universities');
    }
}
