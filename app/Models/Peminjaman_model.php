<?php
class Peminjaman_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllLoans() {
        $this->db->query("SELECT l.*, u.nama_lengkap, e.nama_alat FROM loans l 
                          JOIN users u ON l.user_id = u.id 
                          JOIN equipment e ON l.equipment_id = e.id 
                          ORDER BY l.tanggal_pinjam DESC");
        return $this->db->resultSet();
    }

    public function getLoanById($id) {
        $this->db->query("SELECT * FROM loans WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getUserLoans($user_id) {
        $this->db->query("SELECT l.*, e.nama_alat FROM loans l 
                          JOIN equipment e ON l.equipment_id = e.id 
                          WHERE l.user_id = :user_id 
                          ORDER BY l.tanggal_pinjam DESC");
        $this->db->bind(':user_id', $user_id);
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

    public function addLoan($data) {
        $this->db->query("INSERT INTO loans (user_id, equipment_id, tanggal_pinjam, tanggal_jatuh_tempo, jumlah, total_harga, status) 
                          VALUES (:user_id, :equipment_id, :tanggal_pinjam, :tanggal_jatuh_tempo, :jumlah, :total_harga, 'pending')");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':equipment_id', $data['equipment_id']);
        $this->db->bind(':tanggal_pinjam', $data['tanggal_pinjam']);
        $this->db->bind(':tanggal_jatuh_tempo', $data['tanggal_jatuh_tempo']);
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':total_harga', $data['total_harga']);
        return $this->db->execute();
    }

    public function updateLoan($data) {
        $this->db->query("UPDATE loans SET jumlah = :jumlah, total_harga = :total_harga WHERE id = :id");
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':total_harga', $data['total_harga']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }

    public function updateStatus($id, $status) {
        $this->db->query("UPDATE loans SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteLoan($id) {
        $this->db->query("DELETE FROM loans WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function prosesKembaliDenganDenda($id, $tanggal_kembali, $kondisi = 'baik', $denda_kerusakan = 0) {
        $this->db->query("CALL sp_kembalikan_alat(:id, :tanggal_kembali, :kondisi, :denda_kerusakan)");
        $this->db->bind(':id', $id);
        $this->db->bind(':tanggal_kembali', $tanggal_kembali);
        $this->db->bind(':kondisi', $kondisi);
        $this->db->bind(':denda_kerusakan', $denda_kerusakan);
        return $this->db->execute();
    }
}