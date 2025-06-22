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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('two_factor_required')->nullable()->after('email_verified_at');
            $table->string('two_factor_method_enabled')->nullable()->after('email_verified_at');
            $table->string('two_factor_method_preferred')->nullable()->after('email_verified_at');
            $table->string('two_factor_secret')->nullable()->after('email_verified_at');
            $table->timestamp('terms_agreed_at')->nullable()->after('email_verified_at');
            $table->timestamp('privacy_policy_agreed_at')->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('two_factor_required');
            $table->dropColumn('two_factor_method_enabled');
            $table->dropColumn('two_factor_method_preferred');
            $table->dropColumn('two_factor_method_secret');
            $table->dropColumn('terms_agreed_at');
            $table->dropColumn('privacy_policy_agreed_at');
        });
    }
};
