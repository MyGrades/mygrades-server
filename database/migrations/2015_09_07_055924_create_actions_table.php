<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('action_id');
            $table->integer('position')->unsigned();
            $table->string('method');
            $table->text('url')->nullable();
            $table->text('parse_expression');
            $table->string('parse_type');

            $table->integer('rule_id')->unsigned();
            $table->timestamps();

            $table->foreign('rule_id')->references('rule_id')->on('rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('actions');
    }
}
