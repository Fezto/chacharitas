<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->integer('id')->unsigned(); // Usar integer en lugar de increments
            $table->string('name', 50)->charset('utf8')->collation('utf8_unicode_ci')->default(''); // Nombre del país
            $table->timestamps();

            // También puedes agregar el primary key manualmente si necesitas
            $table->primary('id'); // Establece 'id' como clave primaria sin auto-incremento
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
