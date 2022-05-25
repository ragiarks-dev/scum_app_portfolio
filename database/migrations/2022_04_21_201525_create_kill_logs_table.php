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
        Schema::create('kill_logs', function (Blueprint $table) {
            $table->id()->comment('キルログID');
            $table->string('killer_name')->nullable()->comment('殺害者');
            $table->string('victim_name')->nullable()->comment('犠牲者');
            $table->string('killer_steam_id')->comment('殺害者steamID');
            $table->string('victim_steam_id')->nullable()->comment('犠牲者steamID');
            $table->string('killer_latitude')->nullable()->comment('殺害者緯度(X)');
            $table->string('killer_longitude')->nullable()->comment('殺害者経度(Y)');
            $table->string('victim_latitude')->nullable()->comment('犠牲者緯度(X)');
            $table->string('victim_longitude')->nullable()->comment('犠牲者経度(Y)');
            $table->string('weapon')->nullable()->comment('使用武器');
            $table->dateTime('kill_time')->nullable()->comment('殺害時間');
            $table->tinyInteger('status')->default(0)->comment('ステータス[未読込: 0, 読込済み: 1]');
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
        Schema::dropIfExists('kill_logs');
    }
};
