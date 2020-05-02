<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class pesawat_airlines_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pesawat_airlines')->insert([
            'airline_name' => "Garuda Indonesia",
            'airline_logo' => "/images/airlines/garudaindonesia.png",
            'etiket_logo' => "/images/eticket/garuda-indonesia.png",
            'iata_code' => "GA",
            'icao_code' => "GIA",
        ]);

        DB::table('pesawat_airlines')->insert([
            'airline_name' => "Lion Air",
            'airline_logo' => "/images/airlines/lionair.png",
            'etiket_logo' => "/images/eticket/lionair.png",
            'iata_code' => "JT",
            'icao_code' => "LNI",
        ]);
    }
}
