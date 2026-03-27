<?php
// Incluimos la clase de conexión a la base de datos
require_once __DIR__ . '/../config/Database.php';

class BaseModel {
    protected $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $database = new Database();
        $this->db = $database->getConnection();
    }
}