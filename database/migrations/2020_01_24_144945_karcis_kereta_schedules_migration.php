<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisKeretaSchedulesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kereta_schedules', function (Blueprint $table) {
            $table->increments('id_schedule');
            $table->string('station_from', 3);
            $table->string('station_to', 3);
            $table->string('train_id');
            $table->dateTime('departure_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
