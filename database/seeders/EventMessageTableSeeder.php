<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventMessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'event_message' => 'チャットを受け取りました。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'あなたの代行依頼に、応募がありました。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => '作業完了の報告があります。ご確認ください。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'あなたの依頼が承諾されました。お支払いを実行して、正式に依頼が完了します。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'お支払いが完了しました。作業完了までお待ちください。細かなご指示はチャットでお願いします。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'あなたの応募に、依頼主から正式な依頼が届いています。承諾もしくはお断りを対応してください。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => '依頼主のお支払いが完了すると、正式に応募が承諾されたことになります'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => '依頼主のお支払いが完了しました。対応期日までに作業を完了し、「作業完了報告」をしてください。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'あなたの作業完了報告が承認されました。お疲れ様でした。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'あなたが応募した依頼は、依頼主によって削除されました。'
        ];
        DB::table('event_messages')->insert($param);

        $param = [
            'event_message' => 'あなたの応募は、承認の期限が切れたため無効となりました。'
        ];
        DB::table('event_messages')->insert($param);
    }
}
