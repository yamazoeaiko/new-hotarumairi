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
        Schema::create('applies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->foreign('request_id')->references('id')->on('hotaru_requests');
            $table->unsignedBigInteger('host_user');
            $table->foreign('host_user')->references('id')->on('users');
            $table->unsignedBigInteger('apply_user_id');
            $table->foreign('apply_user_id')->references('id')->on('users');
            $table->text('first_chat')->comment('応募する最初のメッセージ');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled']);
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
        Schema::dropIfExists('applies');
    }
};
