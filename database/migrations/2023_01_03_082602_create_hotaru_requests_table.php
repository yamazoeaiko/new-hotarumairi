<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotaru_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_user_id')->comment('依頼者ID');
            $table->foreign('request_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->date('date_begin')->comment('実施希望日（始まり）');
            $table->date('date_end')->comment('実施希望日（終わり）');
            $table->integer('price')->comment('報酬額(税抜き)');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->string('address')->comment('対象施設の住所')->nullable();
            $table->string('spot')->comment('神社・お墓などの名称')->nullable();
            $table->text('offering')->nullable()->comment('お供え物');
            $table->text('cleaning')->nullable()->comment('清掃内容');
            $table->text('amulet')->nullable()->comment('お守り');
            $table->text('praying')->nullable()->comment('祈願内容');
            $table->integer('goshuin')->nullable()->comment('御朱印');
            $table->text('free')->nullable()->comment('その他要望');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->text('free_title')->comment('プランがフリーの場合の依頼内容')->nullable();
            $table->text('free_detail')->comment('フリーの依頼内容の詳細')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotaru_requests');
    }
};
