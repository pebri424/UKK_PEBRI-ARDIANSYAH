<?php
class HomeController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/index');
            exit;
        }
        header('Location: ' . BASEURL . '/dashboard/index');
        exit;
    }
}
?>
