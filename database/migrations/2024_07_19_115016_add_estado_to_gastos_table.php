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
        Schema::table('gastos', function (Blueprint $table) {
            $table->enum('estado', ['En Espera', 'Autorizado', 'Rechazado'])->default('En Espera');
            $table->text('novedad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('novedad');
        });
    }
};
