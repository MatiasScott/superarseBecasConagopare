<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Estudiantes</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(asset_url('img/logo_instituto.png')) ?>" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6">
    <?php $userSafe = isset($user) && is_array($user) ? $user : []; ?>

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                👋 Hola, <span class="text-indigo-600">
                    <?= htmlspecialchars(($userSafe['first_name'] ?? '') . ' ' . ($userSafe['first_last_name'] ?? '')) ?>
                </span>
            </h1>
            <p class="text-sm text-gray-600">Listado de estudiantes registrados</p>
        </div>

        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="<?= htmlspecialchars(app_url('/add-student')) ?>"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                ➕ Nuevo Estudiante
            </a>

            <a href="<?= htmlspecialchars(app_url('/change-password')) ?>"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                🔑 Cambiar Contraseña
            </a>

            <a href="<?= htmlspecialchars(app_url('/logout')) ?>"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                🔒 Cerrar Sesión
            </a>
        </div>
    </header>

    <!-- BUSCADOR -->
    <div class="mb-4 flex justify-end">
        <input type="text" id="tableSearch"
            placeholder="🔍 Buscar estudiante..."
            class="border rounded-lg p-2 w-full md:w-1/3 focus:ring focus:ring-indigo-200">
    </div>

    <!-- TABLA -->
    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
        <h3 class="text-lg font-bold mb-4 text-gray-700">📋 Estudiantes</h3>

        <table class="min-w-full text-sm" id="studentsTable">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Cédula</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Celular</th>
                    <th class="px-4 py-3 text-left">Carrera</th>
                    <th class="px-4 py-3 text-left">Convenio</th>
                    <th class="px-4 py-3 text-left">Sede</th>
                    <th class="px-4 py-3 text-left">Modalidad</th>
                    <th class="px-4 py-3 text-center">Beca</th>
                    <th class="px-4 py-3 text-left">Periodo</th>
                    <th class="px-4 py-3 text-center">Editar</th>
                    <th class="px-4 py-3 text-center">Eliminar</th>
                    <th class="px-4 py-3 text-center">Acta</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($students)) : foreach ($students as $student) : ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                <?= htmlspecialchars(
                                    trim(
                                        $student['first_name'] . ' ' .
                                            $student['second_name'] . ' ' .
                                            $student['first_last_name'] . ' ' .
                                            $student['second_last_name']
                                    )
                                ) ?>
                            </td>

                            <td class="px-4 py-3"><?= htmlspecialchars($student['id_number']) ?></td>

                            <td class="px-4 py-3"><?= htmlspecialchars($student['email']) ?></td>

                            <td class="px-4 py-3">
                                <a href="https://wa.me/<?= htmlspecialchars($student['cellphone']) ?>"
                                    target="_blank"
                                    class="text-green-600 hover:underline">
                                    <?= htmlspecialchars($student['cellphone']) ?>
                                </a>
                            </td>

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

                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                    <?= htmlspecialchars($student['scholarship']) ?>
                                </span>
                            </td>

                            <td class="px-4 py-3"><?= htmlspecialchars($student['academic_period']) ?></td>

                            <td class="px-4 py-3 text-center">
                                <a href="<?= htmlspecialchars(app_url('/edit-student/' . (int)$student['id'])) ?>"
                                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs shadow">
                                    ✏️ Editar
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="<?= htmlspecialchars(app_url('/delete-student/' . (int)$student['id'])) ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este registro?');">
                                    <button type="submit" class="inline-flex items-center bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg text-xs shadow">
                                        🗑 Eliminar
                                    </button>
                                </form>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="<?= htmlspecialchars(app_url('/student-invoice/' . (int)$student['id'])) ?>"
                                    target="_blank"
                                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-xs shadow">
                                    📄 Ver Acta
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="13" class="text-center py-6 text-gray-500">
                            No hay estudiantes registrados.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JS BUSCADOR -->
    <script src="<?= htmlspecialchars(asset_url('js/stundet_list.js')) ?>"></script>

</body>

</html>