<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kereta_trains_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kereta_trains')->insert([
            'train_id' => "KA45",
            'train_name' => "Argo Parahyangan 45",
        ]);

        DB::table('kereta_trains')->insert([
            'train_id' => "KA47",
            'train_name' => "Argo Parahyangan 47",
        ]);
    }
}
