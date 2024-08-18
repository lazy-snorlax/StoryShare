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
        Schema::table('chapters', function (Blueprint $table) {
            $table->integer('word_count')->after('content');
        });
        
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('word_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chapters', function (Blueprint $table) {
            $table->dropColumn('word_count');
        });
        
        Schema::table('stories', function (Blueprint $table) {
            $table->integer('word_count')->after('number_of_chapters');
        });
    }
};
