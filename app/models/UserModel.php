<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel
{
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(); // Retorna un solo usuario
    }

    public function registerUser($data)
    {
        try {
            $sql = "INSERT INTO users (first_name, second_name, first_last_name, second_last_name, email, phone, canton_id, parish_id, password) VALUES (:first_name, :second_name, :first_last_name, :second_last_name, :email, :phone, :canton_id, :parish_id, :password)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':second_name', $data['second_name']);
            $stmt->bindParam(':first_last_name', $data['first_last_name']);
            $stmt->bindParam(':second_last_name', $data['second_last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':canton_id', $data['canton_id'], PDO::PARAM_INT);
            $stmt->bindParam(':parish_id', $data['parish_id'], PDO::PARAM_INT);
            $stmt->bindParam(':password', $data['password']); // Contraseña hasheada

            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Manejo de errores
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function getUsersWithRegisteredStudents()
    {
        $sql = "SELECT DISTINCT users.id, users.first_name, users.first_last_name 
                FROM users 
                JOIN students ON users.id = students.registered_by_user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserById($userId) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSystemUsers()
    {
        $sql = "SELECT id, first_name, second_name, first_last_name, second_last_name, email, phone, role,
                       CASE
                           WHEN role = 1 THEN 'Administrador'
                           ELSE 'Usuario Normal'
                       END AS role_label
                FROM users
                ORDER BY role DESC, first_name ASC, first_last_name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePasswordById($userId, $passwordHash)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
