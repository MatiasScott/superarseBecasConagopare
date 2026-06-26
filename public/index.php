<?php
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
    header("Location: /landingPage_BecasConagopare/public/login");
    exit();
}
$_SESSION['last_activity'] = time(); // Actualiza el tiempo de la última actividad

// Obtenemos la URI completa y eliminamos la parte del subdirectorio
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$basePath = '/landingPage_BecasConagopare/public';

if (strpos($uri, $basePath) === 0) {
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
