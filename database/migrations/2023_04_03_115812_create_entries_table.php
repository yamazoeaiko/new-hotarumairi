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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('buy_user')->comment('支払い者');
            $table->foreign('buy_user')->references('id')->on('users');
            $table->unsignedBigInteger('sell_user')->comment('サービス実行者');
            $table->foreign('sell_user')->references('id')->on('users');
            $table->enum('status',['pending', 'estimate', 'unapprovced', 'paid', 'delivery_pending','delivery_complete','evaluated','closed', 'cancel_pending','canceled' ]);
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
        Schema::dropIfExists('entries');
    }
};
