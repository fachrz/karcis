<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesawatTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesawat_tickets', function (Blueprint $table) {
            $table->string('id_ticket', 50)->primary();
            $table->string('id_schedule', 25)->unique();
            $table->string('seat_class', 25);
            $table->integer('karcis_point')->default(0);
            $table->bigInteger('price');
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
        Schema::dropIfExists('pesawat_tickets');
    }
}
