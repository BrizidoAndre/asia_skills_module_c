<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->integer('song_id');
            $table->foreignId('album_id')->nullable();
            $table->string('title');
            $table->integer('duration_seconds')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->integer('is_cover');
            $table->text('lyrics')->nullable();
            $table->integer('track_order')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['album_id'], 'album_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('songs');
    }
};
