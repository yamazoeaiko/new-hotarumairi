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
            'price_net' => '8500',
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
            'price_net' => '5100',
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
            'price_net' => '12750',
            'area_id' => '29',
            'address' => 'C県C区1-1-1',
            'sanpai_sum' => '10000111',
            'spot' => 'C神社',
            'praying' => '健康をお祈りください',
            'goshuin' => '0',
            'free' => '宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);

        $param = [
            'request_user_id' => '4',
            'plan_id' => '1',
            'date_begin' => '2023-4-1',
            'date_end' => '2023-4-15',
            'price' => '16000',
            'price_net' => '13600',
            'area_id' => '20',
            'ohakamairi_sum' => '10001010',
            'address' => 'B県B区1-1-1',
            'spot' => 'T寺',
            'offering' => '花',
            'cleaning' => '雑草を取ってください',
            'free' => '宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);

        $param = [
            'request_user_id' => '3',
            'plan_id' => '3',
            'date_begin' => '2023-2-20',
            'date_end' => '2023-2-25',
            'price' => '19000',
            'price_net' => '16150',
            'area_id' => '24',
            'address' => 'C県C区1-1-1',
            'sanpai_sum' => '10001101',
            'spot' => 'C神社',
            'praying' => '健康をお祈りください',
            'goshuin' => '0',
            'free' => '宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);

        $param = [
            'request_user_id' => '2',
            'plan_id' => '2',
            'date_begin' => '2023-3-10',
            'date_end' => '2023-3-25',
            'price' => '30000',
            'price_net' => '25500',
            'area_id' => '19',
            'address' => 'A県A区1-1-1',
            'spot' => 'A神社',
            'amulet' => '合格祈願',
            'praying' => '合格をお祈りください',
            'goshuin' => '1',
            'free' => '宜しくお願いいたします',
            'status_id' => '1'
        ];
        DB::table('hotaru_requests')->insert($param);
    }
}
