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
            $table->integer('room_id')->comment('ユーザーIDを照準に並べたもの');
            $table->unsignedBigInteger('apply_id')->nullable();
            $table->foreign('apply_id')->references('id')->on('applies');
            $table->unsignedBigInteger('consult_id')->nullable();
            $table->foreign('consult_id')->references('id')->on('service_consults');
            $table->unsignedBigInteger('user_id_one')->comment('片方のユーザーID');
            $table->foreign('user_id_one')->references('id')->on('users');
            $table->unsignedBigInteger('user_id_another')->comment('もう一方のユーザーID');
            $table->foreign('user_id_another')->references('id')->on('users');

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
