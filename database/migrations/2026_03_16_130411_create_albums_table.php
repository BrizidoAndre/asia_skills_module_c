<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->integer('album_id');
            $table->foreignId('publisher_id');
            $table->string('title');
            $table->string('artist');
            $table->year('release_year')->nullable();
            $table->string('genre')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['publisher_id'], 'publisher_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('albums');
    }
};
