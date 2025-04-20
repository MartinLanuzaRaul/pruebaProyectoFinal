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
        Schema::create('servant_secretos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idServant'); // Clave foránea a servants:id
            $table->date('fecha'); 
            $table->foreign('idServant')->references('id')->on('servants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servant_secretos');
    }
};
