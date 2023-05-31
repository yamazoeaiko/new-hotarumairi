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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buy_user')->nullable();
            $table->foreign('buy_user')->references('id')->on('users');
            $table->unsignedBigInteger('sell_user')->nullable();
            $table->foreign('sell_user')->references('id')->on('users');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('entry_id')->nullable();
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->text('main_title')->comment('サービスのタイトル')->nullable();
            $table->text('content')->comment('サービスの詳細内容')->nullable();
            $table->decimal('price', 8, 0)->comment('税抜きの金額総額');
            $table->decimal('price_net', 8, 0)->nullable()->comment('納品者への振込額（手数料10%計算）');
            $table->date('delivery_deadline')->nullable()->comment('納品締切日');
            $table->text('free')->nullable()->comment('自由記入欄');
            $table->enum('status', ['pending', 'paid','unapproved', 'cancel_pending','canceled'])->nullable();
            $table->string('session_id')->comment('stripeのID')->nullable();
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
        Schema::dropIfExists('agreements');
    }
};
