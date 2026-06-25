<?php
// app/controllers/StudentController.php

// ... (incluye todos los require_once existentes) ...
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController {
    // ... (propiedades y métodos existentes) ...

    public function exportToExcel() {
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
            'Primer Nombre', 'Segundo Nombre', 'Primer Apellido', 'Segundo Apellido',
            'Tipo de ID', 'Número de ID', 'Sexo', 'Correo', 'Teléfono', 'Celular',
            'Fecha de Nacimiento', 'Programa', 'Lugar de Nacimiento', 'Dirección',
            'Lugar de Residencia', 'Barrio'
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
}