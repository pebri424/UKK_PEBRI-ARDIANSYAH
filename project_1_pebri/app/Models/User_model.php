<?php
class User_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil user berdasarkan username
    public function getUserByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    // Register user
    public function register($data) {
        $this->db->query("INSERT INTO users (username, password, nama_lengkap, role) 
                          VALUES (:username, :password, :nama_lengkap, :role)");

        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':role', $data['role']);

        return $this->db->execute();
    }

    // Ambil semua user
    public function getAllUsers() {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }

    // Ambil user berdasarkan ID (untuk edit)
    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Update user
    public function updateUser($data) {
        $this->db->query("UPDATE users 
                          SET username = :username,
                              nama_lengkap = :nama_lengkap,
                              role = :role
                          WHERE id = :id");

        $this->db->bind(':username', $data['username']);
        $this->db->bind(':nama_lengkap', $data['nama_lengkap']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':id', $data['id']);

        return $this->db->execute();
    }

    // Hapus user
    public function deleteUser($id) {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>