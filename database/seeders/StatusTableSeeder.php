<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '応募者を募集しています'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '応募者が確定しました。現在募集を受け付けておりません。'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => 'お支払い手続き完了'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '依頼者のキャンセル意向あり'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '依頼者の意向によるキャンセル'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '応募者のキャンセル意向あり'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '応募者の意向によるキャンセル'
        ];
        DB::table('statuses')->insert($param);

        $param = [


            'name' => '依頼内容完了の報告待ち'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '完了報告への承認待ち'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '依頼報告への承認完了（評価待ち）'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '評価報告完了(全て終了)'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '管理者から応募者への支払い待ち'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '管理者から応募者への支払い完了'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '管理者から依頼者へのキャンセル費支払い待ち'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => '管理者から依頼者へのキャンセル日支払い完了'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'name' => 'リクエスト削除完了'
        ];
        DB::table('statuses')->insert($param);
    }
}
