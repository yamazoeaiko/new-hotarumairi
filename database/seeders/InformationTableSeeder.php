<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'title' => 'おお知らせ（デフォルト①）',
            'content' => 'お知らせ①の内容が入る。',
            'status' => '1'
        ];
        DB::table('informations')->insert($param);

        $param = [
            'title' => 'おお知らせ（デフォルト②）',
            'content' => 'お知らせ②の内容が入る。',
            'status' => '2'
        ];
        DB::table('informations')->insert($param);

        $param = [
            'title' => 'おお知らせ（デフォルト③）',
            'content' => 'お知らせ③の内容が入る。',
            'status' => '3'
        ];
        DB::table('informations')->insert($param);

        $param = [
            'title' => 'おお知らせ（デフォルト④）',
            'content' => 'お知らせ④の内容が入る。',
            'status' => 'nopublic'
        ];
        DB::table('informations')->insert($param);
    }
}
