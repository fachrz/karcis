<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesawatAircraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesawat_aircrafts', function (Blueprint $table) {
            $table->string('aircraft_registry', 10)->primary();
            $table->integer('airline_id');
            $table->string('nationality', 25);
            $table->string('aircraft_model', 15);
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
        Schema::dropIfExists('pesawat_aircrafts');
    }
}
