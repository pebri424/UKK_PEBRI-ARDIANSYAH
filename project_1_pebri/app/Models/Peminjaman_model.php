<?php
class Peminjaman_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllLoans() {
        $this->db->query("SELECT l.*, u.nama_lengkap, e.nama_alat FROM loans l 
                        JOIN users u ON l.user_id = u.id 
                        JOIN equipment e ON l.equipment_id = e.id");
        return $this->db->resultSet();
    }

    public function getPendingLoans() {
        $this->db->query("SELECT l.*, u.nama_lengkap, e.nama_alat FROM loans l 
                        JOIN users u ON l.user_id = u.id 
                        JOIN equipment e ON l.equipment_id = e.id 
                        WHERE l.status = 'pending'");
        return $this->db->resultSet();
    }

    public function getActiveLoans() {
        $this->db->query("SELECT l.*, u.nama_lengkap, e.nama_alat FROM loans l 
                        JOIN users u ON l.user_id = u.id 
                        JOIN equipment e ON l.equipment_id = e.id 
                        WHERE l.status = 'approved'");
        return $this->db->resultSet();
    }

    public function getReturnedLoans() {
        $this->db->query("SELECT l.*, u.nama_lengkap, e.nama_alat FROM loans l 
                        JOIN users u ON l.user_id = u.id 
                        JOIN equipment e ON l.equipment_id = e.id 
                        WHERE l.status = 'returned'");
        return $this->db->resultSet();
    }

    public function getUserLoans($user_id) {
        $this->db->query("SELECT l.*, e.nama_alat FROM loans l 
                        JOIN equipment e ON l.equipment_id = e.id 
                        WHERE l.user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function addLoan($data) {
        $this->db->query("INSERT INTO loans (user_id, equipment_id, tanggal_pinjam, jumlah, total_harga, status) 
                        VALUES (:user_id, :equipment_id, :tanggal_pinjam, :jumlah, :total_harga, 'pending')");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':equipment_id', $data['equipment_id']);
        $this->db->bind(':tanggal_pinjam', $data['tanggal_pinjam']);
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':total_harga', $data['total_harga']);
        return $this->db->execute();
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE loans SET status = :status";
        if($status === 'returned') $sql .= ", tanggal_kembali = CURDATE()";
        $sql .= " WHERE id = :id";
        
        $this->db->query($sql);
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getLoanById($id) {
        $this->db->query("SELECT * FROM loans WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateLoan($data) {
        $this->db->query("UPDATE loans SET jumlah = :jumlah, total_harga = :total_harga WHERE id = :id");
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':total_harga', $data['total_harga']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }

    public function deleteLoan($id) {
        $this->db->query("DELETE FROM loans WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>
