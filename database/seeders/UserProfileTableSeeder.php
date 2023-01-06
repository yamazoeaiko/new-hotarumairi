<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'nickname' => 'A太郎さん',
            'birthday' => '1987/5/12',
            'gender' => '1',
            'living_area' => '1',
            'message' => '丁寧な作業を心がけます！'
        ];
        DB::table('user_profiles')->insert($param);

        $param = [
            'user_id' => '2',
            'nickname' => 'B子さん',
            'birthday' => '1994/8/1',
            'gender' => '2',
            'living_area' => '18',
            'message' => '宜しくお願いします！'
        ];
        DB::table('user_profiles')->insert($param);

        $param = [
            'user_id' => '3',
            'nickname' => 'c男さん',
            'birthday' => '1970/12/21',
            'gender' => '1',
            'living_area' => '38',
            'message' => '宜しくお願いします！'
        ];
        DB::table('user_profiles')->insert($param);

        $param = [
            'user_id' => '4',
            'nickname' => 'D花さん',
            'birthday' => '1988/2/5',
            'gender' => '2',
            'living_area' => '25',
            'message' => '宜しくお願いします！'
        ];
        DB::table('user_profiles')->insert($param);
    }
}
