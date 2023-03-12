<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTableSeeder extends Seeder
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
            'category_ids' => '["1","2"]',
            'main_title' => 'お墓参り代行お任せください',
            'content' => '詳細内容を記載します。',
            'photo_1' => 'storage/service/sample1.png',
            'attention' => 'ご購入いただく前にお見積もり相談からご相談ください！',
            'public_sign' => true,
            'price' => '10000',
            'area_id' => '[5,6,7]'
        ];
        DB::table('services')->insert($param);

        $param = [
            'user_id' => '2',
            'category_ids' => '["3"]',
            'main_title' => '参拝代行お任せください',
            'photo_1' => 'storage/service/sample2.png',
            'content' => 'ご指定の神社仏閣に参拝に行きます！',
            'attention' => '何か購入代行の希望がある場合は、事前にその商品が売られているかご確認くださ',
            'public_sign' => true,
            'price' => '20000',
            'area_id' => '[23,24]',
        ];
        DB::table('services')->insert($param);

        $param = [
            'user_id' => '3',
            'category_ids' => '["2","4"]',
            'main_title' => '【SNSで大人気】占いお任せください',
            'content' => 'SNSで大好評の占いを実施します',
            'photo_1' => 'storage/service/sample3.png',
            'attention' => 'オンラインで占いかオフライン希望か教えてください！',
            'public_sign' => true,
            'price' => '5000',
            'area_id' => '[30,31,32]'
        ];
        DB::table('services')->insert($param);
    }
}
