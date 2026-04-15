<?php
class PetugasController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'petugas') {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function persetujuan() {
        $data['pending_loans'] = $this->model('Peminjaman_model')->getPendingLoans();
        $this->view('petugas/persetujuan', $data);
    }

    public function prosesSetuju($id) {
        $loan = $this->model('Peminjaman_model')->getLoanById($id);
        if ($loan) {
            $this->model('Peminjaman_model')->updateStatus($id, 'approved');
            $this->model('Alat_model')->updateStock($loan['equipment_id'], $loan['jumlah'], '-');
            $this->model('Log_model')->addLog($_SESSION['user_id'], "Petugas menyetujui pinjaman ID: $id (Stok berkurang)");
        }
        header('Location: ' . BASEURL . '/petugas/persetujuan');
        exit;
    }

    public function prosesTolak($id) {
        $this->model('Peminjaman_model')->updateStatus($id, 'rejected');
        header('Location: ' . BASEURL . '/petugas/persetujuan');
        exit;
    }

    public function pantau() {
        $data['active_loans'] = $this->model('Peminjaman_model')->getActiveLoans();
        $this->view('petugas/pantau', $data);
    }

    public function konfirmasiKembali($id) {
        $loan = $this->model('Peminjaman_model')->getLoanById($id);
        // Pastikan hanya alat yang berstatus 'approved' yang bisa dikembalikan untuk mencegah duplikasi stok
        if ($loan && $loan['status'] === 'approved') {
            $tgl_sekarang = date('Y-m-d H:i:s');
            
            // Ambil data kondisi dan denda kerusakan dari input petugas
            $kondisi = isset($_POST['kondisi']) ? $_POST['kondisi'] : 'baik';
            $denda_kerusakan = isset($_POST['denda_kerusakan']) ? (int)$_POST['denda_kerusakan'] : 0;

            $this->model('Peminjaman_model')->prosesKembaliDenganDenda($id, $tgl_sekarang, $kondisi, $denda_kerusakan);
            
            $this->model('Alat_model')->updateStock($loan['equipment_id'], $loan['jumlah'], '+');
            $this->model('Log_model')->addLog($_SESSION['user_id'], "Petugas konfirmasi pengembalian ID: $id (Stok bertambah)");
        }
        header('Location: ' . BASEURL . '/petugas/pantau');
        exit;
    }

    public function laporan() {
        $data['loans'] = $this->model('Peminjaman_model')->getAllLoans();
        $this->view('petugas/laporan', $data);
    }
}
?>
