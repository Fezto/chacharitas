<x-html>
    <div class="hero bg-cyan-50 min-h-screen">
        <div class="w-11/12 mx-auto">
            <!-- Hacemos que la disposición cambie en pantallas pequeñas -->
            <div class="hero-content flex flex-col lg:flex-row lg:space-x-20 space-y-0 lg:space-y-0">
                <div class="text-center justify-center">
                    <!-- Ajuste responsivo del tamaño de texto -->
                    <h1 class="text-5xl lg:text-8xl font-bold font-patrick-hand">¡Regístrate!</h1>
                    <p class="py-6">
                        Para empezar a construir una vida sustentable
                    </p>
                    <img alt="login" src="{{asset('img/login.png')}}" class="size-3/4">
                </div>
                <livewire:register-form></livewire:register-form>
            </div>
        </div>
    </div>

</x-html>
