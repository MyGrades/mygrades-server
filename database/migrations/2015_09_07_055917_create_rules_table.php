<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('rule_id');
            $table->string('name');
            $table->string('semester_format');
            $table->string('semester_pattern');
            $table->integer('semester_start_summer')->nullable();
            $table->integer('semester_start_winter')->nullable();
            $table->double('grade_factor')->default(1); // set default factor to 1
            $table->boolean('overview')->default(false);

            $table->integer('university_id')->unsigned();
            $table->timestamps();

            $table->foreign('university_id')->references('university_id')->on('universities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rules');
    }
}
