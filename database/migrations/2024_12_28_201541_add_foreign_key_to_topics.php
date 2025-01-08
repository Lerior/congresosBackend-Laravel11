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
        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedBigInteger('congress_id')->nullable(); // Agregar columna
            $table->foreign('congress_id')             // Definir clave foránea
                  ->references('id')                  // Campo referenciado
                  ->on('congresos')            // Tabla referenciada
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['congress_id']); // Eliminar clave foránea
            $table->dropColumn('congress_id');   // Eliminar columna
        });
    }
};
