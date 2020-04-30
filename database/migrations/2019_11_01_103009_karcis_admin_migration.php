<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KarcisAdminMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karcis_admin', function (Blueprint $table) {
            $table->string('username', 12)->primary();
            $table->string('password', 255);
            $table->string('admin_name', 50);
            $table->smallInteger('level');
            $table->string('thumbnail', 255)->default(asset('/images/avatar/default.png'));
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
