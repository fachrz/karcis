<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pesawat_flights_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pesawat_flights')->insert([
            'flight_number' => "GA-350",
            'airport_from' => "CGK",
            'airport_to' => "SUB",
            'airline_id' => "1",
        ]);

        DB::table('pesawat_flights')->insert([
            'flight_number' => "JT-250",
            'airport_from' => "SUB",
            'airport_to' => "CGK",
            'airline_id' => "2",
        ]);
    }
}
