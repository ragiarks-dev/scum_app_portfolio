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
        Schema::create('log_files', function (Blueprint $table) {
            $table->id()->comment('ログファイルID');
            $table->string('file_name')->comment('ファイル名');
            $table->string('file_type')->comment('ファイルの種類[login, admin, chat, kill, violations, mines]');
            $table->dateTime('file_date')->comment('ログファイルの作成日時');
            $table->string('last_row')->default(0)->comment('最終読み込み行');
            $table->string('status')->default(0)->comment('ステータス[-1: 無効, 0: 有効]');
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
        Schema::dropIfExists('log_files');
    }
};
