<x-base>
    <div class="hero bg-base-200 min-h-screen">
        <div class="w-10/12 mx-auto">
            <div class="hero-content flex flex-col lg:flex-row lg:space-x-20 space-y-0 lg:space-y-0">
                <div class="text-left">
                    <h1 class="text-6xl lg:text-7xl font-bold font-patrick-hand">¡Alto!</h1>
                    <p class="py-6">
                        No tienes autorización de acceder a esta página
                    </p>
                    <form method="GET" action="{{ route('welcome.index') }}" class="inline">
                        <button type="submit" class="btn btn-primary text-black">
                            Regresar
                        </button>
                    </form>
                </div>
                <img src="{{asset('img/403.png')}}" alt="Verificación de correo" class="w-4/12 ">
            </div>
        </div>
    </div>
</x-base>
