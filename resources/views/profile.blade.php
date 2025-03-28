<x-base>
    <div class="flex">
        <!-- Sidebar de navegación del perfil -->
        <div id="profile-sidebar" class="w-64 bg-base-100 shadow-md p-6 hidden md:block">
            <h2 class="text-2xl font-bold mb-6">Mi Perfil</h2>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('profile.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200">
                        Información Personal
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('profile.password') }}" class="block py-2 px-4 rounded hover:bg-gray-200">
                        Cambiar Contraseña
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('profile.settings') }}" class="block py-2 px-4 rounded hover:bg-gray-200">
                        Configuración
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal: formulario de edición de perfil -->
        <div id="profile-container" class="flex-1 px-6 py-8">
            <h1 class="text-3xl font-bold mb-6">Editar Perfil</h1>

            <livewire:profile-form></livewire:profile-form>

        </div>
    </div>
</x-base>
