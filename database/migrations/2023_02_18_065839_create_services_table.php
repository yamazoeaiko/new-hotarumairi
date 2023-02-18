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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->json('category_ids');
            $table->text('main_title')->comment('出品サービスのタイトル');
            $table->text('content')->comment('サービスの詳細内容');
            $table->text('attention')->comment('注意事項')->nullable();
            $table->boolean('public_sign')->comment('trueなら公開する');
            $table->decimal('price',8,0)->comment('税抜きの金額総額');
            $table->decimal('price_net',8,0)->comment('報酬受け取る側が受け取る金額（ネット）');
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
        Schema::dropIfExists('services');
    }
};
