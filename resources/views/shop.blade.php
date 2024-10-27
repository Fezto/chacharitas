<x-base>
    <div class="flex space-y-2.5">
        <!-- Botón de Toggle para el Sidebar -->
        <div id="filter-button-container" class="p-4 hidden transition-all duration-300 ease-in-out">
            <button id="toggle-btn" class="btn btn-primary">Filtros</button>
        </div>

        <!-- Sidebar de Filtros -->
        <div id="sidebar"
             class="fixed left-0 top-0 h-full bg-base-100 shadow-md p-6 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Filtros</h2>
                <!-- Filtrar por Categoría -->
                <div class="mb-4">
                    <h3 class="font-semibold text-lg">Categoría</h3>
                    <ul>
                        <li><input type="checkbox" id="categoria1" class="checkbox mr-2"><label for="categoria1">Electrónica</label>
                        </li>
                        <li><input type="checkbox" id="categoria2" class="checkbox mr-2"><label
                                for="categoria2">Moda</label></li>
                        <li><input type="checkbox" id="categoria3" class="checkbox mr-2"><label
                                for="categoria3">Hogar</label></li>
                    </ul>
                </div>
                <!-- Filtrar por Precio -->
                <div class="mb-4">
                    <h3 class="font-semibold text-lg">Precio</h3>
                    <input type="range" min="0" max="1000" value="500" class="range range-primary">
                    <div class="flex justify-between text-sm">
                        <span>$0</span>
                        <span>$1000</span>
                    </div>
                </div>
                <!-- Filtrar por Reseñas -->
                <div class="mb-4">
                    <h3 class="font-semibold text-lg">Reseñas</h3>
                    <ul>
                        <li><input type="checkbox" id="rating1" class="checkbox mr-2"><label for="rating1">4 estrellas o
                                más</label></li>
                        <li><input type="checkbox" id="rating2" class="checkbox mr-2"><label for="rating2">3 estrellas o
                                más</label></li>
                        <li><input type="checkbox" id="rating3" class="checkbox mr-2"><label for="rating3">2 estrellas o
                                más</label></li>
                    </ul>
                </div>
                <button class="btn btn-primary mt-4 w-full">Aplicar Filtros</button>
            </div>
        </div>

        <!-- Grid de Productos -->
        <div id="products-container" class="flex-1 px-20 py-8 ml-0 transition-all duration-300">
            <div class="grid grid-cols-2 gap-6 mt-6">
                @foreach(range(1, 12) as $i)
                    <div class="card bg-base-100 shadow-md">
                        <figure>
                            <img src="https://via.placeholder.com/150" alt="Producto {{ $i }}" class="w-full h-48 object-cover">
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">Producto {{ $i }}</h2>
                            <p class="text-gray-600">Descripción del producto {{ $i }}</p>
                            <p class="font-bold text-lg text-primary">$ {{ number_format(rand(10, 100), 2) }}</p>
                            <button class="btn btn-secondary mt-4">Agregar al carrito</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script para manejar la apertura/cierre del Sidebar y la visibilidad del botón de Filtros -->
    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const productsContainer = document.getElementById('products-container');
        const filterButtonContainer = document.getElementById('filter-button-container');
        let isSidebarOpen = false;
        const scrollThreshold = 150; // Distancia en píxeles antes de mostrar el botón

        // Mostrar u ocultar el sidebar
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
            isSidebarOpen = !isSidebarOpen;
            productsContainer.classList.toggle('ml-0', !isSidebarOpen);
            productsContainer.classList.toggle('ml-72', isSidebarOpen);
        });

        // Mostrar el botón después de un cierto scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > scrollThreshold) {
                filterButtonContainer.classList.remove('hidden');
                filterButtonContainer.classList.add('fixed', 'top-4', 'left-1/2', 'transform', '-translate-x-1/2', 'z-50');
            } else {
                filterButtonContainer.classList.add('hidden');
                filterButtonContainer.classList.remove('fixed', 'top-4', 'left-1/2', 'transform', '-translate-x-1/2', 'z-50');
            }
        });
    </script>

    <style>
        /* Transición suave en la posición del botón */
        #filter-button-container.fixed {
            transition: all 0.5s ease-in-out;
        }
    </style>
</x-base>
