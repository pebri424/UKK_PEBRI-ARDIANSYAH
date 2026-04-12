<?php
class Log_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllLogs() {
        // Otomatis hapus log yang usianya lebih dari 60 menit
        $this->db->query("DELETE FROM activity_logs WHERE timestamp < NOW() - INTERVAL 60 MINUTE");
        $this->db->execute();

        $this->db->query("SELECT al.*, u.username FROM activity_logs al 
                        JOIN users u ON al.user_id = u.id 
                        ORDER BY al.timestamp DESC");
        return $this->db->resultSet();
    }

    public function addLog($user_id, $action) {
        $this->db->query("INSERT INTO activity_logs (user_id, action) VALUES (:user_id, :action)");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':action', $action);
        return $this->db->execute();
    }
}
?>
