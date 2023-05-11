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
            $table->unsignedBigInteger('request_user_id')->nullable();
            $table->foreign('request_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('offer_user_id')->nullable();
            $table->foreign('offer_user_id')->references('id')->on('users');
            $table->enum('type', ['service', 'public_request', 'product'])->comment('サービスのタイプ');
            $table->json('category_ids')->nullable();
            $table->text('main_title')->comment('サービスのタイトル')->nullable();
            $table->text('content')->comment('サービスの詳細内容')->nullable();
            $table->string('photo_1')->nullable();
            $table->string('photo_2')->nullable();
            $table->string('photo_3')->nullable();
            $table->string('photo_4')->nullable();
            $table->string('photo_5')->nullable();
            $table->string('photo_6')->nullable();
            $table->string('photo_7')->nullable();
            $table->string('photo_8')->nullable();
            $table->text('attention')->comment('注意事項')->nullable();    
            $table->date('application_deadline')->nullable()->comment('応募締切日');
            $table->date('delivery_deadline')->nullable()->comment('納品締切日');
            $table->text('free')->nullable()->comment('自由記入欄');
            $table->json('area_id')->nullable();
            $table->decimal('price',8,0)->comment('税抜きの金額総額');
            $table->decimal('price_net',8,0)->nullable()->comment('納品者への振込額（手数料10%計算）');
            $table->enum('status',['open_applications', 'closed_applications','stopping'])->nullable();
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
