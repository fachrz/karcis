<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesawatSchedulesTable extends Migration
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
            $table->integer('premeconomy_quota');
            $table->integer('bussiness_quota');
            $table->integer('first_quota');
            $table->integer('economy_quota');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesawat_schedules');
    }
}
