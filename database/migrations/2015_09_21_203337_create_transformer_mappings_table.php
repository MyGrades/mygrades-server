<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransformerMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transformer_mappings', function (Blueprint $table) {
            $table->increments('transformer_mapping_id');
            $table->string('name');
            $table->text('parse_expression');
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
        Schema::drop('transformer_mappings');
    }
}
