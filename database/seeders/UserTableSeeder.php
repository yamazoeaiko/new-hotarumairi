<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '山田A太郎',
            'email' => 'test_a@example.com',
            'password' => \Hash::make('testtest'),
            'nickname' => 'A太郎さん',
            'birthday' => '1987/5/12',
            'gender' => '1',
            'living_area' => '1',
            'message' => '丁寧な作業を心がけます！'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '田中B子',
            'email' => 'test_b@example.com',
            'password' => \Hash::make('testtest'),
            'nickname' => 'B子さん',
            'birthday' => '1994/8/1',
            'gender' => '2',
            'living_area' => '18',
            'message' => '宜しくお願いします！'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '佐藤C男',
            'email' => 'test_c@example.com',
            'password' => \Hash::make('testtest'),
            'nickname' => 'c男さん',
            'birthday' => '1970/12/21',
            'gender' => '1',
            'living_area' => '38',
            'message' => '宜しくお願いします！'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '高橋D花',
            'email' => 'test_d@example.com',
            'password' => \Hash::make('testtest'),
            'nickname' => 'D花さん',
            'birthday' => '1988/2/5',
            'gender' => '2',
            'living_area' => '25',
            'message' => '宜しくお願いします！'
        ];
        DB::table('users')->insert($param);
    }
}
