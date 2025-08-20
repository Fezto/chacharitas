<x-base>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            📦 Mis Envíos
        </h1>
        
        @if($shipments->count() > 0)
            <div class="grid gap-6">
                @foreach($shipments as $shipment)
                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Envío #{{ $shipment->id }}
                                </h3>
                                <p class="text-gray-600">
                                    Producto: {{ $shipment->product->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
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
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Vendedor:</h4>
                                <p class="text-gray-600">{{ $shipment->sender_address['name'] }}</p>
                                <p class="text-gray-600">{{ $shipment->sender_address['city'] }}, {{ $shipment->sender_address['state'] }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Destinatario:</h4>
                                <p class="text-gray-600">{{ $shipment->recipient_address['name'] }}</p>
                                <p class="text-gray-600">{{ $shipment->recipient_address['city'] }}, {{ $shipment->recipient_address['state'] }}</p>
                            </div>
                        </div>
                        
                        @if($shipment->tracking_number)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-700 mb-2">Número de Rastreo:</h4>
                                <p class="text-blue-600 font-mono">{{ $shipment->tracking_number }}</p>
                            </div>
                        @endif
                        
                        @if($shipment->shipping_cost)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-700 mb-2">Costo de Envío:</h4>
                                <p class="text-green-600 font-semibold">
                                    ${{ number_format($shipment->shipping_cost, 2) }} {{ $shipment->currency }}
                                </p>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center pt-4 border-t">
                            <div class="text-sm text-gray-500">
                                Creado: {{ $shipment->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="space-x-2">
                                <a href="{{ route('shipments.show', $shipment) }}" 
                                   class="btn btn-primary btn-sm">
                                    Ver Detalles
                                </a>
                                @if($shipment->tracking_number)
                                    <a href="{{ route('shipments.track', $shipment) }}" 
                                       class="btn btn-outline btn-sm">
                                        Rastrear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $shipments->links() }}
            </div>
            
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    No tienes envíos registrados
                </h3>
                <p class="text-gray-500 mb-6">
                    Cuando compres un producto y crees una guía de envío, aparecerá aquí.
                </p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">
                    Explorar Productos
                </a>
            </div>
        @endif
    </div>
</div>
</x-base>
