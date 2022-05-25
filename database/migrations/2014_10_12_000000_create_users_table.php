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
            $table->id()->comment('ユーザーID');
            $table->string('user_name')->comment('ゲーム内ユーザー名');
            $table->string('steam_id')->unique()->comment('steamID');
            $table->string('login_id')->unique()->comment('ログインID');
            $table->string('password')->comment('パスワード');
            $table->tinyInteger('role')->default(0)->comment('権限[0: 一般, 管理者: 1, 最高管理者: 2]');
            $table->tinyInteger('status')->default(0)->comment('ステータス[-2: BAN, 制限: -1, 正常: 0]');
            $table->integer('cash')->default(0)->comment('ゲーム内現金');
            $table->rememberToken();
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
