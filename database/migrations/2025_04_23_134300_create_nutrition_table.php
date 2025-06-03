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
        Schema::create('buaan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger ('user_id');
            $table->decimal('calories', 8, 2)->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });   

        Schema::create('ctbuaan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger ('buaan_id');
            $table->unsignedBigInteger ('doan_id');
            $table->decimal('quantity', 8, 2);
            $table->timestamps();

            $table->foreign('buaan_id')->references('id')->on('buaan')->onDelete('cascade');
            $table->foreign('doan_id')->references('id')->on('doan')->onDelete('cascade');
        });     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctbuaan');
        Schema::dropIfExists('buaan');
    }
};
