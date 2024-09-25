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
            $table->string('inicio_destino')->nullable();
            $table->string('fin_destino')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropColumn('inicio_destino');
            $table->dropColumn('fin_destino');
            $table->dropColumn('subtotal');
        });
    }
};
