<?php

use App\Models\State;
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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id(); // Usar integer en lugar de id() para un id sin auto-incremento
            $table->string('name', 50)->charset('utf8')->collation('utf8_unicode_ci')->default(''); // Nombre del municipio
            $table->foreignIdFor(State::class)->default(0);

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
        Schema::dropIfExists('municipalities');
    }
};
