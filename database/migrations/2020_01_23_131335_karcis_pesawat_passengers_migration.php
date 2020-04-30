<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisPesawatPassengersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesawat_passengers', function (Blueprint $table) {
            $table->string('title', 25);
            $table->string('fullname', 25);
            $table->string('type', 10);
            $table->string('citizenship', 25);
            $table->string('id_order', 20);
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
