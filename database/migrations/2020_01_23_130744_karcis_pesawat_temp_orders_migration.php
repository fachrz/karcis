<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisPesawatTempOrdersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesawat_temp_orders', function (Blueprint $table) {
            $table->string('id_temp_order', 10)->primary();
            $table->string('id_ticket', 25);
            $table->string('id_ticket2', 25)->nullable();
            $table->string('cust_fullname', 25);
            $table->string('cust_email', 50);
            $table->integer('total_price');
            $table->integer('id_voucher')->nullable();
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
