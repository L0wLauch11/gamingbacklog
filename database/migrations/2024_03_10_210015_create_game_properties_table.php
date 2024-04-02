<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_properties', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('game_id');
            $table->integer('status')->nullable();
            $table->integer('playtime')->nullable();
            $table->integer('played_on_platform')->nullable();
            $table->integer('started_playing_at')->nullable();
            $table->integer('ended_playing_at')->nullable();
            $table->integer('given_score')->default(0);
            $table->boolean('recommends')->default(0);
            $table->boolean('favourite')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_properties');
    }
};
