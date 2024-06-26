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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Cambiado a unsignedBigInteger
            $table->unsignedBigInteger('agencia_id');  // Cambiado a unsignedBigInteger
            $table->date('fecha');
            $table->text('agencia');
            $table->text('concepto');

            $table->decimal('valor', 10, 2);
            $table->text('observacion')->nullable();
            $table->text('fondo')->nullable();
            $table->text('comprobante')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Agregar claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agencia_id')->references('id')->on('agencias')->onDelete('cascade');
            //$table->foreign('user_tesoreria')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['agencia_id']);
            //$table->dropForeign(['user_tesoreria']);
        });
        Schema::dropIfExists('gastos');
    }
};
