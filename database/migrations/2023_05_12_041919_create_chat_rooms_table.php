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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('entry_id')->nullable();
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->foreign('agreement_id')->references('id')->on('agreements');
            $table->unsignedBigInteger('buy_user');
            $table->foreign('buy_user')->references('id')->on('users');
            $table->unsignedBigInteger('sell_user');
            $table->foreign('sell_user')->references('id')->on('users');
            $table->enum('status', ['paid','stopping', 'deleted'])->nullable();
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
        Schema::dropIfExists('chat_rooms');
    }
};
