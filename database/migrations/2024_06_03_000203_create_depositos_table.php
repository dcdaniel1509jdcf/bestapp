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
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Cambiado a unsignedBigInteger
            $table->unsignedBigInteger('agencia_id');  // Cambiado a unsignedBigInteger
            $table->date('fecha');
            $table->text('apellidos');
            $table->text('nombres');
            $table->text('num_documento');
            $table->text('origen');
            $table->decimal('val_deposito', 10, 2);
            $table->text('comprobante')->nullable();
            $table->text('banco')->nullable();
            $table->text('num_credito')->nullable();
            $table->text('tesoreria')->nullable();

            $table->unsignedBigInteger('user_tesoreria')->nullable();  // Cambiado a unsignedBigInteger
            $table->text('cajas')->nullable();
            $table->text('baja')->nullable();
            $table->text('novedad')->nullable();
            $table->text('doc_banco')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Agregar claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agencia_id')->references('id')->on('agencias')->onDelete('cascade');
            $table->foreign('user_tesoreria')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('depositos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['agencia_id']);
            $table->dropForeign(['user_tesoreria']);
        });
        Schema::dropIfExists('depositos');
    }
};
