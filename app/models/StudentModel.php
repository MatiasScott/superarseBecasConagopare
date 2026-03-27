<?php
require_once 'BaseModel.php';

class StudentModel extends BaseModel
{
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
        $stmt->bindParam(':scholarship', $data['scholarship']);
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
