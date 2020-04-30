<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisKeretaTempOrdersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kereta_temp_orders', function (Blueprint $table) {
            $table->string('id_temp_order', 10);
            $table->string('id_ticket', 25);
            $table->string('cust_fullname', 25);
            $table->string('cust_email', 25);
            $table->integer('total_price')->default(0);
            $table->dateTime('exptime');
            $table->string('payment_code', 15);
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
