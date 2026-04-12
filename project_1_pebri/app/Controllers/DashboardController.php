<?php
class DashboardController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        $data['role'] = $_SESSION['role'];
        $data['nama'] = $_SESSION['nama_lengkap'];
        $this->view('dashboard/index', $data);
    }
}
?>
