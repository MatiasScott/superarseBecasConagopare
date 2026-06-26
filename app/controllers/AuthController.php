<?php

//session_start();
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/LogModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/CantonModel.php';
require_once __DIR__ . '/../models/ParishModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private $userModel;
    private $logModel;
    private $cantonModel;
    private $parishModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->logModel = new LogModel();
        $this->cantonModel = new CantonModel();
        $this->parishModel = new ParishModel();
    }

    public function login()
    {
        $showModal = false;

        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $showModal = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Inicio de sesión exitoso
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['last_activity'] = time();

                // Registra el inicio de sesión
                $this->logModel->logAction($user['id'], 'Inicio de sesión');

                // Redirige según el rol
                if ($user['role'] == 1) {
                    header("Location: " . app_url('/dashboard-admin'));
                } else {
                    header("Location: " . app_url('/student-list'));
                }
                exit();
            } else {
                echo "Correo o contraseña incorrectos.";
            }
        }
        // PENDIENTE: Muestra la vista de login
        require_once __DIR__ . '/../views/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => $_POST['first_name'],
                'second_name' => $_POST['second_name'],
                'first_last_name' => $_POST['first_last_name'],
                'second_last_name' => $_POST['second_last_name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'canton_id' => $_POST['canton_id'],
                'parish_id' => $_POST['parish_id'],
                'role' => 0, // Asegúrate de que este valor esté correcto
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ];

            // Llama al modelo y guarda el ID del nuevo usuario
            $newUserId = $this->userModel->registerUser($data);

            if ($newUserId) {
                // Envía el correo de bienvenida
                $this->sendWelcomeEmail($data['email'], $_POST['password']);

                $this->logModel->logAction($newUserId, 'Registro de nuevo usuario');

                // Redirige a la página de login con un parámetro de éxito
                //header("Location: /landing_becasconagopare/public/login?status=success");
                header("Location: " . app_url('/dashboard-admin'));
                exit();
            } else {
                // Maneja el error
                header("Location: " . app_url('/register?status=error'));
                exit();
            }
        } else {
            // Petición GET, muestra el formulario de registro
            $cantons = $this->cantonModel->getAllCantons();
            require_once __DIR__ . '/../views/register.php';
        }
    }

    public function getParishes()
    {
        error_log("Datos GET recibidos: " . print_r($_GET, true));
        // Verifica que el canton_id sea un número válido y que exista
        if (!isset($_GET['canton_id']) || !is_numeric($_GET['canton_id'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'ID de cantón no proporcionado o inválido.']);
            exit();
        }

        $cantonId = $_GET['canton_id'];

        // Llama al modelo para obtener las parroquias del cantón
        $parishes = $this->parishModel->getParishesByCanton($cantonId);

        // Configura el encabezado para indicar que la respuesta es JSON
        header('Content-Type: application/json');

        // Devuelve los datos de las parroquias en formato JSON
        echo json_encode($parishes);
        exit();
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        header("Location: " . app_url('/login'));
        exit();
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . app_url('/login'));
            exit();
        }

        $userId = (int)$_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($newPassword !== $confirmPassword) {
                header("Location: " . app_url('/change-password?status=not_match'));
                exit();
            }

            if (strlen($newPassword) < 6) {
                header("Location: " . app_url('/change-password?status=weak_password'));
                exit();
            }

            $user = $this->userModel->findUserById($userId);
            if (!$user || !password_verify($currentPassword, $user['password'])) {
                header("Location: " . app_url('/change-password?status=wrong_current'));
                exit();
            }

            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($this->userModel->updatePasswordById($userId, $passwordHash)) {
                $this->logModel->logAction($userId, 'Usuario actualizó su contraseña');
                header("Location: " . app_url('/change-password?status=updated'));
                exit();
            }

            header("Location: " . app_url('/change-password?status=error'));
            exit();
        }

        require_once __DIR__ . '/../views/change-password.php';
    }

    private function sendWelcomeEmail($to, $password)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            // Reemplaza con tus credenciales
            $mail->Username = 'matias.valdivieso@superarse.edu.ec';
            // Usa una contraseña de aplicación si tienes 2FA activado
            $mail->Password = '/Msvs5297*';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración de codificación y remitente
            // Esto es crucial para los caracteres especiales (ñ, tildes)
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('matias.valdivieso@superarse.edu.ec', 'Becas CONAGOPARE - Superarse');
            $mail->addAddress($to);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = '¡Bienvenido a nuestra plataforma!';

            // Estructura de correo con HTML y CSS en línea para un diseño profesional
            $mail->Body = <<<EOT
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    background-color: #ffffff;
                    margin: 30px auto;
                    padding: 20px;
                    max-width: 600px;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    border-top: 5px solid #007BFF;
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                }
                .header h1 {
                    color: #007BFF;
                }
                .content {
                    line-height: 1.6;
                    color: #555;
                }
                .credentials {
                    background-color: #e9ecef;
                    padding: 15px;
                    border-radius: 5px;
                    margin-top: 20px;
                    border-left: 3px solid #007BFF;
                }
                .credentials ul {
                    list-style-type: none;
                    padding: 0;
                }
                .credentials strong {
                    color: #333;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 12px;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>¡Bienvenido a nuestra plataforma!</h1>
                </div>
                <div class="content">
                    <p>Hola,</p>
                    <p>¡Te damos la bienvenida a nuestra plataforma!</p>
                    <p>Tus credenciales para iniciar sesión son:</p>
                    <div class="credentials">
                        <ul>
                            <li><strong>Usuario:</strong> $to</li>
                            <li><strong>Contraseña:</strong> $password</li>
                        </ul>
                    </div>
                    <p>¡Esperamos que disfrutes de la experiencia!</p>
                </div>
                <div class="footer">
                    <p>Este es un mensaje automático, por favor no respondas.</p>
                </div>
            </div>
        </body>
        </html>
EOT;
            $mail->send();
        } catch (Exception $e) {
            // Muestra el error detallado para depuración
            error_log("No se pudo enviar el mensaje. Error de PHPMailer: {$mail->ErrorInfo}");
        }
    }
}
