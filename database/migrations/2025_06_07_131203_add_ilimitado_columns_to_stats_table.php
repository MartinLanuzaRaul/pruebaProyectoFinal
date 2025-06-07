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
        $table->integer('min_tries_count_ilimitado')->nullable();
        $table->integer('min_tries_servant_ilimitado')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('stats', function (Blueprint $table) {
        $table->dropColumn('min_tries_count_ilimitado');
        $table->dropColumn('min_tries_servant_ilimitado');
    });
}

};
