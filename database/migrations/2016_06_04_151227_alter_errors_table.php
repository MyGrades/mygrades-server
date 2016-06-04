<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add columns "rule_id", "device", "android_version" to errors table
        Schema::table('errors', function ($table) {
            $table->integer('rule_id')->nullable();
            $table->string('device')->nullable();
            $table->string('android_version')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop columns
        Schema::table('errors', function ($table) {
            $table->dropColumn('rule_id');
            $table->dropColumn('device');
            $table->dropColumn('android_version');
        });
    }
}
