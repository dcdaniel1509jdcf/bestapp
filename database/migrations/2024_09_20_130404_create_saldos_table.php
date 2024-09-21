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
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_saldo');
            $table->decimal('monto_asignado', 10, 2)->nullable();
            $table->date('fecha_comprobante')->nullable();
            $table->string('numero_recibo_factura');
            $table->string('comprobante')->nullable();
            $table->decimal('valor', 10, 2);
            $table->string('numero_factura')->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldos');
    }
};
