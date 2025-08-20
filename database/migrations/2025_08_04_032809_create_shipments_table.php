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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            
            // Información del envío
            $table->string('tracking_number')->unique()->nullable();
            $table->string('fedex_shipment_id')->nullable();
            $table->string('service_type')->default('FEDEX_GROUND');
            $table->enum('status', ['pending', 'created', 'in_transit', 'delivered', 'exception', 'cancelled'])->default('pending');
            
            // Costos
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            
            // URLs y documentos
            $table->text('label_url')->nullable();
            $table->text('label_pdf_path')->nullable();
            
            // Direcciones
            $table->json('sender_address');
            $table->json('recipient_address');
            
            // Datos del paquete
            $table->decimal('weight', 8, 2)->default(1.0);
            $table->json('dimensions')->nullable();
            
            // Fechas importantes
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('estimated_delivery')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            // Metadatos
            $table->json('fedex_response')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index(['seller_id', 'status']);
            $table->index(['buyer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
