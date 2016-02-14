<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterWishesErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add column "written" to wishes table
        Schema::table('wishes', function ($table) {
            $table->boolean('written');
            $table->boolean('done');
        });

        // add column "written" to errors table
        Schema::table('errors', function ($table) {
            $table->boolean('written');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wishes', function ($table) {
            $table->dropColumn('written');
            $table->dropColumn('done');
        });

        Schema::table('errors', function ($table) {
            $table->dropColumn('written');
        });
    }
}
