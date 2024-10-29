<x-html>
    <div class="hero bg-base-200 min-h-screen">
        <div class="w-10/12 mx-auto">
            <!-- Hacemos que la disposición cambie en pantallas pequeñas -->
            <div class="hero-content flex flex-col lg:flex-row lg:space-x-20 space-y-0 lg:space-y-0">
                <div class="text-left">
                    <!-- Ajuste responsivo del tamaño de texto -->
                    <h1 class="text-5xl lg:text-8xl font-bold font-patrick-hand">¡Regístrate!</h1>
                    <p class="py-6">
                        Para empezar a construir una vida sustentable
                    </p>
                </div>
                <div class="card bg-base-100 w-full max-w-xl shrink-0 shadow-2xl">
                    <form class="card-body" id="registrationForm" action="/login" method="POST">
                        @csrf
                        <!-- Ajustamos la disposición para pantallas pequeñas -->
                        <div id="step1" class="transition-opacity duration-500 opacity-100 space-y-4">
                            <div class="flex flex-col lg:flex-row lg:space-x-8 space-y-4 lg:space-y-0">
                                <div class="form-control w-full lg:w-3/12">
                                    <label class="label">
                                        <span class="label-text">Nombre</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <x-input type="text" name="nombre" placeholder="Juasdfdsn" required/>
                                </div>
                                <div class="form-control w-full lg:w-3/12">
                                    <label class="label">
                                        <span class="label-text">Apellido Paterno</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <x-input type="text" name="apellido_paterno" placeholder="Pérez" required/>
                                </div>
                                <div class="form-control w-full lg:w-3/12">
                                    <label class="label">
                                        <span class="label-text">Apellido Materno</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <x-input type="text" name="apellido_materno" placeholder="García" required/>
                                </div>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                    <x-required-star></x-required-star>
                                </label>
                                <x-input type="email" name="email" placeholder="email@example.com" required/>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Password</span>
                                    <x-required-star></x-required-star>
                                </label>
                                <x-input type="password" name="password" placeholder="password" required/>
                            </div>
                        </div>
                        <div id="step2" class="transition-opacity duration-500 opacity-0 space-y-4 hidden">
                            <div class="flex flex-col lg:flex-row lg:space-x-5 space-y-4 lg:space-y-0">
                                <div class="form-control w-full lg:w-1/2">
                                    <label class="label">
                                        <span class="label-text">Estado</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <select id="select-state"
                                            class="select select-bordered w-full transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                        <option disabled selected>Selecciona tu estado</option>
                                        <option>Homer</option>
                                    </select>
                                </div>
                                <div class="form-control w-full lg:w-1/2">
                                    <label class="label">
                                        <span class="label-text">Municipio</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <select
                                        class="select select-bordered w-full transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                        <option disabled selected>Selecciona tu municipio</option>
                                        <option>Homer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-col lg:flex-row lg:space-x-5 space-y-4 lg:space-y-0">
                                <div class="form-control w-full lg:w-5/12">
                                    <label class="label">
                                        <span class="label-text">Colonia</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <select
                                        class="select select-bordered w-full transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                        <option disabled selected>Selecciona tu colonia</option>
                                        <option>Homer</option>
                                    </select>
                                </div>
                                <div class="form-control w-full lg:w-4/12">
                                    <label class="label">
                                        <span class="label-text">Calle</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <x-input type="text" name="calle" placeholder="Calle"/>
                                </div>
                                <div class="form-control w-full lg:w-2/12">
                                    <label class="label">
                                        <span class="label-text">C.P.</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <x-input type="text" name="codigo_postal" placeholder="Código Postal" required/>
                                </div>

                            </div>
                            <div class="flex flex-col lg:flex-row lg:space-x-5 space-y-4 lg:space-y-0">
                                <div class="form-control w-full lg:w-1/3">
                                    <label class="label">
                                        <span class="label-text">Número Exterior</span>
                                        <x-required-star></x-required-star>
                                    </label>
                                    <x-input type="text" name="numero_exterior" placeholder="Número Exterior" required/>
                                </div>
                                <div class="form-control w-full lg:w-1/3">
                                    <label class="label">
                                        <span class="label-text">Número Interior</span>
                                    </label>
                                    <x-input type="text" name="numero_interior" placeholder="Número Interior"/>
                                </div>
                            </div>


                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text text-xs">Al continuar usted acepta los <strong
                                            class="underline">Término de Uso y de Servicio</strong> de Chacharitas.org</span>
                                    <input type="checkbox" checked="checked" class="checkbox"/>
                                </label>
                            </div>

                        </div>

                        <div class="form-control mt-6">
                            <button type="button" id="nextButton" class="btn btn-primary">Next</button>
                            <button type="submit" id="submitButton" class="btn btn-primary hidden">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nextButton = document.getElementById('nextButton');
            const submitButton = document.getElementById('submitButton');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const selectState = document.getElementById('select-state');

            nextButton.addEventListener('click', async function () {
                toggleSteps(step1, step2);
                await loadStates(selectState);
            });

            function toggleSteps(step1, step2) {
                const step1Inputs = step1.querySelectorAll('input');
                const step2Inputs = step2.querySelectorAll('input');

                step1Inputs.forEach(input => input.removeAttribute('required'));
                step2Inputs.forEach(input => input.setAttribute('required', 'required'));

                step1.classList.add('opacity-0');
                step1.classList.remove('opacity-100');
                setTimeout(() => {
                    step1.classList.add('hidden');
                    step2.classList.add('opacity-100');
                    step2.classList.remove('opacity-0', 'hidden');
                    nextButton.classList.add('hidden');
                    submitButton.classList.remove('hidden');
                }, 500);
            }

            async function loadStates(selectElement) {
                try {
                    const response = await axios.get('/states');
                    const states = response.data;

                    states.forEach(state => {
                        selectElement.options[selectElement.options.length] = new Option(state.name, state.id);
                    });
                } catch (error) {
                    console.error(`Ha ocurrido un error: ${error}`);
                }
            }
        });
    </script>
</x-html>
