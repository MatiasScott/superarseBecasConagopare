<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contraseña</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(asset_url('img/logo_instituto.png')) ?>" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Actualizar Contraseña</h1>
        <p class="text-sm text-gray-600 mb-6">Ingresa tu contraseña actual y define una nueva contraseña segura.</p>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'updated') : ?>
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">Contraseña actualizada correctamente.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'wrong_current') : ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">La contraseña actual no es correcta.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'not_match') : ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">La nueva contraseña y su confirmación no coinciden.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'weak_password') : ?>
            <div class="mb-4 p-3 rounded-lg bg-amber-100 text-amber-700 text-sm">La nueva contraseña debe tener al menos 6 caracteres.</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">No se pudo actualizar la contraseña.</div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(app_url('/change-password')) ?>" method="POST" class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label>
                <input type="password" id="current_password" name="current_password" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                <input type="password" id="new_password" name="new_password" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" minlength="6" required>
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar nueva contraseña</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" minlength="6" required>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    Guardar
                </button>
                <a href="<?= (isset($_SESSION['user_role']) && (int)$_SESSION['user_role'] === 1) ? htmlspecialchars(app_url('/dashboard-admin')) : htmlspecialchars(app_url('/student-list')) ?>"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                    Volver
                </a>
            </div>
        </form>
    </div>
</body>

</html>
