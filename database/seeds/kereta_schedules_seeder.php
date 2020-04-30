<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kereta_schedules_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kereta_schedules')->insert([
            'id_schedule' => "1",
            'station_from' => "BD",
            'station_to' => "GMR",
            'train_id' => "KA47",
            'departure_date' => Carbon::parse('2020-02-2 19:18:44'),
        ]);

        DB::table('kereta_schedules')->insert([
            'id_schedule' => "2",
            'station_from' => "GMR",
            'station_to' => "BD",
            'train_id' => "KA45",
            'departure_date' => Carbon::parse('2020-02-2 19:18:44')
        ]);
    }
}
