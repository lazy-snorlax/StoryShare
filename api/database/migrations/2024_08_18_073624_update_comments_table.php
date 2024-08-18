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
        Schema::table('comments', function (Blueprint $table) {
            $table->bigInteger('parent_id')->unsigned()->change();
            $table->bigInteger('user_id')->unsigned()->change();
            $table->bigInteger('approved_by')->unsigned()->change();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('parent_id')->change();
            $table->integer('user_id')->change();
            $table->integer('approved_by')->change();

            $table->dropForeign('user_id')->references('id')->on('users');
        });
    }
};
