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
            $table->string('agencia');
            $table->text('detalle')->nullable();
            $table->decimal('valor', 10, 2);
            $table->date('fecha')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('concepto')->nullable();

            // Campos para "tramites_entidades"
            $table->string('tipo_tramite')->nullable();
            $table->string('nombre_tramite')->nullable();
            $table->string('nombre_entidad')->nullable();

            // Campos para "movilizacion"
            $table->string('movilizacion_tipo')->nullable();
            $table->string('viaticos')->nullable();
            $table->string('combustible')->nullable();
            $table->string('destino')->nullable();
            $table->string('asignado')->nullable();
            $table->string('tipo_pasajes')->nullable();
            $table->string('subtipo_pasajes')->nullable();
            $table->string('tipo_fletes')->nullable();
            $table->string('detalle_flete')->nullable();
            $table->string('movilizacion_destino')->nullable();
            $table->string('movilizacion_asignado')->nullable();
            $table->text('movilizacion_detalle')->nullable();

            // Archivo del comprobante
            $table->string('comprobante')->nullable();
            $table->text('novedad')->nullable();

            // Relación con usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
