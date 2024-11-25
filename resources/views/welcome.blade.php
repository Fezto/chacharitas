<x-base>
    <div
        class="hero min-h-[75vh]"
        style="background-image: url({{asset('img/welcome_wp.jpeg')}});">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-neutral-content text-center">
            <div class="flex flex-row justify-center space-x-20">
                <div class="w-5/12 text-left my-auto">
                    <h1 class="mb-5 text-5xl font-bold font-patrick-hand">Vistiendo el futuro con recuerdos
                        sostenibles</h1>
                    <h1 class="mb-5 text-3xl font-bold font-patrick-hand">Empresa 100% mexicana</h1>
                    <p class="mb-5 text-xl">
                        Chacharitas es una plataforma web pensada para padres que buscan comprar o vender ropa para
                        niños y bebés de segunda mano, de esta manera ayudaremos a reducir la contaminación textil y
                        apoyamos en su economía.
                    </p>
                </div>
                <div class="w-4/12">
                    <img src="{{asset('img/logo.png')}}" alt="About Hero">
                </div>
            </div>
        </div>
    </div>

    <div class="hero bg-red-50 min-h-[80vh]">
        <div class="hero-content flex-col my-20">
            <div class="flex flex-col  w-6/12 items-center">
                <h1 class="text-5xl font-bold font-patrick-hand">Es hora de hacer un cambio</h1>
                <p class="py-6 text-xl text-center">
                    De todos los residuos textiles generados, únicamente se recicla el 15% y el resto se incinera o se
                    tira
                    en vertederos, por ello es importante tomar consciencia del impacto de la moda "Fast Fashion" así
                    como
                    tomar medidas para reducir el consumo de ropa.
                </p>

            </div>
            <div class="flex flex-row justify-center space-x-20">
                <div class="card bg-base-100 shadow-xl w-1/4">
                    <figure class="px-3 pt-10">
                        <img
                            src="{{asset('img/clothing.jpg')}}"
                            alt="Shoes"
                            class="rounded-full aspect-square w-10/12"/>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title mb-3 text-3xl font-patrick-hand">Ropa</h2>
                        <div class="card-actions">
                            <a href="{{ route('shop.index', ['category' => 1]) }}" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="card bg-base-100 shadow-xl w-1/4">
                    <figure class="px-3 pt-10">
                        <img
                            src="{{asset('img/shoes.jpg')}}"
                            alt="Shoes"
                            class="rounded-full aspect-square w-10/12"/>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title mb-3 text-3xl font-patrick-hand">Calzado</h2>
                        <div class="card-actions">
                            <a href="{{ route('shop.index', ['category' => 4]) }}" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="card bg-base-100  shadow-xl w-1/4">
                    <figure class="px-3 pt-10">
                        <img
                            src="{{asset('img/toys.jpg')}}"
                            alt="Shoes"
                            class="rounded-full aspect-square w-10/12"/>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title mb-3 text-3xl font-patrick-hand">Juguetes</h2>
                        <div class="card-actions">
                            <a href="{{ route('shop.index', ['category' => 3]) }}" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-base>
