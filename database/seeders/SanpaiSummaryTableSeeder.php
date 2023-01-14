<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SanpaiSummaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '現地画像が必要',
            'number' => '1'
        ];
        DB::table('sanpai_summaries')->insert($param);

        $param = [
            'name' => '(祈祷)音声が必要',
            'number' => '10'
        ];
        DB::table('sanpai_summaries')->insert($param);

        $param = [
            'name' => 'リアルタイムで音声を聞きたい',
            'number' => '100'
        ];
        DB::table('sanpai_summaries')->insert($param);

        $param = [
            'name' => '実行の報告だけで良い',
            'number' => '1000'
        ];
        DB::table('sanpai_summaries')->insert($param);
    }
}