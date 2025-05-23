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
        Schema::create('dinhduong', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger ('user_id');
            $table->string('meal_type', 20);
            $table->decimal('calories', 8, 2);
            $table->date('date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });   

        Schema::create('dinhduong_doan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger ('dinhduong_id');
            $table->unsignedBigInteger ('doan_id');
            $table->decimal('quantity', 8, 2);
            $table->date('date');
            $table->timestamps();

            $table->foreign('dinhduong_id')->references('id')->on('dinhduong')->onDelete('cascade');
            $table->foreign('doan_id')->references('id')->on('doan')->onDelete('cascade');
        });     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinhduong_doan');
        Schema::dropIfExists('dinhduong');
    }
};
