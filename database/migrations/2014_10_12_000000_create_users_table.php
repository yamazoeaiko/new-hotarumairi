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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('nickname')->comment('サービス内表記名')->nullable();
            $table->string('trade_name')->nullable()->comment('屋号');
            $table->integer('gender')->comment('性別')->nullable();
            $table->date('birthday')->comment('誕生日')->nullable()->default('1980-01-01');
            $table->unsignedBigInteger('living_area')->comment('住まいの都道府県')->nullable();
            $table->foreign('living_area')->references('id')->on('areas');
            $table->text('message')->comment('一言、自己紹介')->nullable();
            $table->string('img_url')->comment('プロフィール画像')->default('storage/profile/no_image.jpg')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('others_sns_url')->nullable();
            $table->enum('type', ['user', 'admin']);
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
        Schema::dropIfExists('users');
    }
};
