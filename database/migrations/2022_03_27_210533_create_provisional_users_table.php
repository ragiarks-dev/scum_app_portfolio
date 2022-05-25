<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *-
     * @return void
     */
    public function up()
    {
        Schema::create('provisional_users', function (Blueprint $table) {
            $table->id()->comment('仮登録ID');
            $table->string('login_id')->comment('ログインID');
            $table->string('password')->comment('パスワード');
            $table->string('key')->comment('鍵');
            $table->tinyInteger('status')->default(0)->comment('ステータス[-2: 使用済み, 制限: 期限切れ, 正常: 0]');
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
        Schema::dropIfExists('provisional_users');
    }
};
