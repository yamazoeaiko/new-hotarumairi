<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'big_category' => 'お墓参り',
            'name' => 'お墓参り',
            'icon' => 'storage/images/category_icon_ohakamairi.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => 'お守り・お札・御朱印購入',
            'name' => 'お守り・お札・御朱印購入',
             'icon' => 'storage/images/category_icon_temple.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => '参拝・祈祷',
            'name' => '参拝・祈祷',
            'icon' => 'storage/images/category_icon_tanzaku.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => '占い',
            'name' => '占い',
            'icon' => 'storage/images/category_icon_uranai.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => 'その他',
            'name' => 'その他',
            'icon' => 'storage/images/category_icon_ishi.png'
        ];
        DB::table('service_categories')->insert($param);
    }
}
