<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OhakamairiSummaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '見回りのみ',
            'number' => '1'
        ];
        DB::table('ohakamairi_summaries')->insert($param);

        $param = [
            'name' => 'お掃除希望',
            'number' => '10'
        ];
        DB::table('ohakamairi_summaries')->insert($param);

        $param = [
            'name' => 'お参り希望',
            'number' => '100'
        ];
        DB::table('ohakamairi_summaries')->insert($param);

        $param = [
            'name' => '画像送付希望',
            'number' => '1000'
        ];
        DB::table('ohakamairi_summaries')->insert($param);

        $param = [
            'name' => '動画送付希望',
            'number' => '10000'
        ];
        DB::table('ohakamairi_summaries')->insert($param);

        $param = [
            'name' => '現地リアルタイムで通話希望',
            'number' => '100000'
        ];
        DB::table('ohakamairi_summaries')->insert($param);
    }
}
