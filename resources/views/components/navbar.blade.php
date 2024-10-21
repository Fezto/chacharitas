<div class="flex items-center justify-between h-20 bg-base-100 px-4 bg-primary shadow-lg">
    <div class="flex items-center">
        <a class="btn btn-ghost text-4xl font-patrick-hand hover:bg-secondary transition duration-300"><img
                src="{{ asset('svg/carriage.svg') }}" class="h-12" alt="logo">Chacharitas</a>
    </div>
    <div>
        <ul class="flex justify-between space-x-10">
            <li><a href="/" class="hover:bg-accent btn btn-ghost transition duration-300 px-3 py-2 rounded">Inicio</a>
            </li>
            <li><a href="/store" class="hover:bg-secondary btn btn-ghost transition duration-300 px-3 py-2 rounded">Productos</a>
            </li>
            <li class="relative group">
                <a href="/about" class="hover:bg-error btn btn-ghost transition duration-300 px-3 py-2 rounded">Sobre
                    nosotros</a>
                <ul class="absolute hidden group-hover:block bg-base-100 shadow-lg mt-2 rounded-lg">
                    <li><a class="block px-4 py-2 hover:bg-error hover:text-white transition duration-300">Historia</a>
                    </li>
                    <li><a class="block px-4 py-2 hover:bg-success hover:text-white transition duration-300">Equipo</a>
                    </li>
                </ul>
            </li>
            <li><a href="/contact" class="hover:bg-success btn btn-ghost transition duration-300 px-3 py-2 rounded">Contactanos</a>
            </li>
        </ul>
    </div>
    <div class="flex items-center space-x-4">
        @guest
            <form action="{{ url('/login') }}" method="GET">
                <button type="submit" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    Iniciar Sesión
                </button>
            </form>

        @endguest
        @auth
            <button class="btn btn-ghost btn-circle hover:bg-secondary transition duration-300">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            <button class="btn btn-ghost btn-circle hover:bg-secondary transition duration-300">
                <div class="indicator">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
            </button>
        @endauth
    </div>
</div>
