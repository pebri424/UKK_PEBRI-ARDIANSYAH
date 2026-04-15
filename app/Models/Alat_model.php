<?php
class Alat_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllEquipment() {
        $this->db->query("SELECT e.*, c.nama_kategori FROM equipment e LEFT JOIN categories c ON e.category_id = c.id");
        return $this->db->resultSet();
    }

    public function getAvailableEquipment() {
        $this->db->query("SELECT e.*, c.nama_kategori FROM equipment e LEFT JOIN categories c ON e.category_id = c.id WHERE stok > 0");
        return $this->db->resultSet();
    }

    public function addEquipment($data) {
        $this->db->query("INSERT INTO equipment (category_id, nama_alat, stok, harga_sewa) VALUES (:category_id, :nama_alat, :stok, :harga_sewa)");
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':nama_alat', $data['nama_alat']);
        $this->db->bind(':stok', $data['stok']);
        $this->db->bind(':harga_sewa', $data['harga_sewa']);
        return $this->db->execute();
    }

    public function deleteEquipment($id) {
        $this->db->query("DELETE FROM equipment WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getEquipmentById($id) {
        $this->db->query("SELECT * FROM equipment WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateStock($id, $jumlah, $op = '-') {
        $this->db->query("UPDATE equipment SET stok = stok $op :jumlah WHERE id = :id");
        $this->db->bind(':jumlah', $jumlah);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getPriceById($id) {
        $this->db->query("SELECT harga_sewa FROM equipment WHERE id = :id");
        $this->db->bind(':id', $id);
        $res = $this->db->single();
        return $res['harga_sewa'];
    }

    public function updateAlat($data)
{

$this->db->query("UPDATE equipment 
SET nama_alat=:nama_alat,
category_id=:category_id,
stok=:stok,
harga_sewa=:harga_sewa
WHERE id=:id");

$this->db->bind(':nama_alat',$data['nama_alat']);
$this->db->bind(':category_id',$data['category_id']);
$this->db->bind(':stok',$data['stok']);
$this->db->bind(':harga_sewa',$data['harga_sewa']);
$this->db->bind(':id',$data['id']);

return $this->db->execute();

}

    public static function getImage($nama_alat) {
        $nama = strtolower($nama_alat);
        if (preg_match('/tend|dome/', $nama)) return 'tenda.png';
        if (preg_match('/carriel|carrier|tas|ransel|daypack/', $nama)) return 'carriel.png';
        if (preg_match('/traking|pole|tongkat/', $nama)) return 'traking_pol.png';
        if (preg_match('/nesting|masak|panci|kompor|gas|spirtus/', $nama)) return 'nesting.png';
        if (preg_match('/slep|sleep|tidur|matras|hammock/', $nama)) return 'sleping_bag.png';
        if (preg_match('/headlamp|senter|lampu|penerangan/', $nama)) return 'headlamp.png';
        return '';
    }
}
?>
