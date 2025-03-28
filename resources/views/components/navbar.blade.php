<div class="navbar shadow-lg bg-lila justify-between">
    <div>
        <a class="btn btn-ghost text-4xl font-patrick-hand transition duration-300 flex items-center" href="{{route('welcome.index')}}">
            <img src="{{ asset('img/logo.png') }}" class="h-12" alt="logo"> <h1 class="text-white">
                Chacharitas
            </h1>
        </a>
    </div>
    <div class="justify-center hidden lg:block">
        <ul class="menu menu-horizontal space-x-10 justify-center">
            <li><a href="{{ route('welcome.index') }}" class="hover:bg-accent btn btn-ghost transition duration-300 text-white">Inicio</a>
            </li>
            <li><a href="{{ route('shop.index') }}" class="hover:bg-secondary btn btn-ghost transition duration-300 text-white">Productos</a></li>
            <li>
                <a href="{{ route('about.index') }}" class="hover:bg-error btn btn-ghost transition duration-300 text-white">Sobre
                    nosotros</a>
            </li>
            <li><a href="{{route('contact.index')}}" class="hover:bg-success btn btn-ghost transition duration-300 text-white">Contáctanos</a></li>
        </ul>
    </div>
    <div class="flex items-center space-x-4">
        <button class="btn btn-square btn-ghost lg:hidden" id="menu-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </button>
        @guest
            <form action="{{ route('register') }}" method="GET">
                @csrf
                <button type="submit" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    Registrarse
                </button>
            </form>
            <form action="{{ route('login') }}" method="GET">
                @csrf
                <button type="submit" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    Iniciar Sesión
                </button>
            </form>
        @endguest
        @auth
            <button class="btn btn-ghost btn-circle hover:bg-secondary transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            <button class="btn btn-ghost btn-circle hover:bg-secondary transition duration-300">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
            </button>
            <div class="dropdown dropdown-bottom dropdown-end">
                <!-- El botón del dropdown será la foto de perfil -->
                <div tabindex="0" role="button" class="btn m-1 p-0">
                    <img src="{{ auth()->user()->profile_picture ?? asset('img/default-avatar.png') }}" alt="Foto de perfil" class="w-11 h-10 rounded-full object-cover">
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <!-- Mostrar nombre del usuario si está autenticado -->
                    @auth
                        <li><p class="font-semibold pointer-events-none">{{ auth()->user()->name }}</p></li>
                        <li><a href="{{ route('profile.index') }}">Ver perfil</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left">
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                        @can('access panel')
                            <li><a href="/admin">Panel de Administración</a></li>
                        @endcan
                    @endauth
                </ul>
            </div>
        @endauth
    </div>
</div>

<!-- Mobile Menu -->
<div class="lg:hidden hidden" id="mobile-menu">
    <ul class="menu menu-compact p-2 shadow-lg bg-base-100 rounded-box">
        <li><a href="{{ route('welcome.index') }}">Inicio</a></li>
        <li><a href="/store">Productos</a></li>
        <li><a href="{{ route('about.index') }}">Sobre nosotros</a></li>
        <li><a href="{{ route('contact.index') }}">Contáctanos</a></li>
    </ul>
</div>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
