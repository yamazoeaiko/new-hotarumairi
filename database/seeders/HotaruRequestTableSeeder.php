<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotaruRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'request_user_id' => '2',
            'plan_id' => '2',
            'date_begin' => '2023-2-1',
            'date_end' =>'2023-3-31',
            'price' => '10000',
            'area_id' => '16',
            'address' => 'A県A区1-1-1',
            'spot' => 'A神社',
            'amulet' => '合格祈願',
            'praying'=> '合格をお祈りください',
            'goshuin' => '1',
            'free' =>'宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);

        $param = [
            'request_user_id' => '3',
            'plan_id' => '1',
            'date_begin' => '2023-3-1',
            'date_end' => '2023-4-15',
            'price' => '6000',
            'area_id' => '20',
            'ohakamairi_sum' => '10000010',
            'address' => 'B県B区1-1-1',
            'spot' => 'B寺',
            'offering' => '花を２束',
            'cleaning' => '雑草を取り、墓石を流水でお願いします',
            'free' => '宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);

        $param = [
            'request_user_id' => '1',
            'plan_id' => '3',
            'date_begin' => '2023-1-28',
            'date_end' => '2023-2-20',
            'price' => '15000',
            'area_id' => '29',
            'address' => 'C県C区1-1-1',
            'spot' => 'C神社',
            'praying' => '健康をお祈りください',
            'goshuin' => '3',
            'free' => '宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);
    }
}
