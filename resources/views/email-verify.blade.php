<x-html>
    <div class="hero bg-base-200 min-h-screen">
        <div class="w-10/12 mx-auto">
            <div class="hero-content flex flex-col lg:flex-row lg:space-x-20 space-y-0 lg:space-y-0">
                <div class="text-left">
                    <h1 class="text-6xl lg:text-7xl font-bold font-patrick-hand">¡Verifica tu correo!</h1>
                    <p class="py-6">
                        Hemos enviado un enlace de verificación a tu correo electrónico. Por favor, revisa tu bandeja de
                        entrada y haz clic en el enlace para continuar.
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <x-alert type="alert-success">
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                        </x-alert>
                    @endif

                    <p class="py-4">
                        ¿No has recibido el correo?
                    <form method="POST" action="{{ route('verification.send') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary text-black">
                            Reenviar enlace
                        </button>
                    </form>
                    </p>
                </div>
                <img src="{{asset('img/mail.png')}}" alt="Verificación de correo" class="w-full lg:w-1/2">
            </div>
        </div>
    </div>
</x-html>
