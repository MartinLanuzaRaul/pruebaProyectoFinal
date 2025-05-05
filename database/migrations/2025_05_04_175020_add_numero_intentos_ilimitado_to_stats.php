<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('stats', function (Blueprint $table) {
        $table->boolean('numeroIntentosIlimitado')->default(false);
        $table->integer('Unlimited_total_guesses')->nullable();
    });
}

public function down()
{
    Schema::table('stats', function (Blueprint $table) {
        $table->dropColumn(['numeroIntentosIlimitado', 'Unlimited_total_guesses']);
    });
}

};
