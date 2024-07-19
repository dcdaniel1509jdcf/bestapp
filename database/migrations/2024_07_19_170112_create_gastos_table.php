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
            $table->enum('concepto', ['movilizacion', 'suministros', 'gastos_varios']);
            $table->decimal('valor', 10, 2)->nullable();
            $table->text('detalle')->nullable();
            $table->string('numero_factura')->nullable();
            $table->string('comprobante');
            $table->enum('tipo_movilizacion', ['volanteo', 'notificacion', 'traslado_valores', 'traslado_mercaderia', 'traslado_personal'])->nullable();
            $table->string('destino')->nullable();
            $table->string('asignado_a')->nullable();

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
