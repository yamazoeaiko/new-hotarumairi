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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('お知らせするユーザーID');
            $table->text('description')->comment('お知らせ：内容');
            $table->unsignedBigInteger('partner_id')->comment('相手のユーザーID')->nullable();
            $table->boolean('read')->default(false)->comment('未読 or 既読');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('partner_id')->references('id')->on('users');
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
        Schema::dropIfExists('announcements');
    }
};
