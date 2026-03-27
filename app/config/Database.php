<?php

class Database {
    private $host = 'localhost';
    private $user = 'superar1_Tics';
    private $password = '/Msvs5297*';
    private $dbname = 'superar1_becas_conagopare';
    private $conn;

    public function __construct() {
        // Conectar a la base de datos usando PDO
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}