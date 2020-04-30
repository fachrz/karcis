<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(pesawat_airports_seeder::class);
        $this->call(pesawat_schedules_seeder::class);
        $this->call(pesawat_tickets_seeder::class);
        $this->call(pesawat_aircrafts_seeder::class);
        $this->call(pesawat_airlines_seeder::class);
        $this->call(pesawat_flights_seeder::class);


        $this->call(kereta_stations_seeder::class);
        $this->call(kereta_trains_seeder::class);
        $this->call(kereta_schedules_seeder::class);
        $this->call(kereta_tickets_seeder::class);

        $this->call(karcis_admin_seeder::class);
        $this->call(karcis_vouchers_seeder::class);

    }
}
