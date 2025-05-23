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
        Schema::create('muctieu', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger ('user_id');
            $table->string('goal_type', 50);
            $table->decimal('target_value', 8, 2);
            $table->decimal('progress', 8, 2);
            $table->date('deadline');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muctieu');
    }
};
