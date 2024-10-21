<x-html>
    <div class="hero bg-base-200 min-h-screen">
        <div class="w-10/12">
            <div class="hero-content flex flex-row space-x-20">
                <div class="text-left">
                    <h1 class="text-5xl font-bold font-patrick-hand">Registrate!</h1>
                    <p class="py-6">
                        Para empezar a construir una vida sustentable
                    </p>
                </div>
                <div class="card bg-base-100 w-full max-w-xl shrink-0 shadow-2xl">
                    <form class="card-body" id="registrationForm" action="/login" method="POST">
                        @csrf
                        <div id="step1" class="transition-opacity duration-500 opacity-100 space-y-4">
                            <div class="flex flex-row space-x-8">
                                <div class="form-control w-3/12">
                                    <label class="label">
                                        <span class="label-text">Nombre</span>
                                    </label>
                                    <input type="text" name="nombre" placeholder="Juan" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                                </div>
                                <div class="form-control w-3/12">
                                    <label class="label">
                                        <span class="label-text">Apellido Paterno</span>
                                    </label>
                                    <input type="text" name="apellido_paterno" placeholder="Pérez" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                                </div>
                                <div class="form-control w-3/12">
                                    <label class="label">
                                        <span class="label-text">Apellido Materno</span>
                                    </label>
                                    <input type="text" name="apellido_materno" placeholder="García" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                                </div>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <input type="email" name="email" placeholder="email@example.com" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Password</span>
                                </label>
                                <input type="password" name="password" placeholder="password" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                            </div>
                        </div>
                        <div id="step2" class="transition-opacity duration-500 opacity-0 space-y-4 hidden">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Dirección</span>
                                </label>
                                <input type="text" name="direccion" placeholder="Dirección" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Ciudad</span>
                                </label>
                                <input type="text" name="ciudad" placeholder="Ciudad" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Código Postal</span>
                                </label>
                                <input type="text" name="codigo_postal" placeholder="Código Postal" class="input input-bordered transition duration-300 ease-in-out transform focus:scale-105 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required/>
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
        document.getElementById('nextButton').addEventListener('click', function () {
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step1Inputs = step1.querySelectorAll('input');
            const step2Inputs = step2.querySelectorAll('input');

            step1Inputs.forEach(input => input.removeAttribute('required'));
            step2Inputs.forEach(input => input.setAttribute('required', 'required'));

            step1.classList.add('opacity-0');
            step1.classList.remove('opacity-100');
            setTimeout(() => {
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
                step2.classList.add('opacity-100');
                step2.classList.remove('opacity-0');
                document.getElementById('nextButton').classList.add('hidden');
                document.getElementById('submitButton').classList.remove('hidden');
            }, 500);
        });
    </script>
</x-html>
