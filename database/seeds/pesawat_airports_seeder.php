<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pesawat_airports_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pesawat_airports')->insert([
            'id_airport' => "CGK",
            'airport_name' => "Soekarno Hatta",
            'location' => "Cengkareng",
            'province' => "Banten",
        ]);

         DB::table('pesawat_airports')->insert([
            'id_airport' => "SUB",
            'airport_name' => "Juanda",
            'location' => "Sedati",
            'province' => "Surabaya",
        ]);
    }
}
