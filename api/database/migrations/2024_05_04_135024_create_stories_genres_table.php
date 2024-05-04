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
        Schema::create('stories_genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id')->unsigned();
            $table->unsignedBigInteger('genre_id')->unsigned();
            
            $table->foreign('story_id')->references('id')->on('stories');
            $table->foreign('genre_id')->references('id')->on('genres');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_genres');
    }
};
