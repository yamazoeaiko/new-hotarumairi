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
            $table->json('category_ids')->nullable();
            $table->text('main_title')->comment('出品サービスのタイトル')->nullable();
            $table->text('content')->comment('サービスの詳細内容')->nullable();
            $table->text('attention')->comment('注意事項')->nullable();
            $table->boolean('public_sign')->comment('trueなら公開する');
            $table->json('area_id')->nullable();
            $table->decimal('price',8,0)->comment('税抜きの金額総額');
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
