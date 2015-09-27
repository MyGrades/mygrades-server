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
            $table->string('type');
            $table->string('semester_format');
            $table->string('semester_pattern');
            $table->double('grade_factor');

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
