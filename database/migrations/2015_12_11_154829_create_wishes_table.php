<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //wish_id, uni_name, name, message, email, created_at, cron_seen
        Schema::create('wishes', function (Blueprint $table) {
            $table->increments('wish_id');
            $table->string('university_name');
            $table->string('name')->nullable();
            $table->text('message')->nullable();
            $table->string('email')->nullable();
            $table->string("app_version");
            $table->timestamp("created_at");

            $table->timestamp('cron_seen')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("wishes");
    }
}
