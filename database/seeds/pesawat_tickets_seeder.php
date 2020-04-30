<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pesawat_tickets_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pesawat_tickets')->insert([
            'id_ticket' => "KRC01",
            'id_schedule' => "1",
            'seat_class' => "economy",
            'price' => $price = 700000,
            'karcis_point' => (5 / 100) * $price,
            'economy_quota' => 50,
            'premeconomy_quota' => 50,
            'bussiness_quota' => 50,
            'first_quota' => 50,
        ]);

        DB::table('pesawat_tickets')->insert([
            'id_ticket' => "KRC02",
            'id_schedule' => "2",
            'seat_class' => "economy",
            'price' => 700000,
            'karcis_point' => (5 / 100) * $price,
            'economy_quota' => 50,
            'premeconomy_quota' => 50,
            'bussiness_quota' => 50,
            'first_quota' => 50,
        ]);
    }
}
