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
    Schema::create('stats', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('idUser'); // foreign key usuarios:id
        $table->integer('currentStreak')->default(0); 
        $table->integer('totalTries')->default(0);
        $table->unsignedBigInteger('min_tries_servant')->nullable(); // Cforeign key servants:id
        $table->integer('min_tries_count')->nullable(); 
        $table->integer('total_guesses')->default(0); 
        $table->timestamps();

        // foreign keys
        $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('min_tries_servant')->references('id')->on('servants')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
