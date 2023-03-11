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
        Schema::create('service_consults', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('host_user');
            $table->foreign('host_user')->references('id')->on('users');
            $table->unsignedBigInteger('consulting_user');
            $table->foreign('consulting_user')->references('id')->on('users');
            $table->text('first_chat');
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
        Schema::dropIfExists('service_consults');
    }
};
