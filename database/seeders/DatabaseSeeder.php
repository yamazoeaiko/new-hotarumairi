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
        $this->call(UserTableSeeder::class);
        $this->call(ServiceCategoryTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(InformationTableSeeder::class);
    }
}
