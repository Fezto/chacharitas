<x-base>
    <!-- Container principal -->
    <div class="relative">

        <!-- Parte superior con imagen de fondo y superposición transparente -->
        <div class="relative h-[500px]">
            <img src="{{ asset('img/contact_wp.jpg') }}" alt="Background Image"
                 class="absolute w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div> <!-- Capa transparente encima de la imagen -->
        </div>

        <!-- Título sobre la imagen -->
        <div class="flex absolute top-10 left-0 right-0 justify-center items-center my-auto">
            <div class="flex flex-col w-6/12 text-center">
                <h2 class="sm:text-6xl text-5xl font-bold text-white font-patrick-hand">Contáctanos</h2>
                <p class="text-white text-base sm:text-lg mt-4">
                    ¡Te respondemos cuanto antes!
                </p>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <livewire:contact-modal></livewire:contact-modal>

        <!-- Parte inferior con hero tradicional -->
        <section class="h-[350px] bg-primary bg-opacity-20 flex items-center justify-center"></section>
    </div>
    <div class="bg-primary bg-opacity-20 flex flex-row justify-around pb-10 text-center">
        <div class="flex flex-col items-center mb-5 w-3/12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-20">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z"/>
            </svg>
            <h1 class="font-patrick-hand text-3xl">Mándanos correo</h1>
            <p>Envía un email a chacharitas@gmail.com para cualquier duda, ¡estamos para escucharte!</p>
        </div>
        <div class="flex flex-col items-center mb-5 w-3/12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-20">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0 6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z"/>
            </svg>
            <h1 class="font-patrick-hand text-3xl">Llámanos</h1>
            <p>¿Requieres de una atención más directa? comunícate con nosotros al 442 192 1400 y te contestamos cuanto
                antes</p>
        </div>
        <div class="flex flex-col items-center mb-5 w-3/12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-20">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
            </svg>

            <h1 class="font-patrick-hand text-3xl">Soporte</h1>
            <p>¿Ocurrió alguna situación con un vendedor o un comprador? Responde nuestro formulario de contacto y lo
                solucionamos</p>
        </div>
    </div>
</x-base>
