<x-base>
    <div class="container mx-auto px-4 py-8">
        <!-- Botón para volver a la tienda -->
        <a href="{{ route('shop.index') }}" class="btn btn-ghost mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a la tienda
        </a>

        <!-- Contenedor principal del producto -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Sección de la imagen -->
            <figure class="bg-base-200 p-6 rounded-box">
                <img src='{{ asset("img/products/{$product->image}") }}'
                     alt="{{ $product->name }}"
                     class="w-full h-96 object-contain">
            </figure>

            <!-- Detalles del producto -->
            <div class="space-y-6">
                <h1 class="text-4xl font-bold">{{ $product->name }}</h1>
                <p class="text-3xl text-primary">${{ number_format($product->price, 2) }}</p>

                <!-- Descripción -->
                <div class="prose max-w-none">
                    <h3 class="text-xl font-semibold">Descripción</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Formulario para agregar al carrito -->
                <form action="{{ route('shop.index', $product) }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Selector de cantidad -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Cantidad</span>
                        </label>
                        <input type="number"
                               name="quantity"
                               value="1"
                               min="1"
                               class="input input-bordered w-32">
                    </div>

                    <!-- Botón de agregar al carrito -->
                    <button type="submit" class="btn btn-primary w-full lg:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Agregar al carrito
                    </button>
                </form>

                <!-- Información adicional -->
                <div class="divider"></div>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-info" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Envíos a todo el país</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-info" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Garantía de 30 días</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-base-100 shadow-md mt-8">
        <div class="card-body">
            <h2 class="card-title">Ubicación aproximada del vendedor</h2>
            <div id="map" class="h-96 w-full rounded-box"></div>
            <p class="text-sm text-gray-500 mt-2">
                La ubicación corresponde al municipio:
                <span class="font-semibold">{{ $product->user->address->neighborhood->municipality->name }}</span>
                <br>
                Mapa por <a href="https://www.openstreetmap.org/" class="link link-primary">OpenStreetMap</a>
            </p>
        </div>
    </div>

    <script>
        // Coordenadas dinámicas desde el controlador
        const map = L.map('map').setView([{{ $map_center['lat'] }}, {{ $map_center['lng'] }}], 10);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Añadir marcador con desplazamiento aleatorio (500m aprox)
        const offsetLat = (Math.random() - 0.5) * 0.0072;  // ±0.0072 grados ≈ 800m
        const offsetLng = (Math.random() - 0.5) * 0.0090;  // ±0.0090 grados ≈ 800m

        L.marker([
            {{ $map_center['lat'] }} + offsetLat,
            {{ $map_center['lng'] }} + offsetLng
        ]).addTo(map)
            .bindPopup('Zona aproximada del vendedor<br>(ubicación no exacta)');
    </script>
</x-base>
