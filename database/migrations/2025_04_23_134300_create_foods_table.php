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
        Schema::create('doan', function (Blueprint $table) {
            $table->id('id');
            $table->string('name_food');
            $table->decimal('calories_per_100g', 6, 2);
            $table->string('image_url')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doan');
    }
};
