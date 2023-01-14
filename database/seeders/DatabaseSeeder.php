<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(AreaTableSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserProfileTableSeeder::class);
        $this->call(OhakamairiSummaryTableSeeder::class);
        $this->call(SanpaiSummaryTableSeeder::class);
        $this->call(HotaruRequestTableSeeder::class);
    }
}
