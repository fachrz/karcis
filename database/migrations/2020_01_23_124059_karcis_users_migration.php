<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisUsersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karcis_users', function (Blueprint $table) {
            $table->string('email', 50)->primary();
            $table->string('password', 255)->nullable();
            $table->string('thumbnail', 255)->default('');
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('telp', 50)->default('');
            $table->integer('karcis_point')->default(0);
            $table->string('account_type', 8);
            $table->timestamps();
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
