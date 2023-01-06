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
            'password' => \Hash::make('testtest')
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '田中B子',
            'email' => 'test_b@example.com',
            'password' => \Hash::make('testtest')
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '佐藤C男',
            'email' => 'test_c@example.com',
            'password' => \Hash::make('testtest')
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '高橋D花',
            'email' => 'test_d@example.com',
            'password' => \Hash::make('testtest')
        ];
        DB::table('users')->insert($param);
    }
}
