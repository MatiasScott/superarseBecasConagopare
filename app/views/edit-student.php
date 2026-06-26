<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="icon" type="image/png" href="/landingPage_BecasConagopare/public/img/logo_instituto.png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <?php $studentSafe = isset($student) && is_array($student) ? $student : []; ?>
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Editar Estudiante</h2>

        <form action="/landingPage_BecasConagopare/public/edit-student/<?= (int)($studentSafe['id'] ?? 0) ?>" method="POST">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre:</label>
                        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($studentSafe['first_name'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="second_name" class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre:</label>
                        <input type="text" id="second_name" name="second_name" value="<?= htmlspecialchars($studentSafe['second_name'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="first_last_name" class="block text-gray-700 text-sm font-bold mb-2">Primer Apellido:</label>
                        <input type="text" id="first_last_name" name="first_last_name" value="<?= htmlspecialchars($studentSafe['first_last_name'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="second_last_name" class="block text-gray-700 text-sm font-bold mb-2">Segundo Apellido:</label>
                        <input type="text" id="second_last_name" name="second_last_name" value="<?= htmlspecialchars($studentSafe['second_last_name'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="id_type" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Identificación:</label>
                        <select id="id_type" name="id_type" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Seleccione</option>
                            <option value="Cedula" <?= ($studentSafe['id_type'] ?? '') === 'Cedula' ? 'selected' : '' ?>>Cédula</option>
                            <option value="Pasaporte" <?= ($studentSafe['id_type'] ?? '') === 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="id_number" class="block text-gray-700 text-sm font-bold mb-2">Número de Identificación:</label>
                        <input type="text" id="id_number" name="id_number" value="<?= htmlspecialchars($studentSafe['id_number'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Sexo:</label>
                        <select id="gender" name="gender" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Seleccione</option>
                            <option value="Masculino" <?= ($studentSafe['gender'] ?? '') === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                            <option value="Femenino" <?= ($studentSafe['gender'] ?? '') === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="birth_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Nacimiento:</label>
                        <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($studentSafe['birth_date'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Datos de Contacto y Ubicación</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($studentSafe['email'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($studentSafe['phone'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="cellphone" class="block text-gray-700 text-sm font-bold mb-2">Celular:</label>
                        <input type="text" id="cellphone" name="cellphone" value="<?= htmlspecialchars($studentSafe['cellphone'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="birth_place" class="block text-gray-700 text-sm font-bold mb-2">Lugar de Nacimiento:</label>
                        <input type="text" id="birth_place" name="birth_place" value="<?= htmlspecialchars($studentSafe['birth_place'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Dirección:</label>
                        <input type="text" id="address" name="address" value="<?= htmlspecialchars($studentSafe['address'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="residence_place" class="block text-gray-700 text-sm font-bold mb-2">Lugar de Residencia:</label>
                        <input type="text" id="residence_place" name="residence_place" value="<?= htmlspecialchars($studentSafe['residence_place'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="neighborhood" class="block text-gray-700 text-sm font-bold mb-2">Barrio:</label>
                        <input type="text" id="neighborhood" name="neighborhood" value="<?= htmlspecialchars($studentSafe['neighborhood'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Datos Académicos</h3>
                <div class="grid grid-cols-1 gap-4">
                    <div class="mb-4">
                        <label for="program" class="block text-gray-700 text-sm font-bold mb-2">Carrera:</label>
                        <select id="program" name="program" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Seleccione</option>
                            <?php if (!empty($programs)) : foreach ($programs as $program) : ?>
                                <option value="<?= htmlspecialchars($program['name']) ?>" <?= ($studentSafe['program'] ?? '') === $program['name'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($program['name']) ?>
                                </option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Beca asignada</label>
                        <input type="text" id="scholarship-preview"
                            class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700"
                            value="<?= htmlspecialchars($studentSafe['scholarship'] ?? '') ?>"
                            readonly>
                    </div>

                    <div class="mb-4">
                        <label for="academic_period" class="block text-gray-700 text-sm font-bold mb-2">Período Académico:</label>
                        <select id="academic_period" name="academic_period" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Seleccione un período</option>
                            <option value="PAO nov2025 - abr2026" <?= ($studentSafe['academic_period'] ?? '') === 'PAO nov2025 - abr2026' ? 'selected' : '' ?>>PAO nov2025 - abr2026</option>
                            <option value="PAO abr2026 - oct2026" <?= ($studentSafe['academic_period'] ?? '') === 'PAO abr2026 - oct2026' ? 'selected' : '' ?>>PAO abr2026 - oct2026</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Guardar Cambios
                </button>
                <a href="/landingPage_BecasConagopare/public/student-list" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        window.PROGRAM_SCHOLARSHIPS = <?= json_encode($programScholarships ?? [], JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="/landingPage_BecasConagopare/public/js/add_student.js"></script>
</body>

</html>
