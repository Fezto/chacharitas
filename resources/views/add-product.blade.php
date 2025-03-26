<x-base>
    <div class="container mx-auto w-full px-4 py-8">
        <!-- Encabezado con botón para volver a la tienda -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-center md:text-left mb-4 md:mb-0">Agregar Producto</h1>
            <a href="{{ route('shop.index') }}" class="btn btn-ghost flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a la tienda
            </a>
        </div>

        <div class="flex flex-col md:flex-row  w-full">
            <!-- Panel lateral con información y consejos -->
            <aside class="w-5/12">
                <div class="card bg-base-200 shadow-md p-6">
                    <h2 class="text-2xl font-semibold mb-4">Consejos para un buen producto</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Completa todos los campos obligatorios.</li>
                        <li>Sube imágenes de alta calidad y desde distintos ángulos.</li>
                        <li>Describe claramente las características del producto.</li>
                        <li>Verifica que la información de precios y stock sea precisa.</li>
                        <li>Selecciona categorías y marcas correctas para una mejor visibilidad.</li>

                    </ul>

                    <!-- Sección adicional para rellenar el área vacía -->
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-2">Preguntas Frecuentes</h3>
                        <!-- Primer item del collapse -->
                        <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box">
                            <div class="collapse-title text-lg font-medium">
                                ¿Cómo subir imágenes de calidad?
                            </div>
                            <div class="collapse-content">
                                <p>Asegúrate de utilizar una buena iluminación y una cámara de alta resolución para evitar imágenes borrosas.</p>
                            </div>
                        </div>
                        <!-- Segundo item del collapse -->
                        <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box mt-2">
                            <div class="collapse-title text-lg font-medium">
                                ¿Qué descripción debo incluir?
                            </div>
                            <div class="collapse-content">
                                <p>Incluye detalles sobre características, materiales, y beneficios para que el cliente entienda el valor del producto.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Formulario en un card moderno -->
            <div class="w-7/12 flex items-center justify-center">
                <livewire:product-form/>
            </div>
        </div>

    </div>
</x-base>
