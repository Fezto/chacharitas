<x-base>
    <div class="container mx-auto px-4 py-8">
        <!-- Botón para volver a la tienda -->
        <a href="{{ route('shop.index') }}" class="btn btn-ghost mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a la tienda
        </a>

        <!-- Contenedor principal del producto -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Sección de la imagen -->
            <figure class="bg-base-200 p-6 rounded-lg relative overflow-hidden shadow-lg border border-gray-200">
                <!-- Carrusel -->
                <div class="carousel w-full relative group">
                    @foreach($product->images as $index => $image)
                        <div id="item{{ $index + 1 }}" class="carousel-item w-full flex justify-center">
                            <img src="{{ asset('img/products/' . $image->url) }}" alt="{{ $product->name }}"
                                 class="h-96 object-contain zoomable">
                        </div>
                    @endforeach
                </div>
                <!-- Navegación del carrusel (opcional) -->
                <div class="flex justify-center w-full py-2 gap-2">
                    @foreach($product->images as $index => $image)
                        <a href="#item{{ $index + 1 }}" class="btn btn-xs">{{ $index + 1 }}</a>
                    @endforeach
                </div>
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
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Cantidad</span>
                        </label>
                        <input type="number" name="quantity" value="1" min="1" class="input input-bordered w-32">
                    </div>
                    <button type="submit" class="btn btn-primary w-full lg:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
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
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Envíos a todo el país</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-info" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Garantía de 30 días</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa -->
    <div class="card bg-base-100 shadow-md mt-8">
        <div class="card-body">
            <h2 class="card-title">Ubicación aproximada del vendedor</h2>
            <div id="map" class="h-96 w-full rounded-box"></div>
        </div>
    </div>

    <!-- Magnifier (Fuera del contenedor principal para evitar overflow-hidden) -->
    <div id="magnifier" class="hidden fixed rounded shadow-md"
         style="width: 600px; height: 600px; overflow: hidden; background-repeat: no-repeat; z-index: 1000; border: 1px solid rgba(0,0,0,0.1);"></div>

    <!-- Inicialización de Google Maps -->
    <script>
        window.initMap = function () {
            // Obtener las coordenadas del centro del mapa
            const centerData = {!! json_encode($map_center) !!};
            const lat = parseFloat(centerData.lat);
            const lng = parseFloat(centerData.lng);

            if (!isFinite(lat) || !isFinite(lng)) {
                console.error('Coordenadas inválidas para el mapa:', centerData);
                return;
            }

            const center = { lat: lat, lng: lng };

            // Crear el mapa
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: center,
                mapTypeControl: false,
                streetViewControl: false
            });

            // Agregar un círculo para indicar un área aproximada (2km de radio)
            new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: center,
                radius: 2000
            });
        };
    </script>

    <!-- Script para el efecto de zoom avanzado sin overlay -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const magnifier = document.getElementById('magnifier');
            const zoomableImages = document.querySelectorAll('.zoomable');

            let currentImg = zoomableImages[0];

            function updateMagnifierPosition(e, img) {
                const rect = img.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const xPercent = (x / img.width) * 100;
                const yPercent = (y / img.height) * 100;

                // Posicionar la lupa a la derecha de la imagen
                magnifier.style.left = `${rect.right + 20}px`;
                const verticalOffset = Math.min(
                    window.innerHeight - magnifier.offsetHeight - 20,
                    Math.max(20, e.clientY - magnifier.offsetHeight / 2)
                );
                magnifier.style.top = `${verticalOffset}px`;

                // Ajustar tamaño y posición del background en la lupa
                magnifier.style.backgroundSize = `${img.naturalWidth * 4}px ${img.naturalHeight * 4}px`;
                magnifier.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
            }

            zoomableImages.forEach(function (img) {
                img.addEventListener('mouseenter', function (e) {
                    magnifier.classList.remove('hidden');
                    magnifier.style.backgroundImage = `url(${img.src})`;
                    currentImg = img;
                });

                img.addEventListener('mousemove', function (e) {
                    updateMagnifierPosition(e, img);
                });

                img.addEventListener('mouseleave', function () {
                    magnifier.classList.add('hidden');
                });
            });

            // Actualizar la imagen de fondo al cambiar de imagen en el carrusel
            const carouselItems = document.querySelectorAll('.carousel-item');
            carouselItems.forEach(item => {
                item.addEventListener('transitionend', () => {
                    const visibleImg = item.querySelector('.zoomable');
                    if (visibleImg) {
                        currentImg = visibleImg;
                        magnifier.style.backgroundImage = `url(${currentImg.src})`;
                    }
                });
            });
        });
    </script>

    <!-- Script para prevenir el scroll al hacer clic en los enlaces del carrusel -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselLinks = document.querySelectorAll('.carousel a');
            carouselLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Si usas un plugin o lógica adicional para el carrusel, puedes llamarla aquí.
                });
            });
        });
    </script>

    <!-- Cargar la API de Google Maps de forma asíncrona -->
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap&loading=async">
    </script>
</x-base>
