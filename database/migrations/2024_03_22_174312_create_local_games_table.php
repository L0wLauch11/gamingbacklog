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
        Schema::create('local_games', function (Blueprint $table) {
            $table->id();
            $table->integer('igdb_id');
            $table->text('slug');
            $table->text('name');
            $table->text('cover_id')->nullable();
            $table->text('release_date')->nullable();
            $table->text('description')->nullable();
            $table->text('developers')->nullable();
            $table->text('platforms')->nullable();
            $table->text('genres')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_games');
    }
};
