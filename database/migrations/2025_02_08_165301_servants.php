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
        Schema::create('servants', function (Blueprint $table) {
            $table->id();
            $table->string('servantId');
            $table->string('name');
            $table->string('gender');
            $table->string('className');
            $table->string('rarity');
            $table->string('attribute');
            $table->string('atkBase');
            $table->string('hpBase');
            $table->string('img');
            $table->string('noblePhantasmCard');
            $table->string('noblePhantasmEffect');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servants');
    }
};
