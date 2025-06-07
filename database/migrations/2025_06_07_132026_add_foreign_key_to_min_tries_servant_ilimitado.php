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
        $table->foreign('min_tries_servant_ilimitado')
              ->references('id')->on('servants')
              ->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('stats', function (Blueprint $table) {
        $table->dropForeign(['min_tries_servant_ilimitado']);
    });
}
};
