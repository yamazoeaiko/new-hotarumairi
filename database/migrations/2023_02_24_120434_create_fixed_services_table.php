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
        Schema::create('fixed_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('consult_id');
            $table->foreign('consult_id')->references('id')->on('service_consults');
            $table->unsignedBigInteger('host_user');
            $table->foreign('host_user')->references('id')->on('users');
            $table->unsignedBigInteger('buy_user');
            $table->foreign('buy_user')->references('id')->on('users');
            $table->string('main_title')->nullable();
            $table->integer('price');
            $table->text('content')->nullable();
            $table->date('date_end')->nullable();
            $table->boolean('estimate')->comment('trueなら正式な見積もり送付済み')->nullable()->default(false);
            $table->boolean('contract')->comment('trueなら契約成立')->nullable()->default(false);
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
        Schema::dropIfExists('fixed_services');
    }
};
