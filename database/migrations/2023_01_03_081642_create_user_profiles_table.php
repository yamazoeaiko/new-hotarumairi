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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nickname')->comment('サービス内表記名');
            $table->unsignedBigInteger('gender')->comment('性別');
            $table->foreign('gender')->references('id')->on('genders');
            $table->date('birthday')->comment('誕生日');
            $table->unsignedBigInteger('living_area')->comment('住まいの都道府県');
            $table->foreign('living_area')->references('id')->on('areas');
            $table->text('message')->comment('一言、自己紹介');
            $table->string('img_url')->comment('プロフィール画像')->default('storage/profile/no_image.jpg');
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
        Schema::dropIfExists('user_profiles');
    }
};
