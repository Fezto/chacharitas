<x-base>
    <div class="container mx-auto px-4 py-8">

        <a href="{{ route('shop.index') }}" class="btn btn-ghost mb-8">Volver a la tienda</a>

        @if(!isset($options))
            {{-- 1) Formulario de cotización --}}
            <form action="{{ route('shipping.quote', $product) }}" method="POST" class="space-y-4">
                @csrf

                {{-- Dirección de destino --}}
                <h3 class="text-lg font-semibold">Dirección de destino</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="to[name]"    class="input input-bordered" placeholder="Nombre destinatario" required>
                    <input type="email" name="to[email]"  class="input input-bordered" placeholder="Correo electrónico" required>
                    <input type="text" name="to[street1]" class="input input-bordered" placeholder="Calle y número" required>
                    <input type="text" name="to[city]"    class="input input-bordered" placeholder="Ciudad" required>
                    <input type="text" name="to[state]"   class="input input-bordered" placeholder="Estado/Provincia" required>
                    <input type="text" name="to[zip]"     class="input input-bordered" placeholder="Código postal" required>
                    {{-- Country lo forzamos en controller, no lo pidas aquí --}}
                </div>

                {{-- Detalles del paquete --}}
                <h3 class="text-lg font-semibold">Detalles del paquete</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="number" step="0.1" name="parcels[0][length]" class="input input-bordered" placeholder="Largo (cm)" required>
                    <input type="number" step="0.1" name="parcels[0][width]"  class="input input-bordered" placeholder="Ancho (cm)" required>
                    <input type="number" step="0.1" name="parcels[0][height]" class="input input-bordered" placeholder="Alto (cm)" required>
                    <input type="number" step="0.1" name="parcels[0][weight]" class="input input-bordered" placeholder="Peso (kg)" required>

                    {{-- Unidades fijas --}}
                    <input type="hidden" name="parcels[0][distance_unit]" value="cm">
                    <input type="hidden" name="parcels[0][mass_unit]"     value="kg">
                </div>

                <button type="submit" class="btn btn-primary">Obtener cotización</button>
            </form>

        @else
            {{-- 2) Mostrar opciones de envío --}}
            <h2 class="text-2xl font-semibold mb-4">Opciones de envío</h2>

            @if(count($options))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($options as $rate)
                        <div class="card p-4 shadow">
                            <h3 class="font-bold">
                                {{ $rate['provider_name'] }} – {{ $rate['servicelevel']['name'] }}
                            </h3>
                            <p>Precio: ${{ number_format($rate['amount'],2) }} {{ $rate['currency'] }}</p>
                            <p>Días: {{ $rate['days'] ?? 'N/A' }}</p>

                            <form action="{{ route('shipping.purchase', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="rate_id" value="{{ $rate['object_id'] }}">
                                <button type="submit" class="btn btn-success w-full mt-2">
                                    Comprar etiqueta
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">
                    No se encontraron opciones de envío. Por favor verifica tu dirección y datos del paquete.
                </div>
            @endif

        @endif

    </div>
</x-base>
