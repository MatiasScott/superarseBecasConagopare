<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario | Programa de Becas</title>
    <link rel="icon" type="image/png" href="/landingPage_BecasConagopare/public/img/logo_instituto.png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para consistencia con el Login */
        .register-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease-in-out;
        }

        .register-card:hover {
            transform: translateY(-2px);
        }

        /* Color de enfoque personalizado (Esmeralda) */
        .input-focus-ring:focus {
            --tw-ring-color: #10B981;
            border-color: #10B981;
            outline: none;
        }
    </style>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen py-12">

    <div class="register-card bg-white p-10 rounded-xl w-full max-w-3xl border border-gray-200">

        <div class="text-center mb-8">
            <svg class="h-12 w-12 mx-auto text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <h1 class="text-2xl font-extrabold text-gray-900 mt-3">
                Registro de Usuario Administrativo
            </h1>
            <p class="text-sm text-gray-600">
                Completa tus datos para acceder al sistema de gestión de becas.
            </p>
        </div>

        <form action="/landingPage_BecasConagopare/public/register" method="POST">

            <div class="hidden">
                <input type="number" id="role" name="role" value="0">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-3">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-1">Identificación del Personal</h3>
                </div>

                <div class="lg:col-span-3">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="mb-2">
                            <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">Primer Nombre <span class="text-red-500">*</span></label>
                            <input type="text" id="first_name" name="first_name" placeholder="Primer Nombre" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out" required>
                        </div>
                        <div class="mb-2">
                            <label for="second_name" class="block text-gray-700 text-sm font-medium mb-2">Segundo Nombre</label>
                            <input type="text" id="second_name" name="second_name" placeholder="Segundo Nombre" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                        <div class="mb-2">
                            <label for="first_last_name" class="block text-gray-700 text-sm font-medium mb-2">Primer Apellido <span class="text-red-500">*</span></label>
                            <input type="text" id="first_last_name" name="first_last_name" placeholder="Primer Apellido" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out" required>
                        </div>
                        <div class="mb-2">
                            <label for="second_last_name" class="block text-gray-700 text-sm font-medium mb-2">Segundo Apellido</label>
                            <input type="text" id="second_last_name" name="second_last_name" placeholder="Segundo Apellido" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out">
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-1">Información de Contacto y Ubicación</h3>
                </div>

                <div class="mb-2">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo Electrónico <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" placeholder="correo.institucional@conagopare.gob.ec" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out" required>
                </div>
                <div class="mb-2">
                    <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Teléfono</label>
                    <input type="text" id="phone" name="phone" placeholder="0999999999" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out">
                </div>
                <div class="hidden lg:block"></div>
                <div class="mb-2">
                    <label for="canton_id" class="block text-gray-700 text-sm font-medium mb-2">Cantón <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="canton_id" name="canton_id" class="input-focus-ring shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight appearance-none pr-8 transition duration-150 ease-in-out bg-white" required>
                            <option value="">Seleccione un cantón</option>
                            <?php if (!empty($cantons)): ?>
                                <?php foreach ($cantons as $canton): ?>
                                    <option value="<?= htmlspecialchars($canton['id']) ?>"><?= htmlspecialchars($canton['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="parish_id" class="block text-gray-700 text-sm font-medium mb-2">Parroquia <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="parish_id" name="parish_id" class="input-focus-ring shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight appearance-none pr-8 transition duration-150 ease-in-out bg-white" disabled required>
                            <option value="">Seleccione una parroquia</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block"></div>
                <div class="lg:col-span-3 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-1">Credenciales de Acceso</h3>
                </div>

                <div class="mb-2">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" placeholder="••••••••" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out" required>
                </div>
                <div class="mb-2">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-medium mb-2">Confirmar Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" class="input-focus-ring shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-4 text-gray-700 leading-tight transition duration-150 ease-in-out" required>
                </div>
                <div class="hidden lg:block"></div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-4 border-t border-gray-200">

                <button type="submit" class="w-full sm:w-auto order-1 sm:order-none bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out shadow-md hover:shadow-lg mb-3 sm:mb-0">
                    Crear Cuenta de Staff
                </button>

                <div class="flex flex-col sm:flex-row gap-4 items-center">
                    <a href="/landingPage_BecasConagopare/public/dashboard-admin" class="inline-block align-baseline font-semibold text-sm text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
                        Regresar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div id="successModal" class="fixed inset-0 bg-gray-900 bg-opacity-70 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-green-100">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl leading-6 font-bold text-gray-900 mt-4">¡Registro de Staff Exitoso!</h3>
                <div class="mt-3 px-1 py-3">
                    <p class="text-sm text-gray-500">
                        Tu cuenta ha sido creada. Ahora puedes iniciar sesión en el sistema.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="ok-btn" onclick="window.location.href='/landingPage_BecasConagopare/public/login'" class="px-4 py-2 bg-emerald-600 text-white text-base font-medium rounded-lg w-full shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                        Ir a Iniciar Sesión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const successModal = document.getElementById('successModal');
        const okBtn = document.getElementById('ok-btn');

        // Cierra el modal al hacer clic en OK (y redirige al login)
        if (okBtn) {
            okBtn.addEventListener('click', () => {
                window.location.href = '/landingPage_BecasConagopare/public/login';
            });
        }
    </script>
    <script src="/landingPage_BecasConagopare/public/js/cantonParroquia.js"></script>
</body>

</html>