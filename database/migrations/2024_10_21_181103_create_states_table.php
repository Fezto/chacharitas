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
        Schema::create('states', function (Blueprint $table) {
            $table->integer('id')->unsigned(); // Usar integer en lugar de id() para un id sin auto-incremento
            $table->string('name', 50)->charset('utf8')->collation('utf8_unicode_ci')->default(''); // Nombre del estado
            $table->integer('country_id')->unsigned()->default(0); // Campo de país
            $table->index('country_id'); // Índice para el campo country_id
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade'); // Clave foránea para country_id

            // Definir el id como clave primaria manualmente
            $table->primary('id');

            // Establecer charset y collation para la tabla
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
