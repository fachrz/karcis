<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pesawat_schedules_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pesawat_schedules')->insert([
            'id_schedule' => "1",
            'aircraft_registry' => "SDFHLK",
            'flight_number' => "GA-350",
            'departure_date' => Carbon::parse('2020-05-2 19:18:44'),
        ]); 

        DB::table('pesawat_schedules')->insert([
            'id_schedule' => "2",
            'aircraft_registry' => "SODIF",
            'flight_number' => "JT-250",
            'departure_date' => Carbon::parse('2020-05-2 19:18:44'),
        ]);
    }
}
