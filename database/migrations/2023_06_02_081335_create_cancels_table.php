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
        Schema::create('cancels', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['pending', 'approved', 'unapproved']);
            $table->unsignedBigInteger('agreement_id');
            $table->foreign('agreement_id')->references('id')->on('agreements');
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->enum('refund',['refunded', 'will_refund', 'not_haveto_refund'])->nullable();
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
        Schema::dropIfExists('cancels');
    }
};
