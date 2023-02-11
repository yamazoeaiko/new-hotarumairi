<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementsTableSeeder extends Seeder
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
            'description' => 'あなたの依頼に、応募がありました。',
            'partner_id' => '2',
            'read' => false
        ];
        DB::table('announcements')->insert($param);

        $param = [
            'user_id' => '1',
            'description' => 'メッセージを受け取りました。',
            'partner_id' => '3',
            'read' => false
        ];
        DB::table('announcements')->insert($param);
    }
}
