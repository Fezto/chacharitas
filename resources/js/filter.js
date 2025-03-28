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
        const products_html = products.map(product => `
        <div class="card bg-base-100 shadow-md">
            <figure>
                <img src="${product.image}" alt="Producto ${product.id}" class="w-full h-48 object-contain">
            </figure>
            <div class="card-body">
                <h2 class="card-title">${product.name}</h2>
                <p class="text-gray-600">${product.description}</p>
                <p class="font-bold text-lg text-primary">$ ${product.price}</p>
                <form action="/shop/${product.id}" method="GET">
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
    `).join('');

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
