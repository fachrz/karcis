<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kereta_tickets_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kereta_tickets')->insert([
            'id_ticket' => "KRC01",
            'id_schedule' => "1",
            'seat_class' => "economy",
            'price' => 700000,
            'economy_quota' => 50,
            'bussiness_quota' => 50,
            'executive_quota' => 50
        ]);

        DB::table('kereta_tickets')->insert([
            'id_ticket' => "KRC02",
            'id_schedule' => "3",
            'seat_class' => "economy",
            'price' => 700000,
            'economy_quota' => 50,
            'bussiness_quota' => 50,
            'executive_quota' => 50
        ]);
    }
}
