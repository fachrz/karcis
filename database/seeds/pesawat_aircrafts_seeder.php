<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pesawat_aircrafts_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pesawat_aircrafts')->insert([
            'aircraft_registry' => "SDFHLK",
            'airline_id' => "1",
            'nationality' => "Indonesia",
            'aircraft_model' => "Boeing373",
        ]);

        DB::table('pesawat_aircrafts')->insert([
            'aircraft_registry' => "SDFDSF",
            'airline_id' => "2",
            'nationality' => "Indoneisa",
            'aircraft_model' => "Boeing190",
        ]);
    }
}
