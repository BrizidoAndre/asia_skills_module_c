<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_view_logs', function (Blueprint $table) {
            $table->integer('user_view_log_id');
            $table->foreignId('user_id');
            $table->foreignId('song_id');
            $table->index(['user_id'], 'user_id');
            $table->index(['song_id'], 'song_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_view_logs');
    }
};
