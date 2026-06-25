<?php

//session_start();
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/LogModel.php';
require_once __DIR__ . '/../models/CantonModel.php';
require_once __DIR__ . '/../models/ParishModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Fpdf\Fpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController
{
    private $studentModel;
    private $logModel;
    private $cantonModel;
    private $parishModel;
    private $userModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->logModel = new LogModel();
        $this->cantonModel = new CantonModel();
        $this->parishModel = new ParishModel();
        $this->userModel = new UserModel();
    }

    public function listStudents()
    {
        // Verifica si el usuario está autenticado y su rol (esto está bien)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
            header("Location: /landingPage_BecasConagopare/public/login");
            exit();
        }

        // Obtiene el ID del usuario de la sesión
        $registeredByUserId = $_SESSION['user_id'];
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findUserById($userId);

        // Llama a un nuevo método en el modelo para obtener solo los estudiantes del usuario logueado
        $students = $this->studentModel->getStudentsByUserId($registeredByUserId);

        // PENDIENTE: Muestra la vista con la tabla de estudiantes
        require_once __DIR__ . '/../views/student-list.php';
    }

    public function addStudent()
    {
        // Verifica si el usuario está autenticado y su rol
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
            header("Location: /landingPage_BecasConagopare/public/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para asignar la beca automáticamente
            $program = $_POST['program'];
            $scholarship = '20%'; // Valor por defecto

            $programs30Percent = [
                'Tecnología Superior en Topografía',
                'Tecnólogo en Minería',
                'Tecnología Superior en Enfermería Veterinaria',
                'Técnico Superior en Ventas Estratégicas con IA',
                'Tecnólogo en Producción Animal'
            ];

            if (in_array($program, $programs30Percent)) {
                $scholarship = '30%';
            }
            $data = [
                // ... (recupera todos los datos del formulario) ...
                'first_name' => $_POST['first_name'],
                'second_name' => $_POST['second_name'],
                'first_last_name' => $_POST['first_last_name'],
                'second_last_name' => $_POST['second_last_name'],
                'id_type' => $_POST['id_type'],
                'id_number' => $_POST['id_number'],
                'gender' => $_POST['gender'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'cellphone' => $_POST['cellphone'],
                'birth_date' => $_POST['birth_date'],
                'program' => $program,
                'birth_place' => $_POST['birth_place'],
                'address' => $_POST['address'],
                'residence_place' => $_POST['residence_place'],
                'neighborhood' => $_POST['neighborhood'],
                'registered_by_user_id' => $_SESSION['user_id'],
                'scholarship' => $scholarship,
                'academic_period' => $_POST['academic_period'],
                'registration_date' => date('Y-m-d H:i:s'),
            ];

            // Llama al método del modelo una sola vez y almacena el resultado
            if ($this->studentModel->addStudent($data)) {
                $this->logModel->logAction($_SESSION['user_id'], 'Nuevo estudiante registrado');
                header("Location: /landingPage_BecasConagopare/public/student-list");
                exit();
            } else {
                echo "Error al registrar al estudiante.";
            }
        } else {
            // Petición GET, muestra la vista
            require_once __DIR__ . '/../views/add-student.php';
        }
    }

    public function adminDashboard()
    {
        // Verifica que el usuario sea administrador
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
            header("Location: /landingPage_BecasConagopare/public/login");
            exit();
        }

        $view = (isset($_GET['view']) && $_GET['view'] === 'users') ? 'users' : 'students';

        // MÉTRICAS
        $totalStudents     = $this->studentModel->countAllStudents();
        $pendingStudents   = $this->studentModel->countStudentsByStatus('pendiente');
        $approvedStudents  = $this->studentModel->countStudentsByStatus('aprobado');
        $rejectedStudents  = $this->studentModel->countStudentsByStatus('anulado');

        // Obtiene la lista de usuarios para el filtro dinámico en la vista
        $users = $this->userModel->getUsersWithRegisteredStudents();

        // Lista de usuarios del sistema para la vista de usuarios
        $systemUsers = $this->userModel->getSystemUsers();

        // Prepara los filtros basados en los parámetros GET de la URL
        $filters = [];
        if (isset($_GET['program']) && !empty($_GET['program'])) {
            $filters['program'] = $_GET['program'];
        }
        if (isset($_GET['registered_by_user_id']) && !empty($_GET['registered_by_user_id'])) {
            $filters['registered_by_user_id'] = $_GET['registered_by_user_id'];
        }

        // Obtiene la lista de estudiantes filtrada
        $students_filtered = $this->studentModel->getStudentsWithFilters($filters);

        // Carga la vista del dashboard con los datos
        require_once __DIR__ . '/../views/dashboard-admin.php';
    }

    public function getParishes()
    {
        // Asegura que la petición sea AJAX y que se reciba el canton_id
        if (!isset($_GET['canton_id']) || !is_numeric($_GET['canton_id'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Canton ID no proporcionado o inválido.']);
            exit();
        }

        $cantonId = $_GET['canton_id'];
        $parishes = $this->parishModel->getParishesByCanton($cantonId);

        // Establece el encabezado para indicar que la respuesta es JSON
        header('Content-Type: application/json');
        echo json_encode($parishes);
        exit();
    }

    public function exportToExcel()
    {
        // 1. Verificar si el usuario es un administrador (rol 1)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
            header("Location: /landingPage_BecasConagopare/public/login");
            exit();
        }

        // 2. Obtener todos los datos de los estudiantes
        // Puedes usar una versión filtrada si quieres que el filtro de la vista
        // se aplique a la exportación. Para este ejemplo, exportaremos todos.
        $students = $this->studentModel->getAllStudents();

        // 3. Crear el objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 4. Agregar encabezados a la hoja de cálculo
        $headers = [
            'Primer Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Tipo de ID',
            'Número de ID',
            'Sexo',
            'Correo',
            'Teléfono',
            'Celular',
            'Fecha de Nacimiento',
            'Programa',
            'Lugar de Nacimiento',
            'Dirección',
            'Lugar de Residencia',
            'Barrio',
            'Beca',
            'Periodo Academico'
        ];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // 5. Llenar la hoja de cálculo con los datos de los estudiantes
        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $student['first_name']);
            $sheet->setCellValue('B' . $row, $student['second_name']);
            $sheet->setCellValue('C' . $row, $student['first_last_name']);
            $sheet->setCellValue('D' . $row, $student['second_last_name']);
            $sheet->setCellValue('E' . $row, $student['id_type']);
            $sheet->setCellValue('F' . $row, $student['id_number']);
            $sheet->setCellValue('G' . $row, $student['gender']);
            $sheet->setCellValue('H' . $row, $student['email']);
            $sheet->setCellValue('I' . $row, $student['phone']);
            $sheet->setCellValue('J' . $row, $student['cellphone']);
            $sheet->setCellValue('K' . $row, $student['birth_date']);
            $sheet->setCellValue('L' . $row, $student['program']);
            $sheet->setCellValue('M' . $row, $student['birth_place']);
            $sheet->setCellValue('N' . $row, $student['address']);
            $sheet->setCellValue('O' . $row, $student['residence_place']);
            $sheet->setCellValue('P' . $row, $student['neighborhood']);
            $sheet->setCellValue('Q' . $row, $student['scholarship']);
            $sheet->setCellValue('R' . $row, $student['academic_period']);
            $row++;
        }

        // 6. Configurar el nombre del archivo y los encabezados para la descarga
        $filename = 'estudiantes_exportados_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // 7. Crear el escritor y guardar el archivo en el flujo de salida
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // app/controllers/StudentController.php

    public function generateStudentInvoice($studentId)
    {
        // Verifica si el usuario tiene rol 0 para acceder
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
            header("Location: /landingPage_BecasConagopare/public/login");
            exit();
        }

        // Obtener los datos del estudiante
        $student = $this->studentModel->getStudentById($studentId);

        if (!$student) {
            exit("Estudiante no encontrado.");
        }

        // Crear una instancia de Fpdf
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(20, 15, 20);
        $pdf->AddPage();

        // 1. Encabezado con Logos
        // Logo del Instituto Superarse (ajusta la ruta según tu estructura de archivos)
        $pdf->Image(__DIR__ . '/../../public/img/logo_instituto.png', 20, 15, 40);

        // Título del documento
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 45, utf8_decode('ACTA DE INSCRIPCIÓN'), 0, 1, 'C');
        $pdf->SetLineWidth(0.5);
        $pdf->Line(20, 55, 190, 55); // Línea divisoria
        $pdf->Ln(5);

        // 2. Sección de Datos del Estudiante
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('DATOS DEL ESTUDIANTE'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, utf8_decode('Nombre Completo: ' . $student['first_name'] . ' ' . $student['first_last_name']), 0, 1);
        $pdf->Cell(0, 8, utf8_decode('Número de Cédula: ' . $student['id_number']), 0, 1);
        $pdf->Cell(0, 8, utf8_decode('Carrera: ' . $student['program']), 0, 1);
        $pdf->Cell(0, 8, utf8_decode('Beca Asignada: ' . $student['scholarship']), 0, 1);
        $pdf->Ln(10);
        $pdf->SetLineWidth(0.2);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY()); // Línea divisoria
        $pdf->Ln(10);

        // 3. Información de Pago
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('INFORMACIÓN PARA EL PAGO DE MATRÍCULA'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(0, 8, 'BANCO DEL PRODUBANCO', 0, 1, 'L', true);
        $pdf->Cell(0, 6, utf8_decode('Cuenta de Ahorros: 02005290577'), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Nombre del Beneficiario: Instituto Superior Tecnológico Superarse'), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('RUC: 1792951704001'), 0, 1);
        $pdf->Ln(8);

        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(0, 8, 'BANCO DEL GUAYAQUIL', 0, 1, 'L', true);
        $pdf->Cell(0, 6, utf8_decode('Cuenta de Ahorros: 13748241'), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Nombre del Beneficiario: Instituto Superior Tecnológico Superarse'), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('RUC: 1792951704001'), 0, 1);
        $pdf->Ln(10);
        $pdf->SetLineWidth(0.2);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY()); // Línea divisoria
        $pdf->Ln(10);

        // 4. Contactos
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('CONTACTOS DE INTERÉS'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, utf8_decode('Luis Granja (WhatsApp): +593 98 728 9072'), 0, 1);
        $pdf->Cell(0, 8, utf8_decode('Mayra Sarango (WhatsApp): +593 99 265 6109'), 0, 1);
        $pdf->Cell(0, 8, utf8_decode('Lisbeth Ochoa (WhatsApp): +593 98 718 3906'), 0, 1);

        // 5. Pie de página (ejemplo)
        $pdf->SetY(-30);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, utf8_decode('Documento generado el ' . date('d/m/Y') . '. Sujeto a los términos y condiciones de la beca.'), 0, 0, 'C');

        // Salida del PDF
        $pdf->Output('I', utf8_decode('Acta_Beca_' . $student['first_name'] . '.pdf'));
        exit();
    }

    public function updateStudent()
    {
        if (
            !isset($_SESSION['user_id']) ||
            $_SESSION['user_role'] != 1 ||
            $_SERVER['REQUEST_METHOD'] !== 'POST'
        ) {
            header("Location: /landingPage_BecasConagopare/public/login");
            exit();
        }

        $studentData = [
            'id'     => $_POST['id'],
            'status' => $_POST['status']
        ];

        $this->studentModel->updateStudent($studentData);

        // REDIRECCIÓN CORRECTA
        header("Location: /landingPage_BecasConagopare/public/dashboard-admin");
        exit();
    }
}
