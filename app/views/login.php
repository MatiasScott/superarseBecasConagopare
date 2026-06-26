<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | Becas Superarse</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(asset_url('img/logo_instituto.png')) ?>" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para un efecto visual más pulido */
        .login-card {
            /* Sombra más profunda y suave */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease-in-out;
        }

        .login-card:hover {
            transform: translateY(-2px);
        }

        /* Color de enfoque personalizado para los inputs */
        .input-focus-ring:focus {
            --tw-ring-color: #10B981;
            /* Esmeralda, un color vibrante */
            border-color: #10B981;
        }

        .login-image-panel,
        .login-form-panel {
            width: 100%;
            max-width: 100%;
            flex: 1 1 auto;
        }

        @media (min-width: 1024px) {
            .login-image-panel {
                flex: 0 0 70%;
                max-width: 70%;
            }

            .login-form-panel {
                flex: 0 0 30%;
                max-width: 30%;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="min-h-screen flex flex-col lg:flex-row">
        <section class="login-image-panel relative">
            <img id="login-side-image"
                src="<?= htmlspecialchars(asset_url('img/Fondo-Pagina-Becas-WebGrande.jpg')) ?>"
                alt="Fondo Programa de Becas"
                class="w-full h-64 lg:h-screen object-cover">
            <div class="absolute inset-0 bg-black/20"></div>
        </section>

        <section class="login-form-panel flex items-center justify-center p-6 lg:p-10">

            <div class="login-card bg-white p-10 rounded-xl w-full max-w-md border border-gray-200">

                <div class="text-center mb-8">

                    <h1 class="text-2xl font-extrabold text-gray-900 mt-3">
                        Programa de Becas
                    </h1>
                    <p class="text-sm text-gray-600">
                        Superarse
                    </p>
                </div>

                <h2 class="text-xl font-semibold text-center mb-6 text-gray-700">Iniciar Sesión</h2>

                <?php if (isset($error_message) && $error_message): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline"><?php echo htmlspecialchars($error_message); ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?= htmlspecialchars(app_url('/login')) ?>" method="POST">
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo Electrónico</label>
                        <input type="email" id="email" name="email"
                            placeholder="ejemplo@correo.com"
                            class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                        <input type="password" id="password" name="password"
                            placeholder="••••••••"
                            class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out"
                            required>
                    </div>

                    <div class="flex flex-col gap-4">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div id="successModal" class="fixed inset-0 bg-gray-900 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-xl bg-white animate-fade-in">
            <div class="absolute top-0 right-0 p-4">
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-green-100">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl leading-6 font-bold text-gray-900 mt-4">¡Registro Exitoso!</h3>
                <div class="mt-3 px-1 py-3">
                    <p class="text-sm text-gray-500">
                        Revisa tu correo electrónico para ver tus credenciales de acceso.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const loginImage = document.getElementById('login-side-image');
        if (loginImage) {
            const imageFallbacks = [
                '<?= htmlspecialchars(asset_url('img/Fondo-Pagina-Becas-WebGrande.jpg')) ?>',
                '<?= htmlspecialchars(asset_url('img/Fondo-Pagina-Becas-WebMediana02.jpg')) ?>',
                '<?= htmlspecialchars(asset_url('img/PORTADA.jpg')) ?>'
            ];
            let currentFallbackIndex = 0;

            loginImage.addEventListener('error', function () {
                currentFallbackIndex += 1;
                if (currentFallbackIndex < imageFallbacks.length) {
                    loginImage.src = imageFallbacks[currentFallbackIndex];
                }
            });
        }

        // Script para mostrar y cerrar el modal (Mantenido y adaptado)
        const successModal = document.getElementById('successModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Mostrar Modal si $showModal es verdadero (PHP inyectado)
        <?php if (isset($showModal) && $showModal): ?>
            if (successModal) {
                successModal.classList.remove('hidden');
            }
        <?php endif; ?>

        // Cerrar Modal al hacer clic en el botón X
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => {
                successModal.classList.add('hidden');
            });
        }
        // Cerrar Modal al hacer clic fuera
        if (successModal) {
            successModal.addEventListener('click', (e) => {
                if (e.target === successModal) {
                    successModal.classList.add('hidden');
                }
            });
        }
    </script>
    <script src="<?= htmlspecialchars(asset_url('js/global.js')) ?>"></script>

</body>

</html>