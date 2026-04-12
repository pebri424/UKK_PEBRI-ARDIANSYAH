<?php
class PeminjamController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'peminjam') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function daftar() {
        $data['equipment'] = $this->model('Alat_model')->getAvailableEquipment();
        $this->view('peminjam/daftar', $data);
    }

    public function pinjam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equip_id = $_POST['equipment_id'];
            $jumlah = $_POST['jumlah'];
            $harga = $this->model('Alat_model')->getPriceById($equip_id);
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'equipment_id' => $equip_id,
                'tanggal_pinjam' => date('Y-m-d'),
                'jumlah' => $jumlah,
                'total_harga' => $harga * $jumlah
            ];

            $this->model('Peminjaman_model')->addLoan($data);
            $this->model('Log_model')->addLog($_SESSION['user_id'], "User mengajukan pinjaman alat ID: $equip_id");
            header('Location: ' . BASEURL . '/peminjam/pinjaman_saya');
            exit;
        }
    }

    public function pinjaman_saya() {
        $data['my_loans'] = $this->model('Peminjaman_model')->getUserLoans($_SESSION['user_id']);
        $this->view('peminjam/pinjaman_saya', $data);
    }

    public function editPinjaman($id) {
        $data['loan'] = $this->model('Peminjaman_model')->getLoanById($id);
        if ($data['loan'] && $data['loan']['user_id'] == $_SESSION['user_id'] && $data['loan']['status'] == 'pending') {
            $data['equipment'] = $this->model('Alat_model')->getEquipmentById($data['loan']['equipment_id']);
            $this->view('peminjam/edit_pinjaman', $data);
        } else {
            header('Location: ' . BASEURL . '/peminjam/pinjaman_saya');
        }
    }

    public function updatePinjaman() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $jumlah = $_POST['jumlah'];
            $loan = $this->model('Peminjaman_model')->getLoanById($id);
            
            if ($loan && $loan['user_id'] == $_SESSION['user_id'] && $loan['status'] == 'pending') {
                $harga = $this->model('Alat_model')->getPriceById($loan['equipment_id']);
                $data = [
                    'id' => $id,
                    'jumlah' => $jumlah,
                    'total_harga' => $harga * $jumlah
                ];
                $this->model('Peminjaman_model')->updateLoan($data);
                $this->model('Log_model')->addLog($_SESSION['user_id'], "User mengupdate jumlah pinjaman ID: $id");
            }
            header('Location: ' . BASEURL . '/peminjam/pinjaman_saya');
            exit;
        }
    }

    public function batalPinjaman($id) {
        $loan = $this->model('Peminjaman_model')->getLoanById($id);
        if ($loan && $loan['user_id'] == $_SESSION['user_id'] && $loan['status'] == 'pending') {
            $this->model('Peminjaman_model')->deleteLoan($id);
            $this->model('Log_model')->addLog($_SESSION['user_id'], "User membatalkan pinjaman ID: $id");
        }
        header('Location: ' . BASEURL . '/peminjam/pinjaman_saya');
        exit;
    }

    public function kembalikan($id) {
        $loan = $this->model('Peminjaman_model')->getLoanById($id);
        if ($loan && $loan['user_id'] == $_SESSION['user_id'] && $loan['status'] == 'approved') {
            $this->model('Peminjaman_model')->updateStatus($id, 'returned');
            $this->model('Alat_model')->updateStock($loan['equipment_id'], $loan['jumlah'], '+');
            $this->model('Log_model')->addLog($_SESSION['user_id'], "User mengembalikan alat pinjaman ID: $id (Stok bertambah)");
        }
        header('Location: ' . BASEURL . '/peminjam/pinjaman_saya');
        exit;
    }
}
?>
