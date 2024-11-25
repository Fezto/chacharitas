<x-base>
    <div class="flex">
        <!-- Botón de Toggle para el Sidebar -->
        <div id="filter-button-container" class="p-4 hidden transition-all duration-300 ease-in-out">
            <button id="toggle-btn" class="btn btn-primary">Filtros</button>
        </div>

        <!-- Sidebar de Filtros -->
        <div id="sidebar"
             class="fixed left-0 top-0 h-full bg-base-100 shadow-md p-6 w-80 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">

            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Filtros</h2>
                    <!-- Botón de Cerrar -->
                    <button id="close-sidebar-btn" class="btn btn-primary">Cerrar</button>
                </div>
                <!-- Filtrar por Categoría -->
                <div class="mb-4">
                    <h3 class="font-semibold text-lg">Categoría</h3>
                    <ul>
                        @foreach($categories as $category)
                            <li><input type="checkbox" id="{{$category->id}}"
                                       class="checkbox category-checkbox mr-2"><label
                                    for="{{$category->name}}">{{$category->name}}</label></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Filtrar por Precio -->
                <div class="mb-4">
                    <h3 class="font-semibold text-lg">Precio</h3>
                    <input type="range" min="0" max="1000" value="1000" class="range range-primary" step="100"/>
                    <div class="flex w-full justify-between px-2 text-xs">
                        <span>0</span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span>1000+</span>
                    </div>
                </div>
                <!-- Filtrar por Género -->
                <div class="mb-4">
                    <h3 class="font-semibold text-lg">Género</h3>
                    <ul>
                        @foreach($genders as $gender)
                            <li><input type="checkbox" id="{{$gender->id}}" class="checkbox gender-checkbox mr-2"><label
                                    for="{{$gender->name}}">{{$gender->id == 1 ? 'Niño' : 'Niña'}}</label></li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

        <!-- Grid de Productos -->
        <div id="shop-container" class="flex-1 px-20 py-8 ml-0 transition-all duration-300">
            <select id="order-select" class="select select-bordered w-full max-w-xs">
                <option disabled selected>¿Cuál órden desea?</option>
                <option value="1">Alfabéticamente</option>
                <option value="2">Menor precio</option>
                <option value="3">Mayor precio</option>
            </select>
            <div id="products-container" class="grid grid-cols-2 gap-6 mt-6">
                @foreach($products as $product)
                    <div class="card bg-base-100 shadow-md">
                        <figure>
                            <img src='{{asset("img/products/{$product->image}")}}' alt="Producto {{ $product->id }}" class="w-full h-48 object-contain">
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{$product->name}}</h2>
                            <p class="text-gray-600">{{ $product->description }}</p>
                            <p class="font-bold text-lg text-primary">$ {{ $product->price }}</p>
                            <button class="btn btn-secondary mt-4">Agregar al carrito</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script para manejar la apertura/cierre del Sidebar y la visibilidad del botón de Filtros -->
    <script>
        const toggle_button = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const close_sidebar_button = document.getElementById('close-sidebar-btn');
        const shop_container = document.getElementById('shop-container');
        const products_container = document.getElementById('products-container')
        const filter_button_container = document.getElementById('filter-button-container');
        let isSidebarOpen = false;
        const scrollThreshold = 150; // Distancia en píxeles antes de mostrar el botón

        // Mostrar u ocultar el sidebar
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
            isSidebarOpen = !isSidebarOpen;
            shop_container.classList.toggle('ml-0', !isSidebarOpen);
            shop_container.classList.toggle('ml-72', isSidebarOpen);
        };

        toggle_button.addEventListener('click', toggleSidebar);
        close_sidebar_button.addEventListener('click', toggleSidebar);

        // Mostrar el botón después de un cierto scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > scrollThreshold) {
                filter_button_container.classList.remove('hidden');
                filter_button_container.classList.add('fixed', 'top-4', 'left-1/2', 'transform', '-translate-x-1/2', 'z-50');
            } else {
                filter_button_container.classList.add('hidden');
                filter_button_container.classList.remove('fixed', 'top-4', 'left-1/2', 'transform', '-translate-x-1/2', 'z-50');
            }
        });


        // ! Para el filtrado

        document.addEventListener('DOMContentLoaded', () => {
            const category_checkboxes = document.querySelectorAll('.category-checkbox');
            const gender_checkboxes = document.querySelectorAll('.gender-checkbox');
            const price_range = document.querySelector('input[type="range"]');
            const shop_container = document.getElementById('shop-container');
            const order_select = document.getElementById('order-select');

            function fetch_filtered_products() {
                const selected_categories = Array.from(category_checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.id);
                const selected_genders = Array.from(gender_checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.id);
                const price = price_range.value;
                const order_by = order_select.value;

                fetch('/products/filter', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        categories: selected_categories,
                        genders: selected_genders,
                        min_price: 0,
                        max_price: price,
                        order_by: order_by
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        render_products(data.products);
                    });
            }

            function render_products(products) {
                const products_html =
                    products.map(product => `
                        <div class="card bg-base-100 shadow-md">
                            <figure>
                                <img src="/img/products/FotoProducto${product.id}.jpeg" alt="Producto ${product.id}" class="w-full h-48 object-contain">
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title">${product.name}</h2>
                                <p class="text-gray-600">Descripción del producto ${product.id}</p>
                                <p class="font-bold text-lg text-primary">$ ${product.price}</p>
                                <button class="btn btn-secondary mt-4">Agregar al carrito</button>
                            </div>
                        </div>
                    `).join('')

                products_container.innerHTML = products_html;
            }

            // Event listener para el cambio en las categorías
            category_checkboxes.forEach(checkbox => checkbox.addEventListener('change', fetch_filtered_products));

            // Event listener para el cambio en los géneros
            gender_checkboxes.forEach(checkbox => checkbox.addEventListener('change', fetch_filtered_products));

            // Evento para el rango de precios
            price_range.addEventListener('change', fetch_filtered_products);

            order_select.addEventListener('change', fetch_filtered_products);
        });


    </script>

    <style>
        #filter-button-container.fixed {
            transition: all 0.5s ease-in-out;
        }
    </style>
</x-base>
