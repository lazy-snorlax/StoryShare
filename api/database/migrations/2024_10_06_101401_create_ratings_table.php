<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        $models = array(
            array('name' => 'General', 'active' => true, 'description' => 'For general audiences', 'created_at' => now()),
            array('name' => 'Teen', 'active' => true, 'description' => 'Teens', 'created_at' => now()),
            array('name' => 'Young Adult', 'active' => true, 'description' => 'Aimed for young adults', 'created_at' => now()),
            array('name' => 'Mature', 'active' => true, 'description' => 'For mature theme', 'created_at' => now()),
            array('name' => 'Explicit', 'active' => true, 'description' => 'Graphic Violence or Sex scences should go here', 'created_at' => now()),
        );

        DB::table('ratings')->insert($models);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
