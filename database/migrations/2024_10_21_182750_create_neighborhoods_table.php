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
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->integer('id')->unsigned(); // Usar integer en lugar de id() para un id sin auto-incremento
            $table->string('name', 100)->collation('utf8_unicode_ci')->default(''); // Nombre del vecindario
            $table->string('city', 50)->nullable(); // Nombre de la ciudad
            $table->integer('municipality_id')->unsigned()->nullable(); // Foreign key para el municipio
            $table->string('settlement', 25)->nullable(); // Nombre del asentamiento
            $table->integer('postal_code')->nullable(); // Código postal

            // Índices para los campos
            $table->index('municipality_id'); // Índice para el campo municipio
            $table->index('name'); // Índice para el campo nombre
            $table->index('settlement'); // Índice para el campo asentamiento
            $table->index('postal_code'); // Índice para el campo código postal
            $table->index('city'); // Índice para el campo ciudad

            // Clave foránea para el municipio
            $table->foreign('municipality_id')->references('id')->on('municipalities')->onDelete('cascade')->onUpdate('cascade');

            // Definir id como clave primaria manualmente
            $table->primary('id');

            // Definir charset y collation para la tabla
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neighborhoods');
    }
};
