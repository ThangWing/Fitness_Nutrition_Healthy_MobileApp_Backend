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
        Schema::create('baitap', function (Blueprint $table) {
            $table->id('id');
            $table->string('name_exercise');
            $table->decimal('mets', 4, 2);
            $table->string('image_url')->nullable();
        });

        Schema::create('buoitap', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger ('user_id');
            $table->decimal('calories_burned', 8, 2);
            $table->date('date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('ctbuoitap', function (Blueprint $table) {
            $table->unsignedBigInteger ('buoitapid');
            $table->unsignedBigInteger ('baitap_id');
            $table->integer('duration');
            $table->foreign('buoitapid')->references('id')->on('buoitap')->onDelete('cascade');
            $table->foreign('baitap_id')->references('id')->on('baitap')->onDelete('cascade');
            $table->primary(['buoitapid', 'baitap_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctbuoitap');
        Schema::dropIfExists('buoitap');
        Schema::dropIfExists('baitap');
    }
};
