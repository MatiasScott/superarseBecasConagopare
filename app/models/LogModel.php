<?php
require_once 'BaseModel.php';

class LogModel extends BaseModel {
    public function logAction($userId, $action, $details = null) {
        $sql = "INSERT INTO activity_log (user_id, action, details) VALUES (:user_id, :action, :details)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':details', $details);
        
        return $stmt->execute();
    }
}