<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as IlluminateHash;

class karcis_user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karcis_users')->insert([
            'email' => "rfachru3@gmail.com",
            'password' => IlluminateHash::make("fachru1609"),
            'first_name' => "Fachrurozi",
            'last_name' => ".",
            'no_telp' => "0895610355705",
        ]);
    }
}
