<?php
require_once 'BaseModel.php';

class ParishModel extends BaseModel {
    public function getParishesByCanton($cantonId) {
        $stmt = $this->db->prepare("SELECT id, name FROM parishes WHERE canton_id = :canton_id ORDER BY name ASC");
        $stmt->bindParam(':canton_id', $cantonId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}