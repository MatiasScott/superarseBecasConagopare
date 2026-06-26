<?php
require_once 'BaseModel.php';

class StudentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->ensureStudentExtraColumns();
    }

    private function ensureStudentExtraColumns()
    {
        $columnsToEnsure = [
            'is_convenio' => "ALTER TABLE students ADD COLUMN is_convenio TINYINT(1) NOT NULL DEFAULT 0",
            'convenio_name' => "ALTER TABLE students ADD COLUMN convenio_name VARCHAR(255) NULL",
            'convenio_percentage' => "ALTER TABLE students ADD COLUMN convenio_percentage DECIMAL(5,2) NULL",
            'sede' => "ALTER TABLE students ADD COLUMN sede VARCHAR(150) NULL",
            'modalidad' => "ALTER TABLE students ADD COLUMN modalidad VARCHAR(100) NULL",
        ];

        foreach ($columnsToEnsure as $column => $sql) {
            if (!$this->columnExists($column)) {
                $this->db->exec($sql);
            }
        }
    }

    private function columnExists($columnName)
    {
        $stmt = $this->db->prepare("SHOW COLUMNS FROM students LIKE :column_name");
        $stmt->bindParam(':column_name', $columnName, PDO::PARAM_STR);
        $stmt->execute();

        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllStudents()
    {
        $stmt = $this->db->prepare("SELECT * FROM students");
        $stmt->execute();
        return $stmt->fetchAll(); // Retorna todos los estudiantes
    }

    public function getStudentsByUserId($userId)
    {
        try {
            // Prepara la consulta para seleccionar solo los estudiantes de un usuario específico
            $sql = "SELECT * FROM students WHERE registered_by_user_id = :user_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener estudiantes por usuario: " . $e->getMessage());
            return [];
        }
    }

    public function addStudent($data)
    {
        // Añade la columna 'registered_by_user_id' a tu consulta SQL
        $sql = "INSERT INTO students (
                first_name, 
                second_name, 
                first_last_name, 
                second_last_name, 
                id_type, 
                id_number, 
                gender, 
                email, 
                phone, 
                cellphone, 
                birth_date, 
                program, 
                birth_place, 
                address, 
                residence_place, 
                neighborhood,
                registered_by_user_id,
                is_convenio,
                convenio_name,
                convenio_percentage,
                sede,
                modalidad,
                scholarship,
                academic_period,
                registration_date
            ) VALUES (
                :first_name, 
                :second_name, 
                :first_last_name, 
                :second_last_name, 
                :id_type, 
                :id_number, 
                :gender, 
                :email, 
                :phone, 
                :cellphone, 
                :birth_date, 
                :program, 
                :birth_place, 
                :address, 
                :residence_place, 
                :neighborhood,
                :registered_by_user_id,
                :is_convenio,
                :convenio_name,
                :convenio_percentage,
                :sede,
                :modalidad,
                :scholarship,
                :academic_period,
                :registration_date
            )";

        $stmt = $this->db->prepare($sql);

        // ... todos los bindParam existentes ...
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':second_name', $data['second_name']);
        $stmt->bindParam(':first_last_name', $data['first_last_name']);
        $stmt->bindParam(':second_last_name', $data['second_last_name']);
        $stmt->bindParam(':id_type', $data['id_type']);
        $stmt->bindParam(':id_number', $data['id_number']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':cellphone', $data['cellphone']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':program', $data['program']);
        $stmt->bindParam(':birth_place', $data['birth_place']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':residence_place', $data['residence_place']);
        $stmt->bindParam(':neighborhood', $data['neighborhood']);
        $stmt->bindParam(':registered_by_user_id', $data['registered_by_user_id']);
        $stmt->bindParam(':is_convenio', $data['is_convenio'], PDO::PARAM_INT);
        $stmt->bindParam(':scholarship', $data['scholarship']);
        $stmt->bindParam(':convenio_name', $data['convenio_name']);
        $stmt->bindParam(':convenio_percentage', $data['convenio_percentage']);
        $stmt->bindParam(':sede', $data['sede']);
        $stmt->bindParam(':modalidad', $data['modalidad']);
        $stmt->bindParam(':academic_period', $data['academic_period']);
        $stmt->bindParam(':registration_date', $data['registration_date']);

        return $stmt->execute();
    }

    public function getStudentsByCanton($cantonId)
    {
        $sql = "SELECT s.* FROM students s
                INNER JOIN users u ON s.registered_by_user_id = u.id
                WHERE u.canton_id = :canton_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':canton_id', $cantonId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getStudentsWithFilters($filters)
    {
        $sql = "SELECT 
                s.*, 
                u.first_name AS user_first_name, 
                u.first_last_name AS user_first_last_name 
            FROM 
                students s
            JOIN 
                users u ON s.registered_by_user_id = u.id
            WHERE 1=1";
        $params = [];

        if (isset($filters['program'])) {
            $sql .= " AND program = :program";
            $params[':program'] = $filters['program'];
        }

        if (isset($filters['registered_by_user_id'])) {
            $sql .= " AND registered_by_user_id = :registered_by_user_id";
            $params[':registered_by_user_id'] = $filters['registered_by_user_id'];
        }

        // Puedes agregar más ORDER BY si lo necesitas
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentById($studentId)
    {
        try {
            // Prepara la consulta para seleccionar un estudiante por su ID
            $stmt = $this->db->prepare("SELECT * FROM students WHERE id = :id");
            $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
            $stmt->execute();

            // Devuelve el estudiante como un array asociativo
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener estudiante por ID: " . $e->getMessage());
            return false;
        }
    }

    public function updateStudent($data)
    {
        $sql = "UPDATE students SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getStudentByIdAndUserId($studentId, $userId)
    {
        $sql = "SELECT *
                FROM students
                WHERE id = :id
                  AND registered_by_user_id = :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudentByUser($data)
    {
        $sql = "UPDATE students
                SET first_name = :first_name,
                    second_name = :second_name,
                    first_last_name = :first_last_name,
                    second_last_name = :second_last_name,
                    id_type = :id_type,
                    id_number = :id_number,
                    gender = :gender,
                    email = :email,
                    phone = :phone,
                    cellphone = :cellphone,
                    birth_date = :birth_date,
                    program = :program,
                    birth_place = :birth_place,
                    address = :address,
                    residence_place = :residence_place,
                    neighborhood = :neighborhood,
                    is_convenio = :is_convenio,
                    convenio_name = :convenio_name,
                    convenio_percentage = :convenio_percentage,
                    sede = :sede,
                    modalidad = :modalidad,
                    scholarship = :scholarship,
                    academic_period = :academic_period
                WHERE id = :id
                  AND registered_by_user_id = :registered_by_user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':second_name', $data['second_name']);
        $stmt->bindParam(':first_last_name', $data['first_last_name']);
        $stmt->bindParam(':second_last_name', $data['second_last_name']);
        $stmt->bindParam(':id_type', $data['id_type']);
        $stmt->bindParam(':id_number', $data['id_number']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':cellphone', $data['cellphone']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':program', $data['program']);
        $stmt->bindParam(':birth_place', $data['birth_place']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':residence_place', $data['residence_place']);
        $stmt->bindParam(':neighborhood', $data['neighborhood']);
        $stmt->bindParam(':is_convenio', $data['is_convenio'], PDO::PARAM_INT);
        $stmt->bindParam(':convenio_name', $data['convenio_name']);
        $stmt->bindParam(':convenio_percentage', $data['convenio_percentage']);
        $stmt->bindParam(':sede', $data['sede']);
        $stmt->bindParam(':modalidad', $data['modalidad']);
        $stmt->bindParam(':scholarship', $data['scholarship']);
        $stmt->bindParam(':academic_period', $data['academic_period']);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':registered_by_user_id', $data['registered_by_user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }
    
    public function countAllStudents()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM students");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function countStudentsByStatus($status)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM students WHERE status = :status");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function getDistinctProgramsByUser($userId)
    {
        $sql = "SELECT DISTINCT program
                FROM students
                WHERE program IS NOT NULL
                  AND program <> ''
                  AND registered_by_user_id = :user_id
                ORDER BY program ASC";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
