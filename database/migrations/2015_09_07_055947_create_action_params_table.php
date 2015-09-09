<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_params', function (Blueprint $table) {
            $table->increments('action_param_id');
            $table->string('key');
            $table->string('value')->nullable();

            $table->integer('action_id')->unsigned();
            $table->timestamps();

            $table->foreign('action_id')->references('action_id')->on('actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('action_params');
    }
}
