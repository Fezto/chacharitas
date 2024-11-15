<x-html>
    <div class="hero bg-base-200 min-h-screen">
        <div class="w-10/12 mx-auto">
            <!-- Hacemos que la disposición cambie en pantallas pequeñas -->
            <div class="hero-content flex flex-col lg:flex-row lg:space-x-20 space-y-0 lg:space-y-0">
                <div class="text-left">
                    <!-- Ajuste responsivo del tamaño de texto -->
                    <h1 class="text-5xl lg:text-8xl font-bold font-patrick-hand">¡Hola de nuevo!</h1>
                    <p class="py-6">
                        Nos da gusto verte de vuelta
                    </p>
                </div>
                <livewire:login-form></livewire:login-form>
            </div>
        </div>
    </div>

</x-html>
