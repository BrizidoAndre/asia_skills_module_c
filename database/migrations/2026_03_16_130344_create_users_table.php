<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('username');
            $table->string('password_hash');
            $table->string('email');
            $table->enum('role', ['admin', 'publisher', 'user']);
            $table->boolean('is_banned');
            $table->string('token')->nullable();
            $table->timestamps();
            $table->unique(['username'], 'username');
            $table->unique(['email'], 'email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
