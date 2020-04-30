<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisKeretaTicketsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kereta_tickets', function (Blueprint $table) {
            $table->string('id_ticket', 50)->primary();
            $table->string('id_schedule', 25);
            $table->string('seat_class', 25);
            $table->bigInteger('price');
            $table->integer('economy_quota')->default(0);
            $table->integer('bussiness_quota')->default(0);
            $table->integer('executive_quota')->default(0);
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
