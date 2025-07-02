<x-base>
    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('shop.index') }}" class="btn btn-ghost mb-8">Volver a la tienda</a>

        @if(!isset($rates))
            {{-- Formulario de cotización --}}
            <form action="{{ route('shipping.quote', $product) }}" method="POST" class="space-y-4">
                @csrf

                {{-- Destino --}}
                <h3 class="text-lg font-semibold">Dirección de destino</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="to_zip" class="input input-bordered" placeholder="Código postal" required>
                    <input type="text" name="to_name" class="input input-bordered" placeholder="Nombre destinatario" required>
                    <input type="text" name="to_phone" class="input input-bordered" placeholder="Teléfono destinatario" required>
                </div>

                {{-- Detalles del paquete --}}
                <h3 class="text-lg font-semibold">Detalles del paquete</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="number" name="weight" step="0.1" class="input input-bordered" placeholder="Peso (kg)" required>
                </div>

                {{-- Servicio FedEx --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Servicio FedEx</span></label>
                    <select name="service_type" class="select select-bordered w-full">
                        <option value="FEDEX_GROUND">Ground</option>
                        <option value="FEDEX_EXPRESS_SAVER">Express Saver</option>
                        <option value="FEDEX_2_DAY">2 Day</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Obtener cotización</button>
            </form>

        @else
            {{-- Mostrar tarifas --}}
            <h2 class="text-2xl font-semibold mb-4">Opciones de envío</h2>

            @if(is_array($rates) && count($rates))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($rates as $rate)
                        @php
                            $serviceName = data_get($rate, 'serviceName', 'Servicio desconocido');

                            $amount = data_get($rate, 'ratedShipmentDetails.0.totalNetCharge');
                            $currency = data_get($rate, 'ratedShipmentDetails.0.currency');


                            $days = data_get($rate, 'operationalDetail.deliveryDayOfWeek') ?? 'N/A';
                        @endphp

                        <div class="card p-4 shadow">
                            <h3 class="font-bold">{{ $serviceName }}</h3>

                            @if($amount && $currency)
                                <p><span class="font-semibold">Precio:</span> ${{ number_format($amount, 2) }} {{ $currency }}</p>
                            @else
                                <p class="text-warning"><span class="font-semibold">Precio:</span> No disponible</p>
                            @endif

                            <p><span class="font-semibold">Días estimados:</span> {{ $days }}</p>

                            <form action="{{ route('shipping.purchase', $product) }}" method="POST">
                                @csrf

                                {{-- Campos ocultos para purchase --}}
                                <input type="hidden" name="from_zip"     value="01000">
                                <input type="hidden" name="to_zip"       value="{{ request('to_zip') }}">
                                <input type="hidden" name="to_name"      value="{{ request('to_name') }}">
                                <input type="hidden" name="to_phone"     value="{{ request('to_phone') }}">
                                <input type="hidden" name="weight"       value="{{ request('weight') }}">
                                <input type="hidden" name="service_type" value="{{ data_get($rate, 'serviceType.type') }}">

                                <button type="submit" class="btn btn-success w-full mt-2">
                                    Comprar etiqueta
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">
                    No se encontraron tarifas. Verifica tus datos e intenta nuevamente.
                </div>
            @endif

        @endif

    </div>
</x-base>
