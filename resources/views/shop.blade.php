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
                            <img src='{{ asset("img/products/" . optional($product->images->first())->url) }}' alt="Producto {{ $product->id }}" class="w-full h-48 object-contain">                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{$product->name}}</h2>
                            <p class="text-gray-600">{{ $product->description }}</p>
                            <p class="font-bold text-lg text-primary">$ {{ $product->price }}</p>
                            <form action="{{ route('shop.show', $product->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-secondary mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                         stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                    </svg>
                                    Ver Producto
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script para manejar la apertura/cierre del Sidebar y la visibilidad del botón de Filtros -->
    @vite('resources/js/filter.js')

</x-base>
