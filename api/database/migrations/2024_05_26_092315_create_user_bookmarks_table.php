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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            
            $table->boolean('private');
            $table->text('notes');

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('story_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('story_id')->references('id')->on('stories');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
