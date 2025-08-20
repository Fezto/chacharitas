<x-base>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">📦 Envío #{{ $shipment->id }}</h1>
                        <p class="text-blue-100 mt-2">{{ $shipment->product->name }}</p>
                    </div>
                    <div class="text-right">
                        <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                            <div class="text-sm text-blue-100">Estado</div>
                            <div class="font-bold text-lg">{{ $shipment->status_text }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Información del Envío -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Información del Envío</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                @if($shipment->tracking_number)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Número de Rastreo:</span>
                                        <span class="font-mono font-bold text-blue-600">{{ $shipment->tracking_number }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Servicio:</span>
                                    <span class="font-medium">{{ $shipment->service_type }}</span>
                                </div>
                                
                                @if($shipment->shipping_cost)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Costo de Envío:</span>
                                        <span class="font-bold text-green-600">${{ number_format($shipment->shipping_cost, 2) }} {{ $shipment->currency }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Peso:</span>
                                    <span class="font-medium">{{ $shipment->weight }} kg</span>
                                </div>
                                
                                @if($shipment->dimensions)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Dimensiones:</span>
                                        <span class="font-medium">
                                            {{ $shipment->dimensions['length'] }}×{{ $shipment->dimensions['width'] }}×{{ $shipment->dimensions['height'] }} cm
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Fechas Importantes -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📅 Fechas Importantes</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Creado:</span>
                                    <span class="font-medium">{{ $shipment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                @if($shipment->shipped_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Enviado:</span>
                                        <span class="font-medium">{{ $shipment->shipped_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                                
                                @if($shipment->estimated_delivery)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Entrega Estimada:</span>
                                        <span class="font-medium">{{ $shipment->estimated_delivery->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($shipment->delivered_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Entregado:</span>
                                        <span class="font-medium text-green-600">{{ $shipment->delivered_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Direcciones -->
                    <div class="space-y-6">
                        <!-- Remitente -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📤 Remitente</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <div class="font-semibold">{{ $shipment->sender_address['name'] }}</div>
                                @if(isset($shipment->sender_address['company']))
                                    <div class="text-gray-600">{{ $shipment->sender_address['company'] }}</div>
                                @endif
                                <div class="text-gray-700">{{ $shipment->sender_address['street'] }}</div>
                                <div class="text-gray-700">
                                    {{ $shipment->sender_address['city'] }}, {{ $shipment->sender_address['state'] }}
                                </div>
                                <div class="text-gray-700">{{ $shipment->sender_address['postal_code'] }}</div>
                                <div class="text-gray-600">📞 {{ $shipment->sender_address['phone'] }}</div>
                                <div class="text-gray-600">📧 {{ $shipment->sender_address['email'] }}</div>
                            </div>
                        </div>

                        <!-- Destinatario -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📥 Destinatario</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <div class="font-semibold">{{ $shipment->recipient_address['name'] }}</div>
                                <div class="text-gray-700">{{ $shipment->recipient_address['street'] }}</div>
                                <div class="text-gray-700">
                                    {{ $shipment->recipient_address['city'] }}, {{ $shipment->recipient_address['state'] }}
                                </div>
                                <div class="text-gray-700">{{ $shipment->recipient_address['postal_code'] }}</div>
                                <div class="text-gray-600">📞 {{ $shipment->recipient_address['phone'] }}</div>
                                <div class="text-gray-600">📧 {{ $shipment->recipient_address['email'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="border-t pt-6 mt-8">
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        @if($shipment->label_url)
                            <a href="{{ $shipment->label_url }}" 
                               target="_blank" 
                               class="btn btn-primary">
                                📥 Descargar Guía PDF
                            </a>
                        @endif

                        @if($shipment->tracking_number)
                            <a href="{{ route('shipments.track', $shipment) }}" 
                               class="btn btn-outline btn-info">
                                🔍 Rastrear Envío
                            </a>
                        @endif

                        <a href="{{ route('shipments.index') }}" 
                           class="btn btn-outline">
                            📋 Ver Todos los Envíos
                        </a>

                        <a href="{{ route('shop.show', $shipment->product) }}" 
                           class="btn btn-outline">
                            🔙 Volver al Producto
                        </a>
                    </div>
                </div>

                <!-- Mensaje especial para el vendedor -->
                @if(Auth::id() === $shipment->seller_id)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-yellow-600 mt-1 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Instrucciones para el Vendedor</h3>
                                <div class="text-yellow-700 mt-2 space-y-1">
                                    <p>• Descarga e imprime la guía de envío PDF</p>
                                    <p>• Empaca bien tu producto para evitar daños</p>
                                    <p>• Pega la etiqueta en la parte superior del paquete</p>
                                    <p>• Lleva el paquete a una sucursal FedEx o programa una recolección</p>
                                    <p>• El comprador recibirá actualizaciones automáticas del rastreo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Mensaje especial para el comprador -->
                @if(Auth::id() === $shipment->buyer_id)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-blue-600 mt-1 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-blue-800">Información para el Comprador</h3>
                                <div class="text-blue-700 mt-2 space-y-1">
                                    <p>• Tu guía de envío ha sido generada exitosamente</p>
                                    <p>• El vendedor recibirá las instrucciones por correo electrónico</p>
                                    <p>• Una vez que el vendedor entregue el paquete a FedEx, podrás rastrearlo</p>
                                    <p>• Recibirás actualizaciones automáticas del estado del envío</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-base>
