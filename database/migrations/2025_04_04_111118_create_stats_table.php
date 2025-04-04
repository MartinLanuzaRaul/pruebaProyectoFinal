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
            $table->unsignedBigInteger('idUser'); // Clave foránea a usuarios:id
            $table->integer('currentStreak')->default(0); 
            $table->integer('totalTries')->default(0);
            $table->unsignedBigInteger('min_tries_servant')->nullable(); // Clave foránea a servants:id, nullable si no hay servant asignado
            $table->timestamps();

            // Relaciones de claves foráneas
            $table->foreign('idUser')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('min_tries_servant')->references('id')->on('servants')->onDelete('set null'); // Eliminación en cascada o establecer a null si se borra un servant
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
