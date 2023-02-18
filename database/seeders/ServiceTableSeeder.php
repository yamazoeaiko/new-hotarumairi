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
            'attention' => 'ご購入いただく前にお見積もり相談からご相談ください！',
            'public_sign' => true,
            'price_net' => '8500',
            'price' => '10000'
        ];
        DB::table('services')->insert($param);

        $param = [
            'user_id' => '2',
            'category_ids' => '["3"]',
            'main_title' => '参拝代行お任せください',
            'content' => 'ご指定の神社仏閣に参拝に行きます！',
            'attention' => '何か購入代行の希望がある場合は、事前にその商品が売られているかご確認くださ',
            'public_sign' => true,
            'price_net' => '17000',
            'price' => '20000'
        ];
        DB::table('services')->insert($param);

        $param = [
            'user_id' => '3',
            'category_ids' => '["2","4"]',
            'main_title' => '【SNSで大人気】占いお任せください',
            'content' => 'SNSで大好評の占いを実施します',
            'attention' => 'オンラインで占いかオフライン希望か教えてください！',
            'public_sign' => true,
            'price_net' => '4250',
            'price' => '5000'
        ];
        DB::table('services')->insert($param);
    }
}
