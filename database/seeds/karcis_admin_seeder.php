<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as IlluminateHash;

class karcis_admin_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karcis_admin')->insert([
            'username' => "fachrz",
            'password' => IlluminateHash::make("fachru1609"),
            'admin_name' => "Fachrurozi",
            'level' => "0",
        ]);

        DB::table('karcis_admin')->insert([
            'username' => "alvianfh",
            'password' => IlluminateHash::make("fachru1609"),
            'admin_name' => "Alvian",
            'level' => "1",
        ]);
    }
}
