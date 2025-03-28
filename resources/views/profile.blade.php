<x-base>
    <div class="flex">
        <!-- Sidebar de navegación del perfil -->
        <div id="profile-sidebar" class="w-64 bg-base-100 shadow-md p-6 hidden md:block">
            <h2 class="text-2xl font-bold mb-6">Mi Perfil</h2>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('profile.edit') }}" class="block py-2 px-4 rounded hover:bg-gray-200">
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

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Foto de perfil -->
                <div class="flex items-center space-x-4">
                    <img id="profile-photo" src="{{ asset('img/users/' . (Auth::user()->photo ?? 'default.jpg')) }}" alt="Foto de perfil" class="w-24 h-24 rounded-full object-cover">
                    <div>
                        <label for="photo" class="btn btn-primary cursor-pointer">Cambiar Foto</label>
                        <input type="file" id="photo" name="photo" class="hidden">
                    </div>
                </div>

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <!-- Correo electrónico -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <!-- Cambiar contraseña (opcional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Dejar en blanco para no cambiar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar nueva contraseña" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Botón de guardar cambios -->
                <div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</x-base>
