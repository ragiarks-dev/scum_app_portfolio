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
        Schema::create('reports', function (Blueprint $table) {
            $table->id()->comment('報告ID');
            $table->string('type')->comment('報告種類');
            $table->text('detail')->comment('報告内容');
            $table->bigInteger('from_id')->nullable()->comment('報告者ID');
            $table->bigInteger('to_id')->nullable()->comment('報告対象者ID');
            $table->tinyInteger('status')->default(0)->comment('ステータス[-1: 削除済, 未確認: 0, 確認済: 1]');
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
        Schema::dropIfExists('reports');
    }
};
