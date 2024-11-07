<?php

use App\Models\Municipality;
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
            $table->id(); // Usar integer en lugar de id() para un id sin auto-incremento
            $table->string('name', 100)->collation('utf8_unicode_ci')->default(''); // Nombre del vecindario
            $table->string('city', 50)->nullable(); // Nombre de la ciudad
            $table->foreignIdFor(Municipality::class); // Foreign key para el municipio
            $table->string('settlement', 25)->nullable(); // Nombre del asentamiento
            $table->integer('postal_code')->nullable(); // Código postal

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
