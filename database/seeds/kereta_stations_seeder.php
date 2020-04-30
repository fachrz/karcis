<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kereta_stations_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kereta_stations')->insert([
            'id_station' => "BD",
            'station_name' => "Bandung",
            'location' => "Andir",
            'province' => "Jawa Barat",
        ]);

         DB::table('kereta_stations')->insert([
            'id_station' => "GMR",
            'station_name' => "Gambir",
            'location' => "Gambir",
            'province' => "Jakarta",
        ]);
    }
}
