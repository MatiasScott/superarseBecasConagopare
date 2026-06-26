<?php
// Detecta automáticamente la base de despliegue (ej. /landingPage_BecasConagopare/public)
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$detectedBasePath = rtrim(dirname($scriptName), '/');

if (!defined('BASE_PATH')) {
    define('BASE_PATH', $detectedBasePath === '' ? '' : $detectedBasePath);
}

if (!defined('LEGACY_BASE_PATH')) {
    define('LEGACY_BASE_PATH', '/landingPage_BecasConagopare/public');
}

if (!function_exists('app_url')) {
    function app_url($path = '')
    {
        $normalizedPath = '/' . ltrim((string)$path, '/');
        return (BASE_PATH === '' ? '' : BASE_PATH) . $normalizedPath;
    }
}

if (!function_exists('asset_url')) {
    function asset_url($path = '')
    {
        return app_url('/' . ltrim((string)$path, '/'));
    }
}

// Reescribe redirecciones heredadas hardcodeadas al BASE_PATH actual
header_register_callback(function () {
    if (BASE_PATH === LEGACY_BASE_PATH) {
        return;
    }

    foreach (headers_list() as $headerLine) {
        if (stripos($headerLine, 'Location: ') !== 0) {
            continue;
        }

        if (strpos($headerLine, LEGACY_BASE_PATH) === false) {
            continue;
        }

        $rewrittenHeader = str_replace(LEGACY_BASE_PATH, BASE_PATH, $headerLine);
        header_remove('Location');
        header($rewrittenHeader, true);
        break;
    }
});

// Reescribe rutas legacy en HTML renderizado sin tocar todas las vistas
ob_start(function ($buffer) {
    if (BASE_PATH === LEGACY_BASE_PATH) {
        return $buffer;
    }

    if (stripos($buffer, '</head>') !== false && strpos($buffer, 'window.BASE_PATH') === false) {
        $basePathJson = json_encode(BASE_PATH, JSON_UNESCAPED_SLASHES);
        if (is_string($basePathJson)) {
            $basePathScript = "<script>window.BASE_PATH = {$basePathJson};</script>";
            $buffer = preg_replace('/<\/head>/i', $basePathScript . "\n</head>", $buffer, 1) ?? $buffer;
        }
    }

    return str_replace(LEGACY_BASE_PATH, BASE_PATH, $buffer);
});

// Incluimos los controladores necesarios
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/StudentController.php';

// Iniciamos la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lógica de inactividad de la sesión
$session_timeout = 300; // 5 minutos = 300 segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
    header("Location: " . app_url('/login'));
    exit();
}
$_SESSION['last_activity'] = time(); // Actualiza el tiempo de la última actividad

// Obtenemos la URI completa y eliminamos la parte del subdirectorio
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$basePath = BASE_PATH;

if ($basePath !== '' && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Si la URI es la raíz, la normalizamos a '/'
if ($uri === '') {
    $uri = '/';
}

$method = $_SERVER['REQUEST_METHOD'];

// Creamos una instancia de cada controlador
$authController = new AuthController();
$studentController = new StudentController();

if ($uri === '/' || $uri === '/login') {
    $authController->login();
} elseif ($uri === '/register') {
    $authController->register();
} elseif ($uri === '/logout') {
    $authController->logout();
} elseif ($uri === '/change-password') {
    if (method_exists($authController, 'changePassword')) {
        $authController->changePassword();
    } else {
        http_response_code(500);
        echo "No se pudo cargar el módulo de cambio de contraseña";
        exit();
    }
} elseif ($uri === '/student-list') {
    $studentController->listStudents();
} elseif ($uri === '/add-student') {
    $studentController->addStudent();
} elseif ($uri === '/dashboard-admin') {
    $studentController->adminDashboard();
} elseif ($uri === '/export-excel') {
    $studentController->exportToExcel();
} elseif (preg_match('/^\/edit-student\/([0-9]+)$/', $uri, $matches)) {
    $studentId = $matches[1];
    $studentController->editStudent($studentId);
} elseif (preg_match('/^\/delete-student\/([0-9]+)$/', $uri, $matches)) {
    $studentId = $matches[1];
    $studentController->deleteStudent($studentId);
} elseif (preg_match('/^\/student-invoice\/([0-9]+)$/', $uri, $matches)) {
    // ¡Esta expresión regular ahora funciona!
    // Captura el ID del estudiante y lo guarda en $matches[1]
    $studentId = $matches[1];
    $studentController->generateStudentInvoice($studentId);
} elseif ($uri === '/get-parishes') {
    $authController->getParishes();
} elseif ($uri === '/update-student') {
    $studentController->updateStudent();
} else {
    http_response_code(404);
    echo "404 - Página no encontrada";
}
