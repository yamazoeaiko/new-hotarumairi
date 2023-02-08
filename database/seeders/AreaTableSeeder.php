<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $param = [
            'category' => '北海道エリア',
            'name' => '北海道'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '東北エリア',
            'name' => '青森'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '東北エリア',
            'name' => '岩手'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '東北エリア',
            'name' => '宮城'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '東北エリア',
            'name' => '秋田'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '東北エリア',
            'name' => '山形'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '東北エリア',
            'name' => '福島'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '茨城'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '栃木'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '群馬'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '埼玉'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '千葉'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '東京'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '関東エリア',
            'name' => '神奈川'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '新潟'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '富山'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '石川'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '福井'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '山梨'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '長野'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '岐阜'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '静岡'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中部エリア',
            'name' => '愛知'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '三重'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '滋賀'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '京都'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '大阪'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '兵庫'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '奈良'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '近畿エリア',
            'name' => '和歌山'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中国エリア',
            'name' => '鳥取'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中国エリア',
            'name' => '島根'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中国エリア',
            'name' => '岡山'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中国エリア',
            'name' => '広島'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '中国エリア',
            'name' => '山口'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '四国エリア',
            'name' => '徳島'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '四国エリア',
            'name' => '香川'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '四国エリア',
            'name' => '愛媛'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '四国エリア',
            'name' => '高知'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '福岡'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '佐賀'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '長崎'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '熊本'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '大分'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '宮崎'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '九州エリア',
            'name' => '鹿児島'
        ];
        DB::table('areas')->insert($param);

        $param = [
            'category' => '沖縄エリア',
            'name' => '沖縄'
        ];
        DB::table('areas')->insert($param);
    }
}
