<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesawatAirlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesawat_airlines', function (Blueprint $table) {
            $table->increments('airline_id');
            $table->string('airline_name', 25);
            $table->string('airline_logo', 255);
            $table->string('etiket_logo', 255);
            $table->string('iata_code', 4);
            $table->string('icao_code', 4);
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
        Schema::dropIfExists('pesawat_airlines');
    }
}
