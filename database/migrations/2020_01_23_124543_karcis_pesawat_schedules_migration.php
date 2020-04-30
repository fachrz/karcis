<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisPesawatSchedulesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesawat_schedules', function (Blueprint $table) {
            $table->integer('id_schedule')->autoIncrement();    
            $table->string('aircraft_registry');
            $table->string('flight_number');
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
