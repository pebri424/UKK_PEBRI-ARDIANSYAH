<?php
class HomeController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/index');
            exit;
        }
        if ($_SESSION['role'] === 'admin') {
            header('Location: ' . BASEURL . '/admin/user');
        } elseif ($_SESSION['role'] === 'petugas') {
            header('Location: ' . BASEURL . '/petugas/persetujuan');
        } else {
            header('Location: ' . BASEURL . '/peminjam/daftar');
        }
        exit;
    }
}
?>
