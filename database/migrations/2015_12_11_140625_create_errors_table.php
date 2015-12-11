<?php

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errors', function (Blueprint $table) {
            $table->increments('error_id');
            $table->integer('university_id');
            $table->string('name')->nullable();
            $table->text('message')->nullable();
            $table->string('email')->nullable();
            $table->string("app_version");
            $table->timestamp("created_at");

            $table->timestamp('cron_seen')->nullable();
            $table->boolean("fixed");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("errors");
    }
}
