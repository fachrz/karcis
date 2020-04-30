<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class karcis_vouchers_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karcis_vouchers')->insert([
            'voucher_name' => 'Potongan Rp. 100.000',
            'benefit' => "100000",
            'karcis_point' => "1000",
        ]);

        DB::table('karcis_vouchers')->insert([
            'voucher_name' => "Potongan Rp. 250.000",
            'benefit' => '250000',
            'karcis_point' => "1000",
        ]);
    }
}
