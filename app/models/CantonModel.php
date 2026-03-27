<?php
require_once 'BaseModel.php';

class CantonModel extends BaseModel {
    public function getAllCantons() {
        $stmt = $this->db->query("SELECT id, name FROM cantons ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}