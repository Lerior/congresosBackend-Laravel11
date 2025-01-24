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
        Schema::table('congresos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Agregar columna
            $table->foreign('user_id')             // Definir clave foránea
                  ->references('id')                  // Campo referenciado
                  ->on('users')            // Tabla referenciada
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('congresos', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Eliminar clave foránea
            $table->dropColumn('user_id'); 
        });
    }
};
