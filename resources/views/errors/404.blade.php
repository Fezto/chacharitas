<x-base>
    <div class="hero bg-base-200 min-h-screen">
        <div class="w-10/12 mx-auto">
            <div class="hero-content flex flex-col lg:flex-row lg:space-x-20 space-y-0 lg:space-y-0">
                <div class="text-left">
                    <h1 class="text-6xl lg:text-7xl font-bold font-patrick-hand">¡Ooops!</h1>
                    <p class="py-6">
                        Parece que la página a la cual intentaste acceder no existe
                    </p>
                    <form method="GET" action="{{ route('welcome.index') }}" class="inline">
                        <button type="submit" class="btn btn-primary text-black">
                            Regresar
                        </button>
                    </form>
                </div>
                <img src="{{asset('img/404.png')}}" alt="Verificación de correo" class="w-full lg:w-1/2">
            </div>
        </div>
    </div>
</x-base>
