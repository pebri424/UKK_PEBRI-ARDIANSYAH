<?php
class Kategori_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCategories() {
        $this->db->query("SELECT * FROM categories");
        return $this->db->resultSet();
    }

    public function addCategory($nama) {
        $this->db->query("INSERT INTO categories (nama_kategori) VALUES (:nama)");
        $this->db->bind(':nama', $nama);
        return $this->db->execute();
    }

    public function updateCategory($data) {
        $this->db->query("UPDATE categories SET nama_kategori = :nama_kategori WHERE id = :id");
        $this->db->bind(':nama_kategori', $data['nama_kategori']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }

    public function deleteCategory($id) {
        $this->db->query("DELETE FROM categories WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>
