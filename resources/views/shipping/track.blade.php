<x-base>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                📍 Rastrear Envío #{{ $shipment->id }}
            </h1>
            
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Información del Envío</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="font-medium text-gray-600">Número de Rastreo:</span>
                            <span class="text-blue-600 font-mono ml-2">{{ $shipment->tracking_number }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Estado:</span>
                            <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium
                                @if($shipment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($shipment->status === 'created') bg-green-100 text-green-800
                                @elseif($shipment->status === 'in_transit') bg-blue-100 text-blue-800
                                @elseif($shipment->status === 'delivered') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ ucfirst($shipment->status) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Producto:</span>
                            <span class="ml-2">{{ $shipment->product->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Peso:</span>
                            <span class="ml-2">{{ $shipment->weight }} kg</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Direcciones</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-600">Origen:</h4>
                            <p class="text-sm text-gray-600">
                                {{ $shipment->sender_address['name'] }}<br>
                                {{ $shipment->sender_address['street'] }}<br>
                                {{ $shipment->sender_address['city'] }}, {{ $shipment->sender_address['state'] }} {{ $shipment->sender_address['postal_code'] }}
                            </p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-600">Destino:</h4>
                            <p class="text-sm text-gray-600">
                                {{ $shipment->recipient_address['name'] }}<br>
                                {{ $shipment->recipient_address['street'] }}<br>
                                {{ $shipment->recipient_address['city'] }}, {{ $shipment->recipient_address['state'] }} {{ $shipment->recipient_address['postal_code'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(isset($trackingData))
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Información de Rastreo</h3>
                    
                    @if(isset($trackingData['output']['completeTrackResults'][0]['trackResults'][0]['scanEvents']))
                        <div class="space-y-4">
                            @foreach($trackingData['output']['completeTrackResults'][0]['trackResults'][0]['scanEvents'] as $event)
                                <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium text-gray-800">
                                                    {{ $event['eventDescription'] ?? 'Evento de seguimiento' }}
                                                </h4>
                                                @if(isset($event['scanLocation']))
                                                    <p class="text-sm text-gray-600">
                                                        {{ $event['scanLocation']['city'] ?? '' }}, 
                                                        {{ $event['scanLocation']['stateOrProvinceCode'] ?? '' }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="text-right text-sm text-gray-500">
                                                @if(isset($event['date']))
                                                    {{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y H:i') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">📦</div>
                            <p class="text-gray-600">
                                La información de rastreo estará disponible una vez que FedEx recoja el paquete.
                            </p>
                        </div>
                    @endif
                </div>
            @else
                <div class="border-t pt-6">
                    <div class="text-center py-8">
                        <div class="text-4xl mb-4">⏳</div>
                        <p class="text-gray-600">
                            Cargando información de rastreo...
                        </p>
                    </div>
                </div>
            @endif
            
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                <a href="{{ route('shipments.show', $shipment) }}" 
                   class="btn btn-outline">
                    ← Volver a Detalles
                </a>
                
                <button onclick="window.location.reload()" 
                        class="btn btn-primary">
                    🔄 Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
</x-base>
