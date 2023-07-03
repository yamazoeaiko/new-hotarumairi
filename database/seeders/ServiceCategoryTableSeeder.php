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
            'icon' => 'storage/images/using_icon_hakamairi.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => 'お守り・お札・御朱印購入',
            'name' => 'お守り・お札・御朱印購入',
             'icon' => 'storage/images/using_icon_omamorikounyuu.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => '参拝・祈祷',
            'name' => '寺・神社参拝',
            'icon' => 'storage/images/using_icon_terajinjamairi.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => '占い',
            'name' => '占い',
            'icon' => 'storage/images/using_icon_uranai.png'
        ];
        DB::table('service_categories')->insert($param);

        $param = [
            'big_category' => 'その他スキル販売',
            'name' => 'その他スキル販売',
            'icon' => 'storage/images/using_icon_sonota.png'
        ];
        DB::table('service_categories')->insert($param);
    }
}
