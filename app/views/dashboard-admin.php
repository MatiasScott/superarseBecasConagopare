<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="icon" type="image/png" href="/landingPage_BecasConagopare/public/img/logo_instituto.png" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.25s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6">

    <!-- Header -->
    <header class="bg-white p-5 rounded-2xl shadow-lg flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🎓 Panel de Administración</h1>
            <p class="text-sm text-gray-600">Gestión de estudiantes y usuarios administrativos</p>
        </div>
        <div class="flex space-x-2 mt-4 md:mt-0">
            <a href="/landingPage_BecasConagopare/public/register"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                ➕ Registrar Usuario
            </a>
            <a href="/landingPage_BecasConagopare/public/change-password"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                🔑 Cambiar Contraseña
            </a>
            <a href="/landingPage_BecasConagopare/public/logout"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                🔒 Cerrar Sesión
            </a>
        </div>
    </header>

    <!-- Menú principal -->
    <nav class="bg-white p-3 rounded-2xl shadow-lg mb-6">
        <div class="flex gap-3 flex-wrap">
            <a href="/landingPage_BecasConagopare/public/dashboard-admin?view=students"
                class="px-4 py-2 rounded-lg font-semibold <?= ($view ?? 'students') === 'students' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                📋 Estudiantes
            </a>
            <a href="/landingPage_BecasConagopare/public/dashboard-admin?view=users"
                class="px-4 py-2 rounded-lg font-semibold <?= ($view ?? 'students') === 'users' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                👥 Usuarios Administrativos
            </a>
            <a href="/landingPage_BecasConagopare/public/dashboard-admin?view=scholarships"
                class="px-4 py-2 rounded-lg font-semibold <?= ($view ?? 'students') === 'scholarships' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                🎯 Carreras y Becas
            </a>
        </div>
    </nav>

    <!-- Cards métricas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Total Estudiantes</p>
            <p class="text-3xl font-bold text-gray-800"><?= $totalStudents ?? 0 ?></p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Pendientes</p>
            <p class="text-3xl font-bold text-yellow-500"><?= $pendingStudents ?? 0 ?></p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Ingresados</p>
            <p class="text-3xl font-bold text-green-600"><?= $approvedStudents ?? 0 ?></p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Anulados</p>
            <p class="text-3xl font-bold text-red-500"><?= $rejectedStudents ?? 0 ?></p>
        </div>
    </div>

    <?php if (($view ?? 'students') === 'students') : ?>

    <!-- Filtros -->
    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
            <h3 class="text-lg font-bold mb-4 text-gray-700">🔍 Filtros</h3>
    
            <form action="/landingPage_BecasConagopare/public/dashboard-admin" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
    
                <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
        <select id="program" name="program"
            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
            
            <option value="">Todas</option>
            <?php if (!empty($configuredPrograms)) : foreach ($configuredPrograms as $configuredProgram) : ?>
                <option value="<?= htmlspecialchars($configuredProgram['name']) ?>"
                    <?= ($selectedProgram ?? '') === $configuredProgram['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($configuredProgram['name']) ?>
                </option>
            <?php endforeach;
            endif; ?>
    
        </select>
    </div>


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Registrado por</label>
                <select id="registered_by_user_id" name="registered_by_user_id"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
                    <option value="">Todos</option>
                    <?php if (!empty($users)) : foreach ($users as $user) : ?>
                            <option value="<?= $user['id'] ?>" <?= (string)($selectedRegisteredBy ?? '') === (string)$user['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['first_name'] . ' ' . $user['first_last_name']) ?>
                            </option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                    Filtrar
                </button>
            </div>

            <div class="flex items-end">
                <a href="/landingPage_BecasConagopare/public/export-excel"
                    class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg shadow">
                    📥 Exportar
                </a>
            </div>
        </form>
    </div>

    <!-- Buscador -->
    <div class="mb-4 flex justify-end">
        <input type="text" id="tableSearch" placeholder="Buscar estudiante..."
            class="border rounded-lg p-2 w-full md:w-1/3 focus:ring focus:ring-blue-200">
    </div>

    <!-- Tabla -->
    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">📋 Estudiantes</h3>

        <table class="min-w-full text-sm" id="studentsTable">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Identificación</th>
                    <th class="px-4 py-3 text-left">Celular</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Carrera</th>
                    <th class="px-4 py-3 text-left">Convenio</th>
                    <th class="px-4 py-3 text-left">Sede</th>
                    <th class="px-4 py-3 text-left">Modalidad</th>
                    <th class="px-4 py-3 text-left">Registrado por</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($students_filtered)) : foreach ($students_filtered as $student) : ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['second_name'] . ' ' . $student['first_last_name'] . ' ' . $student['second_last_name']) ?>
                            </td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['id_number']) ?></td>
                            <td class="px-4 py-3">
                                <a target="_blank" class="text-blue-600 hover:underline"
                                    href="https://wa.me/<?= $student['cellphone'] ?>">
                                    <?= $student['cellphone'] ?>
                                </a>
                            </td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['email']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['program']) ?></td>
                            <td class="px-4 py-3">
                                <?php if ((int)($student['is_convenio'] ?? 0) === 1) : ?>
                                    <?= htmlspecialchars($student['convenio_name'] ?? 'Sí') ?>
                                <?php else : ?>
                                    <span class="text-gray-500">No</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['sede'] ?? '') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['modalidad'] ?? '') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['user_first_name'] . ' ' . $student['user_first_last_name']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($student['registration_date']) ?></td>

                            <!-- Estado con badge -->
                            <td class="px-4 py-3">
                                <?php if ($student['status'] === 'pendiente') : ?>
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Pendiente
                                    </span>
                                <?php elseif ($student['status'] === 'aprobado') : ?>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Ingresado
                                    </span>
                                <?php else : ?>
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Anulado
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <button onclick='openModal(<?= json_encode($student) ?>)'
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs shadow">
                                    Gestionar
                                </button>
                            </td>
                        </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="studentModal"
        class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">

        <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl animate-fade-in">
            <h3 class="text-xl font-bold mb-4">✏️ Actualizar Estudiante</h3>

            <form action="/landingPage_BecasConagopare/public/update-student" method="POST" class="space-y-4">
                <input type="hidden" name="id" id="modal-student-id">

                <div>
                    <label class="block text-sm text-gray-700">Nombre completo</label>
                    <input type="text" id="modal-full-name"
                        class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm text-gray-700">Estado</label>
                    <select name="status" id="modal-status"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
                        <option value="pendiente">Pendiente</option>
                        <option value="aprobado">Ingresado</option>
                        <option value="anulado">Anulado</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="/landingPage_BecasConagopare/public/js/dashboardAdmin.js"></script>

    <?php elseif (($view ?? 'students') === 'users') : ?>

    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">👥 Usuarios del Sistema (Administrativos y Normales)</h3>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Teléfono</th>
                    <th class="px-4 py-3 text-left">Tipo de Usuario</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($systemUsers)) : foreach ($systemUsers as $systemUser) : ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                <?= htmlspecialchars(trim($systemUser['first_name'] . ' ' . ($systemUser['second_name'] ?? '') . ' ' . $systemUser['first_last_name'] . ' ' . ($systemUser['second_last_name'] ?? ''))) ?>
                            </td>
                            <td class="px-4 py-3"><?= htmlspecialchars($systemUser['email']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($systemUser['phone'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3">
                                <?php if ((int)($systemUser['role'] ?? 0) === 1) : ?>
                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Administrador
                                    </span>
                                <?php else : ?>
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Usuario Normal
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php else : ?>

    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
        <h3 class="text-lg font-bold mb-4 text-gray-700">➕ Nueva carrera y porcentaje de beca</h3>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'created') : ?>
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">Carrera creada correctamente.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'updated') : ?>
            <div class="mb-4 p-3 rounded-lg bg-blue-100 text-blue-700 text-sm">Carrera actualizada correctamente.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'program_exists') : ?>
            <div class="mb-4 p-3 rounded-lg bg-amber-100 text-amber-700 text-sm">Ya existe una carrera con ese nombre.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'invalid_data') : ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">Datos inválidos. Verifica nombre y porcentaje (0 a 100).</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'save_error') : ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">No se pudo guardar. Revisa el log del sistema.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'activated') : ?>
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">Carrera activada correctamente.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'deactivated') : ?>
            <div class="mb-4 p-3 rounded-lg bg-yellow-100 text-yellow-800 text-sm">Carrera desactivada correctamente.</div>
        <?php endif; ?>

        <form action="/landingPage_BecasConagopare/public/dashboard-admin?view=scholarships" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="hidden" name="action" value="create_program">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la carrera</label>
                <input
                    type="text"
                    name="program_name"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                    placeholder="Ej: Tecnología en Desarrollo de Software"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">% de beca</label>
                <input
                    type="number"
                    name="scholarship_percentage"
                    min="0"
                    max="100"
                    step="0.01"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                    placeholder="20"
                    required>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                    Guardar carrera
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">🎯 Configuración actual de carreras</h3>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Carrera</th>
                    <th class="px-4 py-3 text-left">% Beca</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($allConfiguredPrograms)) : foreach ($allConfiguredPrograms as $configuredProgram) : ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <?php $formId = 'program-form-' . (int)$configuredProgram['id']; ?>
                        <td class="px-4 py-3">
                            <input
                                type="text"
                                name="program_name"
                                form="<?= $formId ?>"
                                value="<?= htmlspecialchars($configuredProgram['name']) ?>"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                                required>
                        </td>
                        <td class="px-4 py-3">
                            <input
                                type="number"
                                name="scholarship_percentage"
                                form="<?= $formId ?>"
                                min="0"
                                max="100"
                                step="0.01"
                                value="<?= htmlspecialchars(rtrim(rtrim(number_format((float)$configuredProgram['scholarship_percentage'], 2, '.', ''), '0'), '.')) ?>"
                                class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                                required>
                        </td>
                        <td class="px-4 py-3">
                            <?php if ((int)$configuredProgram['is_active'] === 1) : ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Activa</span>
                            <?php else : ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">Inactiva</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <form id="<?= $formId ?>" action="/landingPage_BecasConagopare/public/dashboard-admin?view=scholarships" method="POST" class="inline-block mr-2">
                                <input type="hidden" name="action" value="update_program">
                                <input type="hidden" name="program_id" value="<?= (int)$configuredProgram['id'] ?>">
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                    Actualizar
                                </button>
                            </form>

                            <form action="/landingPage_BecasConagopare/public/dashboard-admin?view=scholarships" method="POST" class="inline-block">
                                <input type="hidden" name="program_id" value="<?= (int)$configuredProgram['id'] ?>">
                                <?php if ((int)$configuredProgram['is_active'] === 1) : ?>
                                    <input type="hidden" name="action" value="deactivate_program">
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                        Desactivar
                                    </button>
                                <?php else : ?>
                                    <input type="hidden" name="action" value="activate_program">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                        Activar
                                    </button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">No hay carreras configuradas todavía.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php endif; ?>

</body>

</html>