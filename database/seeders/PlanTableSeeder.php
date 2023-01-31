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
            'name' => 'お墓のお掃除・お参り代行'
        ];
        DB::table('plans')->insert($param);

        $param = [
            'name' => 'お守、お札、御朱印購入代行'
        ];
        DB::table('plans')->insert($param);

        $param = [
            'name' => '神社仏閣参拝、祈祷代行'
        ];
        DB::table('plans')->insert($param);

        $param = [
            'name' => 'その他お参り代行'
        ];
        DB::table('plans')->insert($param);
    }
}
