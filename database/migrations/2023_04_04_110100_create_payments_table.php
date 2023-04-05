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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('entry_id');
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->unsignedBigInteger('buy_user');
            $table->foreign('buy_user')->references('id')->on('users');
            $table->unsignedBigInteger('sell_user');
            $table->foreign('sell_user')->references('id')->on('users');
            $table->decimal('price', 8, 0)->comment('税抜き金額');
            $table->decimal('include_tax_price', 8, 0)->comment('税込金額');
            $table->decimal('commission', 8, 0)->comment('手数料');
            $table->string('session_id');
            $table->string('payment_intent');
            $table->decimal('cancel_fee', 8, 0)->comment('運営側が受け取るキャンセル料（残りは返金）')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
