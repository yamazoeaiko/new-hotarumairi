<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'お墓参り代行'
        ];
        DB::table('plans')->insert($param);

        $param = [
            'name' => 'お守り購入代行'
        ];
        DB::table('plans')->insert($param);

        $param = [
            'name' => '御朱印代行'
        ];
        DB::table('plans')->insert($param);

        $param = [
            'name' => 'その他代行'
        ];
        DB::table('plans')->insert($param);
    }
}
