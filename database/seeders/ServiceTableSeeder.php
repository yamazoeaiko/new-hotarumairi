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
            'offer_user_id' => '1',
            'category_ids' => '["1","2"]',
            'main_title' => 'お墓参り代行お任せください',
            'content' => '詳細内容を記載します。',
            'photo_1' => 'storage/service/sample1.png',
            'attention' => 'ご購入いただく前にお見積もり相談からご相談ください！',
            'price' => '10000',
            'price_net' => '8500',
            'area_id' => '[5,6,7]',
            'public_sign'=>'public',
            'status'=> 'open_applications',
        ];
        DB::table('services')->insert($param);

        $param = [
            'offer_user_id' => '2',
            'category_ids' => '["3"]',
            'main_title' => '参拝代行お任せください',
            'photo_1' => 'storage/service/sample2.png',
            'content' => 'ご指定の神社仏閣に参拝に行きます！',
            'attention' => '何か購入代行の希望がある場合は、事前にその商品が売られているかご確認くださ',
            'price' => '20000',
            'price_net' => '17000',
            'area_id' => '[23,24]',
            'public_sign' => 'public',
            'status' => 'open_applications',
        ];
        DB::table('services')->insert($param);

        $param = [
            'offer_user_id' => '3',
            'category_ids' => '["2","4"]',
            'main_title' => '【SNSで大人気】占いお任せください',
            'content' => 'SNSで大好評の占いを実施します',
            'photo_1' => 'storage/service/sample3.png',
            'attention' => 'オンラインで占いかオフライン希望か教えてください！',
            'price' => '5000',
            'price_net' => '4250',
            'area_id' => '[30,31,32]',
            'public_sign' => 'public',
            'status' => 'open_applications',
        ];
        DB::table('services')->insert($param);

        $param = [
            'request_user_id' => '4',
            'category_ids' => '["2","4"]',
            'main_title' => '婚期を占って下さい',
            'content' => '将来結婚できるか心配で占いしてほしいです',
            'attention' => 'オンラインで実施希望です',
            'price' => '5000',
            'price_net' => '4250',
            'application_deadline'=>'2023-04-20',
            'delivery_deadline'=> '2023-05-10',
            'public_sign' => 'public',
            'status' => 'open_applications',
        ];
        DB::table('services')->insert($param);

        $param = [
            'request_user_id' => '1',
            'category_ids' => '["5"]',
            'main_title' => '運気の上がるアクセサリーが欲しい',
            'content' => '最近運気が悪いので・・・',
            'price' => '10000',
            'price_net' => '8500',
            'application_deadline' => '2023-05-30',
            'delivery_deadline' => '2023-05-30',
            'public_sign' => 'public',
            'status' => 'open_applications',
        ];
        DB::table('services')->insert($param);

        $param = [
            'request_user_id' => '2',
            'category_ids' => '["1"]',
            'main_title' => 'お墓掃除をして欲しいです',
            'content' => '私の代わりにお墓のお掃除、お供えをしてくださる人を募集します',
            'attention' => '納品時は写真を撮影して送って欲しいです',
            'price' => '20000',
            'price_net' => '17000',
            'application_deadline' => '2023-05-05',
            'delivery_deadline' => '2023-05-20',
            'area_id'=>'["18"]',
            'free'=> '宜しくお願いいたします',
            'public_sign' => 'public',
            'status' => 'open_applications',
        ];
        DB::table('services')->insert($param);

        $param = [
            'request_user_id' => '2',
            'category_ids' => '["2"]',
            'main_title' => '合格祈願のお守りを購入・郵送して欲しいです',
            'content' => '受験があるのですが、時間がなく購入しに行けないので・・・',
            'attention' => '詳細情報や郵送先はチャットでお伝えします',
            'price' => '10000',
            'price_net' => '8500',
            'application_deadline' => '2023-10-30',
            'delivery_deadline' => '2023-11-10',
            'area_id' => '["24", "25"]',
            'public_sign' => 'public',
            'status' => 'open_applications',
        ];
        DB::table('services')->insert($param);
    }
}
