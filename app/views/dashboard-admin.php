<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="icon" type="image/png" href="/img/logo_instituto.png" />
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
            <p class="text-sm text-gray-600">Gestión de estudiantes</p>
        </div>
        <div class="flex space-x-2 mt-4 md:mt-0">
            <a href="/register"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                ➕ Registrar Usuario
            </a>
            <a href="/logout"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                🔒 Cerrar Sesión
            </a>
        </div>
    </header>

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

    <!-- Filtros -->
    <div class="bg-white p-6 rounded-2xl shadow-lg mb-6">
            <h3 class="text-lg font-bold mb-4 text-gray-700">🔍 Filtros</h3>
    
            <form action="/landing_becasconagopare/public/dashboard-admin" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
    
                <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
        <select id="program" name="program"
            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
            
            <option value="">Todas</option>
    
            <option value="Técnico Superior en Ventas Estratégicas con IA">
                Técnico Superior en Ventas Estratégicas con IA
            </option>
    
            <option value="Tecnólogo en Educación Básica">
                Tecnólogo en Educación Básica
            </option>
    
            <option value="Tecnología Superior en Enfermería Veterinaria">
                Tecnología Superior en Enfermería Veterinaria
            </option>
    
            <option value="Tecnólogo en Producción Animal">
                Tecnólogo en Producción Animal
            </option>
    
            <option value="Técnico Superior en Marketing Digital">
                Técnico Superior en Marketing Digital
            </option>
    
            <option value="Seguridad e Higiene del Trabajo">
                Seguridad e Higiene del Trabajo
            </option>
    
            <option value="Seguridad y Prevención de Riesgos Laborales">
                Seguridad y Prevención de Riesgos Laborales
            </option>
    
            <option value="Técnico Superior en Administración">
                Técnico Superior en Administración
            </option>
    
            <option value="Tecnología Superior en Topografía">
                Tecnología Superior en Topografía
            </option>
    
            <option value="Tecnólogo en Minería">
                Tecnólogo en Minería
            </option>
    
        </select>
    </div>


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Registrado por</label>
                <select id="registered_by_user_id" name="registered_by_user_id"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
                    <option value="">Todos</option>
                    <?php if (!empty($users)) : foreach ($users as $user) : ?>
                            <option value="<?= $user['id'] ?>">
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
                <a href="/landing_becasconagopare/public/export-excel"
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

            <form action="/landing_becasconagopare/public/update-student" method="POST" class="space-y-4">
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
    <script src="/js/dashboardAdmin.js"></script>

</body>

</html>