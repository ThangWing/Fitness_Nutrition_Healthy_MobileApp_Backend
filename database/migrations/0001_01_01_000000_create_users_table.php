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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('login_id');

            $table->foreign('login_id')->references('id')->on('login')->onDelete('cascade');
        });
    }        
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
